<?php

namespace App\Exports\Hackaton;

use App\Models\HackatonSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubmissionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected HackatonSession $session;
    protected $submissions;
    protected $tahapList;
    private int $rowNumber = 1;

    public function __construct(HackatonSession $session, $submissions)
    {
        $this->session = $session;
        $this->submissions = collect($submissions);
        $this->tahapList = $session->tahap()->orderBy('tahap_ke')->get();
    }

    public function collection()
    {
        return $this->submissions;
    }

    public function headings(): array
    {
        $headings = [
            'No',
            'Nama Ketua / Pengusul',
            'Email Ketua',
            'Role Pengusul',
            'Fakultas / Institusi Ketua',
            'Kategori',
            'Fokus Tema Inovasi',
            'Nama Produk / Inovasi',
            'Skema Inovasi',
            'Bidang Utama Produk',
            'Status Proposal',
            'Jumlah Anggota Tim',
            'Daftar Anggota Tim',
            'Reviewer Ditugaskan',
        ];

        foreach ($this->tahapList as $tahap) {
            $tk = $tahap->tahap_ke;
            $headings[] = "Status Tahap {$tk} ({$tahap->nama_tahap})";
            $headings[] = "Keputusan Admin T{$tk}";
            $headings[] = "Rata-rata Skor T{$tk}";
        }

        $headings[] = 'Tanggal Dibuat';

        return $headings;
    }

    public function map($submission): array
    {
        $roleName = match ($submission->user->role ?? '') {
            'hackaton_dosen', 'dosen' => 'Dosen Internal UNJ',
            'hackaton_dosen_eksternal' => 'Dosen Eksternal UNJ',
            'hackaton_tendik', 'tendik' => 'Tendik',
            'hackaton_alumni' => 'Alumni',
            'hackaton_peneliti' => 'Peneliti',
            'hackaton_dudi' => 'DUDI',
            'hackaton_mahasiswa' => 'Mahasiswa',
            default => ucfirst(str_replace('hackaton_', '', $submission->user->role ?? 'Pengusul')),
        };

        $ketuaMember = $submission->members->firstWhere('peran', 'Ketua');
        $institusiKetua = $ketuaMember?->institusi_fakultas
            ?? $submission->user?->profile?->fakultas?->name
            ?? $submission->user?->profile?->institusi
            ?? '-';

        $isDFarm = $submission->kategori === 'd-farm' || str_contains($submission->tema ?? '', 'D-FARM');
        $kategoriLabel = $isDFarm ? 'D-FARM' : 'D-MARC';

        $statusLabel = is_object($submission->status) && method_exists($submission->status, 'label')
            ? $submission->status->label()
            : ucfirst(str_replace('_', ' ', (string) ($submission->status ?? '-')));

        $membersText = $submission->members->map(function ($m) {
            $peranIc = $m->peran_ic ? " [{$m->peran_ic}]" : '';
            $inst = $m->institusi_fakultas ? " - {$m->institusi_fakultas}" : '';
            return "{$m->nama_lengkap} ({$m->peran}{$peranIc}{$inst})";
        })->join('; ');

        $reviewersText = $submission->reviewers->isNotEmpty()
            ? $submission->reviewers->pluck('name')->join(', ')
            : 'Belum diassign';

        $row = [
            $this->rowNumber++,
            $submission->user->name ?? '-',
            $submission->user->email ?? '-',
            $roleName,
            $institusiKetua,
            $kategoriLabel,
            $submission->tema_label ?? $submission->tema ?? '-',
            $submission->identitas?->nama_produk ?? 'Belum Diisi',
            $submission->identitas?->skema_inovasi ?? '-',
            $submission->identitas?->bidang_utama_produk ?? '-',
            $statusLabel,
            $submission->members->count(),
            $membersText ?: '-',
            $reviewersText,
        ];

        $hasReviewer = $submission->reviewers->isNotEmpty();

        foreach ($this->tahapList as $tahap) {
            $st = $submission->submissionTahap->firstWhere('hackaton_tahap_id', $tahap->id);
            $tracking = $st ? $st->getTrackingStatus($hasReviewer) : null;

            $tahapReviews = $submission->reviews
                ? $submission->reviews->where('hackaton_tahap_id', $tahap->id)->whereNotNull('skor')
                : collect();
            $avgScore = $tahapReviews->count() > 0 ? round($tahapReviews->avg('skor'), 1) : '-';

            $row[] = $tracking['short'] ?? ($st?->status ?? 'Belum Diisi');
            $row[] = $st ? ucfirst($st->admin_status ?? 'menunggu') : '-';
            $row[] = $avgScore;
        }

        $row[] = $submission->created_at?->format('d M Y H:i') ?? '-';

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

