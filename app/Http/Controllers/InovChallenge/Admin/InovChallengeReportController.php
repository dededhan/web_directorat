<?php

namespace App\Http\Controllers\InovChallenge\Admin;

use App\Http\Controllers\Controller;
use App\Models\InovChallengeSession;
use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InovChallengeReportExport;

class InovChallengeReportController extends Controller
{
    /**
     * Display reports and analytics page.
     */
    public function index(Request $request)
    {
        // Filter by date range
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $sessionId = $request->get('session_id');

        // Base query for submissions
        $submissionsQuery = InovChallengeSubmission::query();

        if ($startDate) {
            $submissionsQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $submissionsQuery->whereDate('created_at', '<=', $endDate);
        }

        if ($sessionId) {
            $submissionsQuery->where('session_id', $sessionId);
        }

        // Overall statistics
        $statistics = [
            'total_submissions' => $submissionsQuery->count(),
            'approved' => (clone $submissionsQuery)->where('final_status', 'approved')->count(),
            'rejected' => (clone $submissionsQuery)->where('final_status', 'rejected')->count(),
            'in_progress' => (clone $submissionsQuery)->whereIn('final_status', ['draft', 'submitted', 'under_review', 'reviewed'])->count(),
        ];

        // Submissions by phase
        $submissionsByPhase = [];
        foreach (['phase_1', 'phase_2', 'phase_3'] as $phase) {
            $phaseStatusField = $phase . '_status';
            $submissionsByPhase[$phase] = [
                'draft' => (clone $submissionsQuery)->where($phaseStatusField, 'draft')->count(),
                'submitted' => (clone $submissionsQuery)->where($phaseStatusField, 'submitted')->count(),
                'under_review' => (clone $submissionsQuery)->where($phaseStatusField, 'under_review')->count(),
                'reviewed' => (clone $submissionsQuery)->where($phaseStatusField, 'reviewed')->count(),
                'approved' => (clone $submissionsQuery)->where($phaseStatusField, 'approved')->count(),
                'rejected' => (clone $submissionsQuery)->where($phaseStatusField, 'rejected')->count(),
            ];
        }

        // Submissions by session
        $submissionsBySession = InovChallengeSession::withCount(['submissions'])
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->get();

        // Review statistics
        $reviewStats = [
            'total_reviews' => InovChallengeReview::count(),
            'pending' => InovChallengeReview::where('status', 'assigned')->count(),
            'in_progress' => InovChallengeReview::where('status', 'in_progress')->count(),
            'completed' => InovChallengeReview::where('status', 'completed')->count(),
        ];

        // Average scores by phase
        $averageScores = [];
        foreach (['phase_1', 'phase_2', 'phase_3'] as $phase) {
            $avg = InovChallengeReview::where('phase', $phase)
                ->where('status', 'completed')
                ->avg('score');
            $averageScores[$phase] = $avg ? round($avg, 2) : 0;
        }

        // Top performers (highest average scores)
        $topPerformers = InovChallengeSubmission::with(['user', 'reviews'])
            ->when($sessionId, function ($query) use ($sessionId) {
                $query->where('session_id', $sessionId);
            })
            ->get()
            ->map(function ($submission) {
                $avgScore = $submission->reviews()
                    ->where('status', 'completed')
                    ->avg('score');

                return [
                    'submission' => $submission,
                    'avg_score' => $avgScore ? round($avgScore, 2) : 0,
                ];
            })
            ->sortByDesc('avg_score')
            ->take(10);

        // Reviewer performance
        $reviewerPerformance = DB::table('inov_challenge_reviews')
            ->select(
                'reviewer_id',
                DB::raw('count(*) as total_reviews'),
                DB::raw('sum(case when status = "completed" then 1 else 0 end) as completed_reviews'),
                DB::raw('avg(case when status = "completed" then score else null end) as avg_score_given'),
                DB::raw('avg(DATEDIFF(reviewed_at, assigned_at)) as avg_review_time_days')
            )
            ->when($sessionId, function ($query) use ($sessionId) {
                $query->whereIn('submission_id', function ($subQuery) use ($sessionId) {
                    $subQuery->select('id')
                        ->from('inov_challenge_submissions')
                        ->where('session_id', $sessionId);
                });
            })
            ->groupBy('reviewer_id')
            ->get();

        // Load reviewer data
        $reviewerIds = $reviewerPerformance->pluck('reviewer_id')->toArray();
        $reviewers = User::whereIn('id', $reviewerIds)->get()->keyBy('id');

        $reviewerPerformance = $reviewerPerformance->map(function ($item) use ($reviewers) {
            $item->reviewer = $reviewers->get($item->reviewer_id);
            $item->avg_score_given = $item->avg_score_given ? round($item->avg_score_given, 2) : 0;
            $item->avg_review_time_days = $item->avg_review_time_days ? round($item->avg_review_time_days, 1) : 0;
            return $item;
        });

        // Participation statistics
        $participationStats = [
            'total_participants' => DB::table('inov_challenge_submissions')
                ->distinct('user_id')
                ->count('user_id'),
            'total_team_members' => DB::table('inov_challenge_team_members')
                ->where('invitation_status', 'accepted')
                ->count(),
            'avg_team_size' => DB::table('inov_challenge_submissions')
                ->leftJoin('inov_challenge_team_members', 'inov_challenge_submissions.id', '=', 'inov_challenge_team_members.submission_id')
                ->select('inov_challenge_submissions.id', DB::raw('count(inov_challenge_team_members.id) as team_count'))
                ->where('inov_challenge_team_members.invitation_status', 'accepted')
                ->groupBy('inov_challenge_submissions.id')
                ->avg('team_count'),
        ];

        $participationStats['avg_team_size'] = $participationStats['avg_team_size']
            ? round($participationStats['avg_team_size'], 1)
            : 0;

        // Get sessions for filter
        $sessions = InovChallengeSession::orderBy('created_at', 'desc')->get();

        return view('inov_challenge.admin.reports.index', compact(
            'statistics',
            'submissionsByPhase',
            'submissionsBySession',
            'reviewStats',
            'averageScores',
            'topPerformers',
            'reviewerPerformance',
            'participationStats',
            'sessions'
        ));
    }

    /**
     * Export reports to Excel.
     */
    public function export(Request $request)
    {
        $filters = [
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'session_id' => $request->get('session_id'),
        ];

        try {
            return Excel::download(
                new InovChallengeReportExport($filters),
                'innovation_challenge_report_' . date('Y-m-d_His') . '.xlsx'
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat export report: ' . $e->getMessage());
        }
    }
}
