<?php

namespace App\Http\Controllers\InovChallenge\Admin;

use App\Http\Controllers\Controller;
use App\Models\InovChallengeSession;
use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InovChallengeDashboardController extends Controller
{
    /**
     * Display the admin dashboard for Innovation Challenge.
     */
    public function index(Request $request)
    {
        // Get active session
        $activeSession = InovChallengeSession::where('status', 'active')->first();

        // Overall statistics
        $statistics = [
            'total_sessions' => InovChallengeSession::count(),
            'active_sessions' => InovChallengeSession::where('status', 'active')->count(),
            'total_submissions' => InovChallengeSubmission::count(),
            'pending_reviews' => InovChallengeReview::where('status', 'assigned')->count(),
            'completed_reviews' => InovChallengeReview::where('status', 'completed')->count(),
            'total_reviewers' => User::role('reviewer_inovchalange')->count(),
        ];

        // Submission statistics
        $submissionStats = [
            'draft' => InovChallengeSubmission::where('final_status', 'draft')->count(),
            'submitted' => InovChallengeSubmission::whereIn('final_status', ['submitted', 'under_review'])->count(),
            'reviewed' => InovChallengeSubmission::where('final_status', 'reviewed')->count(),
            'approved' => InovChallengeSubmission::where('final_status', 'approved')->count(),
            'rejected' => InovChallengeSubmission::where('final_status', 'rejected')->count(),
        ];

        // Phase statistics
        $phaseStats = [];
        foreach (['phase_1', 'phase_2', 'phase_3'] as $phase) {
            $phaseStatusField = $phase . '_status';
            $phaseStats[$phase] = [
                'submitted' => InovChallengeSubmission::where($phaseStatusField, 'submitted')->count(),
                'under_review' => InovChallengeSubmission::where($phaseStatusField, 'under_review')->count(),
                'reviewed' => InovChallengeSubmission::where($phaseStatusField, 'reviewed')->count(),
                'approved' => InovChallengeSubmission::where($phaseStatusField, 'approved')->count(),
                'rejected' => InovChallengeSubmission::where($phaseStatusField, 'rejected')->count(),
            ];
        }

        // Recent submissions (last 10)
        $recentSubmissions = InovChallengeSubmission::with(['session', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Pending reviews that need reviewer assignment
        $pendingReviewAssignments = InovChallengeSubmission::whereIn('final_status', ['submitted'])
            ->whereDoesntHave('reviews')
            ->with(['session', 'user'])
            ->orderBy('created_at', 'asc')
            ->limit(10)
            ->get();

        // Sessions overview
        $sessions = InovChallengeSession::withCount(['submissions'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Reviewer workload
        $reviewerWorkload = DB::table('inov_challenge_reviews')
            ->select(
                'reviewer_id',
                DB::raw('count(*) as total_reviews'),
                DB::raw('sum(case when status = "assigned" then 1 else 0 end) as pending'),
                DB::raw('sum(case when status = "in_progress" then 1 else 0 end) as in_progress'),
                DB::raw('sum(case when status = "completed" then 1 else 0 end) as completed')
            )
            ->groupBy('reviewer_id')
            ->get();

        // Load reviewer names
        $reviewerIds = $reviewerWorkload->pluck('reviewer_id')->toArray();
        $reviewers = User::whereIn('id', $reviewerIds)->get()->keyBy('id');

        $reviewerWorkload = $reviewerWorkload->map(function ($item) use ($reviewers) {
            $item->reviewer = $reviewers->get($item->reviewer_id);
            return $item;
        });

        return view('inov_challenge.admin.dashboard', compact(
            'statistics',
            'submissionStats',
            'phaseStats',
            'recentSubmissions',
            'pendingReviewAssignments',
            'sessions',
            'reviewerWorkload',
            'activeSession'
        ));
    }
}
