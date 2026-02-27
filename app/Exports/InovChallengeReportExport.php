<?php

namespace App\Exports;

use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeReview;
use App\Models\InovChallengeSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InovChallengeReportExport implements WithMultipleSheets
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            new SubmissionsSummarySheet($this->filters),
            new ReviewStatisticsSheet($this->filters),
            new ParticipationSheet($this->filters),
        ];
    }
}

// Sheet 1: Submissions Summary
class SubmissionsSummarySheet implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = InovChallengeSubmission::with(['session', 'user', 'reviews'])
            ->orderBy('created_at', 'desc');

        if (!empty($this->filters['session_id'])) {
            $query->where('session_id', $this->filters['session_id']);
        }

        if (!empty($this->filters['start_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['start_date']);
        }

        if (!empty($this->filters['end_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['end_date']);
        }

        return $query->get();
    }

    public function title(): string
    {
        return 'Submissions Summary';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Session',
            'Title',
            'Leader',
            'Phase 1',
            'Phase 2',
            'Phase 3',
            'Final Status',
            'Avg Score',
            'Created',
        ];
    }

    public function map($submission): array
    {
        $avgScore = $submission->reviews()
            ->where('status', 'completed')
            ->avg('score');

        return [
            $submission->id,
            $submission->session->title ?? '-',
            $submission->title ?? '-',
            $submission->user->name ?? '-',
            $this->formatStatus($submission->phase_1_status),
            $this->formatStatus($submission->phase_2_status),
            $this->formatStatus($submission->phase_3_status),
            $this->formatStatus($submission->final_status),
            $avgScore ? round($avgScore, 2) : '-',
            $submission->created_at->format('Y-m-d'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function formatStatus($status)
    {
        $statusMap = [
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'under_review' => 'Under Review',
            'reviewed' => 'Reviewed',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ];

        return $statusMap[$status] ?? $status;
    }
}

// Sheet 2: Review Statistics
class ReviewStatisticsSheet implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = InovChallengeReview::with(['submission.session', 'reviewer', 'submission'])
            ->where('status', 'completed')
            ->orderBy('reviewed_at', 'desc');

        if (!empty($this->filters['session_id'])) {
            $query->whereHas('submission', function ($q) {
                $q->where('session_id', $this->filters['session_id']);
            });
        }

        if (!empty($this->filters['start_date'])) {
            $query->whereDate('reviewed_at', '>=', $this->filters['start_date']);
        }

        if (!empty($this->filters['end_date'])) {
            $query->whereDate('reviewed_at', '<=', $this->filters['end_date']);
        }

        return $query->get();
    }

    public function title(): string
    {
        return 'Review Statistics';
    }

    public function headings(): array
    {
        return [
            'Review ID',
            'Submission',
            'Reviewer',
            'Phase',
            'Score',
            'Status',
            'Assigned At',
            'Reviewed At',
            'Review Time (Days)',
        ];
    }

    public function map($review): array
    {
        $reviewTime = null;
        if ($review->reviewed_at && $review->assigned_at) {
            $reviewTime = $review->assigned_at->diffInDays($review->reviewed_at);
        }

        return [
            $review->id,
            $review->submission->title ?? '-',
            $review->reviewer->name ?? '-',
            $review->phase,
            $review->score ?? '-',
            $this->formatStatus($review->status),
            $review->assigned_at ? $review->assigned_at->format('Y-m-d H:i') : '-',
            $review->reviewed_at ? $review->reviewed_at->format('Y-m-d H:i') : '-',
            $reviewTime ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function formatStatus($status)
    {
        return ucfirst(str_replace('_', ' ', $status));
    }
}

// Sheet 3: Participation Statistics
class ParticipationSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        // Get participation by session
        $query = InovChallengeSession::withCount(['submissions']);

        if (!empty($this->filters['start_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['start_date']);
        }

        if (!empty($this->filters['end_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['end_date']);
        }

        if (!empty($this->filters['session_id'])) {
            $query->where('id', $this->filters['session_id']);
        }

        $sessions = $query->get();

        return collect($sessions)->map(function ($session) {
            return [
                'Session' => $session->title,
                'Status' => ucfirst($session->status),
                'Total Submissions' => $session->submissions_count,
                'Start Date' => $session->start_date ? $session->start_date->format('Y-m-d') : '-',
                'End Date' => $session->end_date ? $session->end_date->format('Y-m-d') : '-',
                'Created' => $session->created_at->format('Y-m-d'),
            ];
        });
    }

    public function title(): string
    {
        return 'Participation';
    }

    public function headings(): array
    {
        return [
            'Session',
            'Status',
            'Total Submissions',
            'Start Date',
            'End Date',
            'Created',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
