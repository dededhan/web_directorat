<?php

namespace App\Exports;

use App\Models\Responden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LegacyRespondenExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $query;
    protected $counter = 0;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function title(): string
    {
        return 'Responden Legacy';
    }

    public function headings(): array
    {
        return [
            'No',
            'Gelar',
            'Nama Lengkap',
            'Jabatan',
            'Instansi / Perusahaan',
            'Email',
            'No. Telepon',
            'Fakultas',
            'Kategori',
            'Status Email',
            'Status Akhir',
            'Dosen Pengusul',
            'Tahun Dibuat',
        ];
    }

    public function map($row): array
    {
        $this->counter++;

        $st = strtolower(trim($row->status ?? 'belum'));
        $statusEmail = match ($st) {
            'done' => 'Sudah di-email',
            'dones' => 'Follow up done',
            'clear', 'selesai' => 'Selesai',
            default => 'Belum di-email',
        };

        $isFinished = (bool) ($row->is_finished ?? in_array($st, ['clear', 'selesai']));
        $statusAkhir = $isFinished ? 'Selesai' : 'Belum Selesai';
        $tahun = $row->created_at ? $row->created_at->format('Y') : '-';

        return [
            $this->counter,
            $row->title ? strtoupper($row->title) : '-',
            $row->fullname ?? '-',
            $row->jabatan ?? '-',
            $row->instansi ?? '-',
            $row->email ?? '-',
            $row->phone_responden ?? '-',
            strtoupper($row->fakultas ?? '-'),
            ucfirst($row->category ?? '-'),
            $statusEmail,
            $statusAkhir,
            $row->nama_dosen_pengusul ?? '-',
            $tahun,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Header style
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0D9488'], // Teal 600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Body border and alignment
        if ($lastRow > 1) {
            $sheet->getStyle("A2:M{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E5E7EB'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Center align specific columns
            $sheet->getStyle("A2:B{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("H2:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("M2:M{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        return [];
    }
}
