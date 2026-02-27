<?php

namespace App\Http\Controllers\InovChallenge\Admin;

use App\Http\Controllers\Controller;
use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InovChallengeReviewerController extends Controller
{
    /**
     * Show the form for assigning reviewers.
     */
    public function showAssignForm(Request $request)
    {
        // Get all submissions that need reviewers (submitted or under_review)
        $submissions = InovChallengeSubmission::with(['session', 'user', 'reviews'])
            ->whereHas('session', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all users with reviewer role
        $reviewers = User::role('reviewer_inovchalange')->get();

        // Calculate workload for each reviewer
        $reviewerWorkload = [];
        foreach ($reviewers as $reviewer) {
            $activeReviews = InovChallengeReview::where('reviewer_id', $reviewer->id)
                ->whereIn('status', ['assigned', 'in_progress'])
                ->count();
            $completedReviews = InovChallengeReview::where('reviewer_id', $reviewer->id)
                ->where('status', 'completed')
                ->count();

            $reviewerWorkload[$reviewer->id] = [
                'active' => $activeReviews,
                'completed' => $completedReviews,
                'total' => $activeReviews + $completedReviews,
            ];
        }

        // Get selected submission if provided
        $selectedSubmission = null;
        if ($request->filled('submission')) {
            $selectedSubmission = InovChallengeSubmission::with(['session', 'user', 'teamMembers', 'reviews.reviewer'])
                ->find($request->submission);
        }

        return view('inov_challenge.admin.reviewers.assign', compact('submissions', 'reviewers', 'reviewerWorkload', 'selectedSubmission'));
    }

    /**
     * Assign a reviewer to a submission for a specific phase.
     */
    public function assign(Request $request)
    {
        $validated = $request->validate([
            'submission_id' => 'required|exists:inov_challenge_submissions,id',
            'reviewer_id' => 'required|exists:users,id',
            'phase' => ['required', Rule::in(['phase_1', 'phase_2', 'phase_3'])],
        ]);

        // Verify reviewer has the correct role
        $reviewer = User::findOrFail($validated['reviewer_id']);
        if (!$reviewer->hasRole('reviewer_inovchalange')) {
            return back()->with('error', 'User yang dipilih tidak memiliki role reviewer_inovchalange.');
        }

        $submission = InovChallengeSubmission::findOrFail($validated['submission_id']);
        $phase = $validated['phase'];
        $phaseStatusField = $phase . '_status';

        // Check if submission phase is submitted or under review
        if (!in_array($submission->$phaseStatusField, ['submitted', 'under_review'])) {
            return back()->with('error', 'Submission harus dalam status submitted atau under_review untuk dapat ditugaskan reviewer.');
        }

        // Check if reviewer is already assigned to this submission and phase
        $existingReview = $submission->reviews()
            ->where('reviewer_id', $validated['reviewer_id'])
            ->where('phase', $phase)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Reviewer ini sudah ditugaskan untuk submission dan phase tersebut.');
        }

        // Check if reviewer is the submission creator or team member
        if ($submission->user_id === $validated['reviewer_id']) {
            return back()->with('error', 'Reviewer tidak dapat meninjau submission sendiri.');
        }

        $isTeamMember = $submission->teamMembers()
            ->where('user_id', $validated['reviewer_id'])
            ->exists();

        if ($isTeamMember) {
            return back()->with('error', 'Reviewer tidak dapat meninjau submission dimana mereka adalah anggota tim.');
        }

        try {
            DB::beginTransaction();

            // Create review assignment
            $review = InovChallengeReview::create([
                'submission_id' => $validated['submission_id'],
                'reviewer_id' => $validated['reviewer_id'],
                'phase' => $phase,
                'status' => 'assigned',
                'assigned_at' => now(),
            ]);

            // Update submission phase status to under_review if not already
            if ($submission->$phaseStatusField !== 'under_review') {
                $submission->update([
                    $phaseStatusField => 'under_review',
                ]);
            }

            // Create notification for reviewer
            $review->notifyReviewerAssigned();

            DB::commit();

            return back()->with('success', 'Reviewer berhasil ditugaskan untuk submission.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menugaskan reviewer: ' . $e->getMessage());
        }
    }

    /**
     * Remove a reviewer from a submission.
     */
    public function remove(InovChallengeReview $review)
    {
        // Check if review is already completed
        if ($review->status === 'completed') {
            return back()->with('error', 'Reviewer tidak dapat dihapus karena sudah menyelesaikan review.');
        }

        try {
            DB::beginTransaction();

            $submissionId = $review->submission_id;
            $reviewerId = $review->reviewer_id;
            $phase = $review->phase;

            // Delete the review
            $review->delete();

            // Check if there are other reviewers for this submission and phase
            $submission = InovChallengeSubmission::findOrFail($submissionId);
            $phaseStatusField = $phase . '_status';

            $hasOtherReviewers = $submission->reviews()
                ->where('phase', $phase)
                ->exists();

            // If no other reviewers, change status back to submitted
            if (!$hasOtherReviewers && $submission->$phaseStatusField === 'under_review') {
                $submission->update([
                    $phaseStatusField => 'submitted',
                ]);
            }

            DB::commit();

            return back()->with('success', 'Reviewer berhasil dihapus dari submission.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus reviewer: ' . $e->getMessage());
        }
    }

    /**
     * Reassign a review to a different reviewer.
     */
    public function reassign(Request $request, InovChallengeReview $review)
    {
        $validated = $request->validate([
            'new_reviewer_id' => 'required|exists:users,id',
        ]);

        // Check if review is already completed
        if ($review->status === 'completed') {
            return back()->with('error', 'Review yang sudah selesai tidak dapat dipindahkan.');
        }

        // Verify new reviewer has the correct role
        $newReviewer = User::findOrFail($validated['new_reviewer_id']);
        if (!$newReviewer->hasRole('reviewer_inovchalange')) {
            return back()->with('error', 'User yang dipilih tidak memiliki role reviewer_inovchalange.');
        }

        // Check if new reviewer is the same as current
        if ($review->reviewer_id === $validated['new_reviewer_id']) {
            return back()->with('error', 'Reviewer baru sama dengan reviewer saat ini.');
        }

        // Check if new reviewer is already assigned to this submission and phase
        $existingReview = InovChallengeReview::where('submission_id', $review->submission_id)
            ->where('reviewer_id', $validated['new_reviewer_id'])
            ->where('phase', $review->phase)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Reviewer baru sudah ditugaskan untuk submission dan phase ini.');
        }

        $submission = $review->submission;

        // Check if new reviewer is the submission creator or team member
        if ($submission->user_id === $validated['new_reviewer_id']) {
            return back()->with('error', 'Reviewer tidak dapat meninjau submission sendiri.');
        }

        $isTeamMember = $submission->teamMembers()
            ->where('user_id', $validated['new_reviewer_id'])
            ->exists();

        if ($isTeamMember) {
            return back()->with('error', 'Reviewer tidak dapat meninjau submission dimana mereka adalah anggota tim.');
        }

        try {
            DB::beginTransaction();

            $oldReviewerId = $review->reviewer_id;

            // Update reviewer
            $review->update([
                'reviewer_id' => $validated['new_reviewer_id'],
                'status' => 'assigned',
                'assigned_at' => now(),
                'score' => null,
                'feedback' => null,
                'review_criteria' => null,
                'reviewed_at' => null,
            ]);

            // Create notification for new reviewer
            $review->notifyReviewerAssigned();

            DB::commit();

            return back()->with('success', 'Review berhasil dipindahkan ke reviewer baru.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memindahkan review: ' . $e->getMessage());
        }
    }
}
