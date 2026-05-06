<?php

namespace App\Exports\InovChalenge;

use App\Models\InovChalengeSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScoresExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $session;
    protected $tahapList;
    protected $submissions;
    protected $scoreMap;

    public function __construct(InovChalengeSession $session, $tahapList, $submissions, $scoreMap)
    {
        $this->session = $session;
        $this->tahapList = $tahapList;
        $this->submissions = $submissions;
        $this->scoreMap = $scoreMap;
    }

    public function collection()
    {
        return collect($this->submissions);
    }

    public function headings(): array
    {
        $headings = [
            'Nama Dosen',
            'Nama Produk',
            'Skema Inovasi',
            'Bidang Utama',
        ];

        foreach ($this->tahapList as $tahap) {
            $headings[] = 'Skor ' . $tahap->nama_tahap;
        }

        $headings[] = 'Total Skor (Rata-rata)';
        $headings[] = 'Reviewer Ditugaskan';

        return $headings;
    }

    public function map($submission): array
    {
        $sm = $this->scoreMap[$submission->id] ?? null;

        $row = [
            $submission->user->name ?? '-',
            $submission->identitas->nama_produk ?? '-',
            $submission->identitas->skema_inovasi ?? '-',
            $submission->identitas->bidang_utama_produk ?? '-',
        ];

        foreach ($this->tahapList as $tahap) {
            $row[] = $sm['per_tahap'][$tahap->id] ?? '-';
        }

        $row[] = $sm['total'] ?? '-';
        $row[] = $submission->reviewers->pluck('name')->join(', ');

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
