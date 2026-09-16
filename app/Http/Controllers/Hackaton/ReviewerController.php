<?php

namespace App\Http\Controllers\Hackaton;

use App\Http\Controllers\Controller;
use App\Models\HackatonSubmission;
use App\Models\HackatonFieldValue;
use App\Models\HackatonReview;
use App\Models\HackatonSubmissionFieldValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    /**
     * Reviewer dashboard stats.
     */
    public function dashboard()
    {
        $userId = Auth::id();

        $assigned = HackatonSubmission::whereHas('reviewers', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })->count();

        $reviewed = HackatonReview::where('reviewer_id', $userId)
            ->distinct('hackaton_submission_id')
            ->count('hackaton_submission_id');

        $pending = max(0, $assigned - $reviewed);

        return view('subdirektorat-inovasi.hackaton.reviewer.dashboard', compact('assigned', 'reviewed', 'pending'));
    }

    /**
     * List assigned submissions.
     */
    public function index()
    {
        $userId = Auth::id();

        $submissions = HackatonSubmission::whereHas('reviewers', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
            ->with(['session', 'user', 'submissionTahap.tahap'])
            ->latest()
            ->paginate(15);

        $reviewedSubmissionIds = HackatonReview::where('reviewer_id', $userId)
            ->pluck('hackaton_submission_id')
            ->unique();

        return view('subdirektorat-inovasi.hackaton.reviewer.assignments.index', compact('submissions', 'reviewedSubmissionIds'));
    }

    /**
     * Show submission detail for review.
     */
    public function show(HackatonSubmission $submission)
    {
        $userId = Auth::id();

        abort_unless(
            $submission->reviewers()->where('users.id', $userId)->exists() || Auth::user()->role === 'admin_hackaton',
            403,
            'Anda tidak ditugaskan untuk proposal ini.'
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

        $submittedTahap = $submission->submissionTahap
            ->where('status', 'diajukan')
            ->sortBy(fn($st) => $st->tahap->tahap_ke);

        foreach ($submittedTahap as $st) {
            $st->loadedFieldValues = HackatonSubmissionFieldValue::where('hackaton_submission_id', $submission->id)
                ->where('hackaton_tahap_id', $st->hackaton_tahap_id)
                ->get()
                ->keyBy('hackaton_tahap_field_id');
        }

        $myReviews = HackatonReview::where('hackaton_submission_id', $submission->id)
            ->where('reviewer_id', $userId)
            ->get()
            ->keyBy('hackaton_tahap_id');

        return view('subdirektorat-inovasi.hackaton.reviewer.assignments.show', compact('submission', 'submittedTahap', 'myReviews'));
    }

    /**
     * Store or update a review.
     */
    public function storeReview(Request $request, HackatonSubmission $submission, $tahapId)
    {
        $userId = Auth::id();

        abort_unless(
            $submission->reviewers()->where('users.id', $userId)->exists() || Auth::user()->role === 'admin_hackaton',
            403
        );

        $request->validate([
            'komentar'  => 'required|string|max:5000',
            'skor'      => 'required|integer|min:0|max:100',
            'penilaian' => 'nullable|string|max:5000',
        ]);

        HackatonReview::updateOrCreate(
            [
                'hackaton_submission_id' => $submission->id,
                'hackaton_tahap_id'      => $tahapId,
                'reviewer_id'            => $userId,
            ],
            [
                'komentar'  => $request->komentar,
                'skor'      => $request->skor,
                'penilaian' => $request->penilaian,
            ]
        );

        return back()->with('success', 'Penilaian review berhasil disimpan.');
    }
}
