<?php

namespace App\Http\Controllers\InovChalenge\AdminPanel;

use App\Http\Controllers\InovChalenge\SubmissionAdminController as BaseController;
use App\Models\InovChalengeSession;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeFieldValue;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Submission admin controller for Admin InovChallenge panel.
 * Extends the original SubmissionAdminController but returns admin_inovchalenge views.
 */
class SubmissionAdminController extends BaseController
{
    public function index(Request $request, InovChalengeSession $session)
    {
        $query = InovChalengeSubmission::with(['user', 'submissionTahap.tahap', 'members', 'reviewers'])
            ->withCount('reviewers')
            ->where('inov_chalenge_session_id', $session->id);

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $submissions = $query->latest()->paginate(15)->withQueryString();

        $session->load('tahap');
        $hasReviewerMap = [];
        foreach ($submissions as $sub) {
            $hasReviewerMap[$sub->id] = $sub->reviewers->isNotEmpty();
        }

        return view('admin_inovchalenge.inovchalenge.submissions.index', compact('submissions', 'session', 'hasReviewerMap'));
    }

    public function show(InovChalengeSession $session, InovChalengeSubmission $submission)
    {
        abort_if($submission->inov_chalenge_session_id !== $session->id, 404);

        $submission->load([
            'session',
            'user',
            'submissionTahap.tahap.fields',
            'submissionTahap.tahap.sections.fields',
            'submissionTahap.tahap.unsectionedFields',
            'members.user',
            'reviewers',
            'reviews.reviewer',
            'reviews.tahap',
            'identitas',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        foreach ($submission->submissionTahap as $st) {
            $st->loadedFieldValues = InovChalengeFieldValue::where('inov_chalenge_submission_id', $submission->id)
                ->where('inov_chalenge_tahap_id', $st->inov_chalenge_tahap_id)
                ->get()
                ->keyBy('inov_chalenge_tahap_field_id');
        }

        $availableReviewers = User::where('role', 'reviewer_inovchalenge')
            ->orderBy('name')
            ->get();

        $hasReviewer = $submission->reviewers->isNotEmpty();

        return view('admin_inovchalenge.inovchalenge.submissions.show', compact('submission', 'availableReviewers', 'session', 'hasReviewer'));
    }

    public function scores(InovChalengeSession $session)
    {
        $session->load('tahap');
        $tahapList = $session->tahap;

        $submissions = InovChalengeSubmission::with([
            'user',
            'reviews' => fn($q) => $q->select('inov_chalenge_submission_id', 'inov_chalenge_tahap_id', 'reviewer_id', 'skor'),
            'reviewers',
            'identitas',
        ])
            ->withCount('reviewers')
            ->where('inov_chalenge_session_id', $session->id)
            ->get();

        $scoreMap = [];
        foreach ($submissions as $sub) {
            $tahapScores = [];
            foreach ($tahapList as $tahap) {
                $tahapReviews = $sub->reviews->where('inov_chalenge_tahap_id', $tahap->id)
                    ->whereNotNull('skor');
                $tahapScores[$tahap->id] = $tahapReviews->count() > 0
                    ? round($tahapReviews->avg('skor'), 1)
                    : null;
            }
            $allScores = collect($tahapScores)->filter(fn($v) => $v !== null);
            $scoreMap[$sub->id] = [
                'per_tahap' => $tahapScores,
                'total'     => $allScores->count() > 0 ? round($allScores->avg(), 1) : null,
                'reviewed'  => $sub->reviews->whereNotNull('skor')->count() > 0,
            ];
        }

        $submissions = $submissions->sortByDesc(function ($sub) use ($scoreMap) {
            return $scoreMap[$sub->id]['total'] ?? -1;
        })->values();

        return view('admin_inovchalenge.inovchalenge.submissions.scores', compact('session', 'tahapList', 'submissions', 'scoreMap'));
    }
}
