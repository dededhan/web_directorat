<?php

namespace App\Exports;

use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeTeamMember;
use App\Models\InovChallengeReview;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class InovChallengeSubmissionsExport implements WithMultipleSheets
{
    use Exportable;

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
        $sheets = [
            new SubmissionsSheet($this->filters),
        ];

        // Include team members sheet if enabled in config
        if (config('inov_challenge.export_include_team_members', true)) {
            $sheets[] = new TeamMembersSheet($this->filters);
        }

        // Include reviews sheet if enabled in config
        if (config('inov_challenge.export_include_reviews', true)) {
            $sheets[] = new ReviewsSheet($this->filters);
        }

        return $sheets;
    }
}

// ============================================================================
// SUBMISSIONS SHEET
// ============================================================================

class SubmissionsSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Submissions';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = InovChallengeSubmission::with(['session', 'user', 'teamMembers.user', 'reviews'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if (!empty($this->filters['session_id'])) {
            $query->where('session_id', $this->filters['session_id']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('final_status', $this->filters['status']);
        }

        if (!empty($this->filters['phase'])) {
            $phase = $this->filters['phase'];
            $phaseStatusField = $phase . '_status';
            $query->whereNotNull($phase . '_data')
                ->where($phaseStatusField, '!=', 'draft');
        }

        // Date range filter
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        // Search filter
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Session',
            'Judul',
            'Ketua Tim',
            'Email Ketua',
            'Fakultas',
            'Prodi',
            'Jumlah Anggota',
            'Phase 1 Status',
            'Phase 1 Submitted',
            'Phase 1 Score',
            'Phase 1 Reviews',
            'Phase 2 Status',
            'Phase 2 Submitted',
            'Phase 2 Score',
            'Phase 2 Reviews',
            'Phase 3 Status',
            'Phase 3 Submitted',
            'Phase 3 Score',
            'Phase 3 Reviews',
            'Final Status',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @param mixed $submission
     * @return array
     */
    public function map($submission): array
    {
        return [
            $submission->id,
            $submission->session->title ?? '-',
            $submission->title ?? '-',
            $submission->user->name ?? '-',
            $submission->user->email ?? '-',
            $submission->user->fakultas ?? '-',
            $submission->user->prodi ?? '-',
            $submission->acceptedMembers->count(),
            $this->formatStatus($submission->phase_1_status),
            $submission->phase_1_submitted_at ? $submission->phase_1_submitted_at->format('Y-m-d H:i') : '-',
            $this->formatScore($submission->getAverageScoreForPhase('phase_1')),
            $submission->reviewsByPhase('phase_1')->count(),
            $this->formatStatus($submission->phase_2_status),
            $submission->phase_2_submitted_at ? $submission->phase_2_submitted_at->format('Y-m-d H:i') : '-',
            $this->formatScore($submission->getAverageScoreForPhase('phase_2')),
            $submission->reviewsByPhase('phase_2')->count(),
            $this->formatStatus($submission->phase_3_status),
            $submission->phase_3_submitted_at ? $submission->phase_3_submitted_at->format('Y-m-d H:i') : '-',
            $this->formatScore($submission->getAverageScoreForPhase('phase_3')),
            $submission->reviewsByPhase('phase_3')->count(),
            $this->formatStatus($submission->final_status),
            $submission->created_at->format('Y-m-d H:i'),
            $submission->updated_at->format('Y-m-d H:i'),
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 25,  // Session
            'C' => 35,  // Judul
            'D' => 25,  // Ketua Tim
            'E' => 30,  // Email
            'F' => 20,  // Fakultas
            'G' => 30,  // Prodi
            'H' => 15,  // Jumlah Anggota
            'I' => 18,  // P1 Status
            'J' => 18,  // P1 Submitted
            'K' => 12,  // P1 Score
            'L' => 12,  // P1 Reviews
            'M' => 18,  // P2 Status
            'N' => 18,  // P2 Submitted
            'O' => 12,  // P2 Score
            'P' => 12,  // P2 Reviews
            'Q' => 18,  // P3 Status
            'R' => 18,  // P3 Submitted
            'S' => 12,  // P3 Score
            'T' => 12,  // P3 Reviews
            'U' => 18,  // Final Status
            'V' => 18,  // Created At
            'W' => 18,  // Updated At
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * Format status to be more readable
     */
    private function formatStatus($status)
    {
        $statusMap = [
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'under_review' => 'Under Review',
            'reviewed' => 'Reviewed',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'in_progress' => 'In Progress',
            'needs_revision' => 'Needs Revision',
        ];

        return $statusMap[$status] ?? ($status ?: '-');
    }

    /**
     * Format score with 2 decimal places
     */
    private function formatScore($score)
    {
        return $score ? number_format($score, 2) : '-';
    }
}

// ============================================================================
// TEAM MEMBERS SHEET
// ============================================================================

class TeamMembersSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Team Members';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = InovChallengeTeamMember::with(['submission.session', 'submission.user', 'user'])
            ->orderBy('submission_id', 'asc')
            ->orderBy('created_at', 'asc');

        // Apply filters from parent
        if (!empty($this->filters['session_id'])) {
            $query->whereHas('submission', function ($q) {
                $q->where('session_id', $this->filters['session_id']);
            });
        }

        if (!empty($this->filters['status'])) {
            $query->whereHas('submission', function ($q) {
                $q->where('final_status', $this->filters['status']);
            });
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Submission ID',
            'Submission Title',
            'Team Leader',
            'Member Name',
            'Member Email',
            'Member Type',
            'Role',
            'Invitation Status',
            'Joined At',
        ];
    }

    /**
     * @param mixed $member
     * @return array
     */
    public function map($member): array
    {
        return [
            $member->submission_id,
            $member->submission->title ?? '-',
            $member->submission->user->name ?? '-',
            $member->member_type === 'internal' ? ($member->user->name ?? '-') : $member->external_name,
            $member->member_type === 'internal' ? ($member->user->email ?? '-') : $member->external_email,
            $member->member_type === 'internal' ? 'Internal (Dosen)' : 'External',
            $member->role ?? '-',
            $this->formatInvitationStatus($member->invitation_status),
            $member->joined_at ? $member->joined_at->format('Y-m-d H:i') : '-',
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 12,  // Submission ID
            'B' => 35,  // Submission Title
            'C' => 25,  // Team Leader
            'D' => 25,  // Member Name
            'E' => 30,  // Member Email
            'F' => 18,  // Member Type
            'G' => 20,  // Role
            'H' => 18,  // Invitation Status
            'I' => 18,  // Joined At
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '70AD47']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    private function formatInvitationStatus($status)
    {
        $statusMap = [
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
        ];

        return $statusMap[$status] ?? $status;
    }
}

// ============================================================================
// REVIEWS SHEET
// ============================================================================

class ReviewsSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Reviews';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = InovChallengeReview::with(['submission.session', 'submission.user', 'reviewer'])
            ->orderBy('submission_id', 'asc')
            ->orderBy('phase', 'asc')
            ->orderBy('created_at', 'asc');

        // Apply filters from parent
        if (!empty($this->filters['session_id'])) {
            $query->whereHas('submission', function ($q) {
                $q->where('session_id', $this->filters['session_id']);
            });
        }

        if (!empty($this->filters['phase'])) {
            $query->where('phase', $this->filters['phase']);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Submission ID',
            'Submission Title',
            'Team Leader',
            'Phase',
            'Reviewer Name',
            'Reviewer Email',
            'Score',
            'Comments',
            'Status',
            'Reviewed At',
        ];
    }

    /**
     * @param mixed $review
     * @return array
     */
    public function map($review): array
    {
        return [
            $review->submission_id,
            $review->submission->title ?? '-',
            $review->submission->user->name ?? '-',
            ucfirst(str_replace('_', ' ', $review->phase)),
            $review->reviewer->name ?? '-',
            $review->reviewer->email ?? '-',
            $review->score ?? '-',
            $review->comments ?? '-',
            $this->formatReviewStatus($review->status),
            $review->reviewed_at ? $review->reviewed_at->format('Y-m-d H:i') : '-',
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 12,  // Submission ID
            'B' => 35,  // Submission Title
            'C' => 25,  // Team Leader
            'D' => 15,  // Phase
            'E' => 25,  // Reviewer Name
            'F' => 30,  // Reviewer Email
            'G' => 10,  // Score
            'H' => 50,  // Comments
            'I' => 15,  // Status
            'J' => 18,  // Reviewed At
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFC000']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    private function formatReviewStatus($status)
    {
        $statusMap = [
            'pending' => 'Pending',
            'completed' => 'Completed',
        ];

        return $statusMap[$status] ?? $status;
    }
}
