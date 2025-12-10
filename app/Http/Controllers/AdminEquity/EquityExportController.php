<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\ComdevSubmission;
use App\Models\ApcSubmission;
use App\Models\MatchmakingSubmission;
use App\Models\FeeReviewerReport;
use App\Models\FeeEditorReport;
use App\Models\PresentingReport;
use App\Models\VisitingProfessorSubmission;
use App\Models\JointSupervisionSubmission;
use App\Models\EmployerMeetingSubmission;

class EquityExportController extends Controller
{
    /**
     * Export Community Development submissions
     */
    public function exportComdev()
    {
        $submissions = ComdevSubmission::with([
            'user.profile.prodi.fakultas',
            'sesi'
        ])->get();
        
        $fileName = 'community_development_' . date('Y-m-d_His') . '.csv';
        
        return $this->generateCsvResponse($submissions, $fileName, function($file) use ($submissions) {
            // Header CSV
            fputcsv($file, [
                'No',
                'Sesi',
                'Fakultas',
                'Nama Pengunggah',
                'Judul',
                'Tanggal Diajukan',
                'Status',
                'Catatan Admin'
            ]);

            // Data
            foreach ($submissions as $index => $submission) {
                fputcsv($file, [
                    $index + 1,
                    $submission->sesi->judul ?? '-',
                    $submission->user->profile->prodi->fakultas->name ?? '-',
                    $submission->user->name ?? '-',
                    $submission->judul ?? '-',
                    $submission->created_at->format('d/m/Y H:i'),
                    $this->formatComdevStatus($submission->status),
                    $submission->catatan_admin ?? '-'
                ]);
            }
        });
    }

    /**
     * Export APC submissions
     */
    public function exportApc()
    {
        $submissions = ApcSubmission::with([
            'user.profile.prodi.fakultas',
            'session'
        ])->get();
        
        $fileName = 'apc_' . date('Y-m-d_His') . '.csv';
        
        return $this->generateCsvResponse($submissions, $fileName, function($file) use ($submissions) {
            // Header CSV
            fputcsv($file, [
                'No',
                'Sesi',
                'Fakultas',
                'Nama Pengunggah',
                'Nama Jurnal Q1',
                'Judul Artikel',
                'Volume',
                'Issue',
                'Biaya Publikasi',
                'Tanggal Diajukan',
                'Status'
            ]);

            // Data
            foreach ($submissions as $index => $submission) {
                fputcsv($file, [
                    $index + 1,
                    $submission->session->nama_sesi ?? '-',
                    $submission->user->profile->prodi->fakultas->name ?? '-',
                    $submission->user->name ?? '-',
                    $submission->nama_jurnal_q1 ?? '-',
                    $submission->judul_artikel ?? '-',
                    $submission->volume ?? '-',
                    $submission->issue ?? '-',
                    $submission->biaya_publikasi ?? '-',
                    $submission->created_at->format('d/m/Y H:i'),
                    ucfirst($submission->status ?? '-')
                ]);
            }
        });
    }

    /**
     * Export Matchmaking submissions
     */
    public function exportMatchmaking()
    {
        $submissions = MatchmakingSubmission::with([
            'user.profile.prodi.fakultas',
            'session',
            'report'
        ])->get();
        
        $fileName = 'matchmaking_' . date('Y-m-d_His') . '.csv';
        
        return $this->generateCsvResponse($submissions, $fileName, function($file) use ($submissions) {
            // Header CSV
            fputcsv($file, [
                'No',
                'Sesi',
                'Fakultas',
                'Nama Pengunggah',
                'Judul Proposal',
                'Tanggal Diajukan',
                'Status',
                'Status Laporan',
                'Catatan Penolakan'
            ]);

            // Data
            foreach ($submissions as $index => $submission) {
                fputcsv($file, [
                    $index + 1,
                    $submission->session->nama_sesi ?? '-',
                    $submission->user->profile->prodi->fakultas->name ?? '-',
                    $submission->user->name ?? '-',
                    $submission->judul_proposal ?? '-',
                    $submission->created_at->format('d/m/Y H:i'),
                    ucfirst($submission->status ?? '-'),
                    $submission->report ? ucfirst($submission->report->status) : 'Belum Ada',
                    $submission->rejection_note ?? '-'
                ]);
            }
        });
    }

    /**
     * Export Fee Reviewer reports
     */
    public function exportFeeReviewer()
    {
        $reports = FeeReviewerReport::with([
            'user.profile.prodi.fakultas',
            'session'
        ])->get();
        
        $fileName = 'fee_reviewer_' . date('Y-m-d_His') . '.csv';
        
        return $this->generateCsvResponse($reports, $fileName, function($file) use ($reports) {
            // Header CSV
            fputcsv($file, [
                'No',
                'Sesi',
                'Fakultas',
                'Nama Pengunggah',
                'Judul Artikel',
                'Nama Jurnal',
                'Tanggal Review',
                'Status',
                'Catatan Admin'
            ]);

            // Data
            foreach ($reports as $index => $report) {
                fputcsv($file, [
                    $index + 1,
                    $report->session->nama_sesi ?? '-',
                    $report->user->profile->prodi->fakultas->name ?? '-',
                    $report->user->name ?? '-',
                    $report->judul_artikel ?? '-',
                    $report->nama_jurnal ?? '-',
                    $report->tanggal_review ? date('d/m/Y', strtotime($report->tanggal_review)) : '-',
                    ucfirst($report->status ?? '-'),
                    $report->catatan_admin ?? '-'
                ]);
            }
        });
    }

    /**
     * Export Fee Editor reports
     */
    public function exportFeeEditor()
    {
        $reports = FeeEditorReport::with([
            'user.profile.prodi.fakultas',
            'session'
        ])->get();
        
        $fileName = 'fee_editor_' . date('Y-m-d_His') . '.csv';
        
        return $this->generateCsvResponse($reports, $fileName, function($file) use ($reports) {
            // Header CSV
            fputcsv($file, [
                'No',
                'Sesi',
                'Fakultas',
                'Nama Pengunggah',
                'Nama Jurnal',
                'Peran',
                'Tanggal Penugasan Awal',
                'Tanggal Penugasan Akhir',
                'Status',
                'Catatan Admin'
            ]);

            // Data
            foreach ($reports as $index => $report) {
                fputcsv($file, [
                    $index + 1,
                    $report->session->nama_sesi ?? '-',
                    $report->user->profile->prodi->fakultas->name ?? '-',
                    $report->user->name ?? '-',
                    $report->nama_jurnal ?? '-',
                    $report->peran ?? '-',
                    $report->penugasan_awal ? date('d/m/Y', strtotime($report->penugasan_awal)) : '-',
                    $report->penugasan_akhir ? date('d/m/Y', strtotime($report->penugasan_akhir)) : '-',
                    ucfirst($report->status ?? '-'),
                    $report->catatan_admin ?? '-'
                ]);
            }
        });
    }

    /**
     * Export Presenting reports
     */
    public function exportPresenting()
    {
        $reports = PresentingReport::with([
            'user.profile.prodi.fakultas',
            'session'
        ])->get();
        
        $fileName = 'presenting_' . date('Y-m-d_His') . '.csv';
        
        return $this->generateCsvResponse($reports, $fileName, function($file) use ($reports) {
            // Header CSV
            fputcsv($file, [
                'No',
                'Sesi',
                'Fakultas',
                'Nama Pengunggah',
                'Nama Conference',
                'Judul Artikel',
                'Tempat Pelaksanaan',
                'Negara',
                'Waktu Pelaksanaan Awal',
                'Waktu Pelaksanaan Akhir',
                'Status'
            ]);

            // Data
            foreach ($reports as $index => $report) {
                fputcsv($file, [
                    $index + 1,
                    $report->session->nama_sesi ?? '-',
                    $report->user->profile->prodi->fakultas->name ?? '-',
                    $report->user->name ?? '-',
                    $report->nama_conference ?? '-',
                    $report->judul_artikel ?? '-',
                    $report->tempat_pelaksanaan ?? '-',
                    $report->negara_pelaksanaan ?? '-',
                    $report->waktu_pelaksanaan_awal ? $report->waktu_pelaksanaan_awal->format('d/m/Y') : '-',
                    $report->waktu_pelaksanaan_akhir ? $report->waktu_pelaksanaan_akhir->format('d/m/Y') : '-',
                    ucfirst($report->status ?? '-')
                ]);
            }
        });
    }

    /**
     * Export Visiting Professor submissions
     */
    public function exportVisitingProfessor()
    {
        $submissions = VisitingProfessorSubmission::with('user.profile.fakultas')->get();
        
        $fileName = 'visiting_professor_' . date('Y-m-d_His') . '.csv';
        
        return $this->generateCsvResponse($submissions, $fileName, function($file) use ($submissions) {
            // Header CSV
            fputcsv($file, [
                'No',
                'Fakultas',
                'Nama Pengunggah',
                'Tanggal Diajukan',
                'Status',
                'Catatan Admin'
            ]);

            // Data
            foreach ($submissions as $index => $submission) {
                fputcsv($file, [
                    $index + 1,
                    $submission->user->profile->fakultas->name ?? '-',
                    $submission->nama_pengunggah ?? $submission->user->name ?? '-',
                    $submission->created_at->format('d/m/Y H:i'),
                    ucfirst($submission->status ?? '-'),
                    $submission->catatan_admin ?? '-'
                ]);
            }
        });
    }

    /**
     * Export Joint Supervision submissions
     */
    public function exportJointSupervision()
    {
        $submissions = JointSupervisionSubmission::with('user.profile.fakultas')->get();
        
        $fileName = 'joint_supervision_' . date('Y-m-d_His') . '.csv';
        
        return $this->generateCsvResponse($submissions, $fileName, function($file) use ($submissions) {
            // Header CSV
            fputcsv($file, [
                'No',
                'Fakultas',
                'Nama Pengunggah',
                'Tanggal Diajukan',
                'Status',
                'Catatan Admin'
            ]);

            // Data
            foreach ($submissions as $index => $submission) {
                fputcsv($file, [
                    $index + 1,
                    $submission->user->profile->fakultas->name ?? '-',
                    $submission->nama_pengunggah ?? $submission->user->name ?? '-',
                    $submission->created_at->format('d/m/Y H:i'),
                    ucfirst($submission->status ?? '-'),
                    $submission->catatan_admin ?? '-'
                ]);
            }
        });
    }

    /**
     * Export Employer Meeting submissions
     */
    public function exportEmployerMeeting()
    {
        $submissions = EmployerMeetingSubmission::with('user.profile.fakultas')->get();
        
        $fileName = 'employer_meeting_' . date('Y-m-d_His') . '.csv';
        
        return $this->generateCsvResponse($submissions, $fileName, function($file) use ($submissions) {
            // Header CSV
            fputcsv($file, [
                'No',
                'Fakultas',
                'Nama Pengunggah',
                'Nama Calon Responden',
                'Tanggal Diajukan',
                'Status',
                'Catatan Admin'
            ]);

            // Data
            foreach ($submissions as $index => $submission) {
                fputcsv($file, [
                    $index + 1,
                    $submission->user->profile->fakultas->name ?? '-',
                    $submission->nama_pengunggah ?? $submission->user->name ?? '-',
                    $submission->nama_calon_responden ?? '-',
                    $submission->created_at->format('d/m/Y H:i'),
                    ucfirst($submission->status ?? '-'),
                    $submission->catatan_admin ?? '-'
                ]);
            }
        });
    }

    /**
     * Helper method to generate CSV response
     */
    private function generateCsvResponse($data, $fileName, $callback)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $responseCallback = function() use ($callback) {
            $file = fopen('php://output', 'w');
            $callback($file);
            fclose($file);
        };

        return response()->stream($responseCallback, 200, $headers);
    }

    /**
     * Helper method to format Comdev status
     */
    private function formatComdevStatus($status)
    {
        if (is_object($status) && method_exists($status, 'value')) {
            return ucfirst(str_replace('_', ' ', $status->value));
        }
        return ucfirst(str_replace('_', ' ', $status ?? '-'));
    }
}
