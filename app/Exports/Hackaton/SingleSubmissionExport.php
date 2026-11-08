<?php

namespace App\Exports\Hackaton;

use App\Models\HackatonSubmission;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SingleSubmissionExport implements FromArray, ShouldAutoSize, WithStyles, WithTitle
{
    protected HackatonSubmission $submission;

    public function __construct(HackatonSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function title(): string
    {
        return 'Detail Proposal';
    }

    public function array(): array
    {
        $sub = $this->submission;
        $isDFarm = $sub->kategori === 'd-farm' || str_contains($sub->tema ?? '', 'D-FARM');
        $statusLabel = is_object($sub->status) && method_exists($sub->status, 'label')
            ? $sub->status->label()
            : ucfirst(str_replace('_', ' ', (string) ($sub->status ?? '-')));

        $rows = [
            ['DETAIL PROPOSAL HACKATON', ''],
            ['Sesi Hackaton', $sub->session?->nama_sesi ?? '-'],
            ['Nama Produk / Inovasi', $sub->identitas?->nama_produk ?? '— Belum Diisi —'],
            ['Skema Inovasi', $sub->identitas?->skema_inovasi ?? '— Belum Dipilih —'],
            ['Kategori Tema', $isDFarm ? 'D-FARM' : 'D-MARC'],
            ['Fokus Tema', $sub->tema_label ?? $sub->tema ?? '-'],
            ['Bidang Utama Produk', $sub->identitas?->bidang_utama_produk ?? '— Belum Diisi —'],
            ['Ketua Tim / Pengusul', $sub->user?->name ?? '-'],
            ['Email Ketua', $sub->user?->email ?? '-'],
            ['Status Proposal', $statusLabel],
            ['Reviewer Ditugaskan', $sub->reviewers->pluck('name')->join(', ') ?: 'Belum diassign'],
            ['Tanggal Dibuat', $sub->created_at?->format('d M Y H:i') ?? '-'],
            ['', ''],
            ['DAFTAR ANGGOTA TIM', '', '', '', '', ''],
            ['No', 'Nama Lengkap', 'Peran Tim', 'Peran IC', 'Tipe Anggota', 'NIM/NIP/NIK', 'Fakultas / Institusi', 'Deskripsi Peran', 'Status Approval'],
        ];

        foreach ($sub->members as $idx => $m) {
            $rows[] = [
                $idx + 1,
                $m->nama_lengkap,
                $m->peran,
                $m->peran_ic ?? '-',
                $m->getTipeLabel(),
                $m->nik_nim_nip ?? '-',
                $m->institusi_fakultas ?? '-',
                $m->deskripsi_peran ?? '-',
                $m->getApprovalBadge()['label'] ?? $m->approval_status,
            ];
        }

        $hasReviewer = $sub->reviewers->isNotEmpty();

        foreach ($sub->submissionTahap->sortBy(fn($st) => $st->tahap->tahap_ke ?? 0) as $st) {
            $tk = $st->tahap->tahap_ke ?? '?';
            $tracking = $st->getTrackingStatus($hasReviewer);
            $tahapReviews = $sub->reviews->where('hackaton_tahap_id', $st->hackaton_tahap_id);
            $avgSkor = $tahapReviews->whereNotNull('skor')->count() > 0
                ? round($tahapReviews->whereNotNull('skor')->avg('skor'), 1)
                : '-';

            $rows[] = ['', ''];
            $rows[] = ["TAHAP {$tk}: " . strtoupper($st->tahap->nama_tahap ?? ''), ''];
            $rows[] = ['Status Tahap', $tracking['label'] ?? $st->status];
            $rows[] = ['Keputusan Admin', ucfirst($st->admin_status ?? 'menunggu')];
            $rows[] = ['Catatan Admin', $st->catatan_admin ?? '-'];
            $rows[] = ['Rata-rata Skor Reviewer', $avgSkor];

            if ($tahapReviews->isNotEmpty()) {
                $rows[] = ['Penilaian Reviewer Tahap ' . $tk, 'Skor', 'Komentar', 'Catatan Evaluasi'];
                foreach ($tahapReviews as $rev) {
                    $rows[] = [
                        $rev->reviewer->name ?? 'Reviewer',
                        $rev->skor ?? '-',
                        $rev->komentar ?? '-',
                        $rev->penilaian ?? '-',
                    ];
                }
            }
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 13]],
            15 => ['font' => ['bold' => true]],
            16 => ['font' => ['bold' => true]],
        ];
    }
}

