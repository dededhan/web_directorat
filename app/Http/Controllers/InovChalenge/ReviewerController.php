<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeFieldValue;
use App\Models\InovChalengeReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    /**
     * Reviewer dashboard — stats: assigned, reviewed, pending.
     */
    public function dashboard()
    {
        $userId = Auth::id();

        $assigned = InovChalengeSubmission::whereHas('reviewers', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })->count();

        $reviewed = InovChalengeReview::where('reviewer_id', $userId)
            ->distinct('inov_chalenge_submission_id')
            ->count('inov_chalenge_submission_id');

        $pending = $assigned - $reviewed;
        if ($pending < 0) $pending = 0;

        return view('reviewer_inovchalenge.dashboard', compact('assigned', 'reviewed', 'pending'));
    }

    /**
     * List assigned submissions.
     */
    public function index()
    {
        $userId = Auth::id();

        $submissions = InovChalengeSubmission::whereHas('reviewers', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
            ->with(['session', 'user', 'submissionTahap.tahap'])
            ->latest()
            ->paginate(15);

        // Pre-load review status per submission for the current reviewer
        $reviewedSubmissionIds = InovChalengeReview::where('reviewer_id', $userId)
            ->pluck('inov_chalenge_submission_id')
            ->unique();

        return view('reviewer_inovchalenge.assignments.index', compact('submissions', 'reviewedSubmissionIds'));
    }

    /**
     * Show submission detail — per-Tahap tabs with field values + review form.
     */
    public function show(InovChalengeSubmission $submission)
    {
        $userId = Auth::id();

        // Ensure reviewer is assigned to this submission
        abort_unless(
            $submission->reviewers()->where('users.id', $userId)->exists(),
            403,
            'Anda tidak ditugaskan untuk submission ini.'
        );

        $submission->load([
            'session',
            'user',
            'submissionTahap.tahap.fields',
            'submissionTahap.tahap.sections.fields',
            'submissionTahap.tahap.unsectionedFields',
            'members.user',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        // Only show Tahap that have been submitted (diajukan)
        $submittedTahap = $submission->submissionTahap
            ->where('status', 'diajukan')
            ->sortBy(fn($st) => $st->tahap->tahap_ke);

        // Load field values for each submitted tahap
        foreach ($submittedTahap as $st) {
            $st->loadedFieldValues = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
                ->where('inov_chalenge_tahap_id', $st->inov_chalenge_tahap_id)
                ->get()
                ->keyBy('inov_chalenge_tahap_field_id');
        }

        // Load this reviewer's existing reviews for this submission
        $myReviews = InovChalengeReview::where('inov_chalenge_submission_id', $submission->id)
            ->where('reviewer_id', $userId)
            ->get()
            ->keyBy('inov_chalenge_tahap_id');

        return view('reviewer_inovchalenge.assignments.show', compact('submission', 'submittedTahap', 'myReviews'));
    }

    /**
     * Store or update a review for a specific Tahap.
     */
    public function storeReview(Request $request, InovChalengeSubmission $submission, $tahapId)
    {
        $userId = Auth::id();

        abort_unless(
            $submission->reviewers()->where('users.id', $userId)->exists(),
            403
        );

        $request->validate([
            'komentar' => 'required|string|max:5000',
            'skor' => 'required|integer|min:0|max:100',
            'penilaian' => 'nullable|string|max:5000',
        ]);

        InovChalengeReview::updateOrCreate(
            [
                'inov_chalenge_submission_id' => $submission->id,
                'inov_chalenge_tahap_id' => $tahapId,
                'reviewer_id' => $userId,
            ],
            [
                'komentar' => $request->komentar,
                'skor' => $request->skor,
                'penilaian' => $request->penilaian,
            ]
        );

        return back()->with('success', 'Review berhasil disimpan.');
    }
}
