<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InternationalLecturerTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    public function headings(): array
    {
        return [
            'Nama Dosen Asing',
            'Jenis Kelamin',
            'Jabatan',
            'Institusi Asal',
            'Negara',
            'Email',
            'Subject',
            'Fakultas',
            'Tahun',
        ];
    }

    /**
     * Template sengaja berisi contoh data agar admin dapat langsung melihat
     * bentuk tabel dan format data yang harus diisi.
     */
    public function array(): array
    {
        return [
            [
                'Dr. John Smith',
                'Laki-laki',
                'Professor',
                'Harvard University',
                'United States',
                'john.smith@example.edu',
                'Computer Science',
                'FMIPA',
                '2026',
            ],
            [
                'Prof. Maria Santos',
                'Perempuan',
                'Associate Professor',
                'University of the Philippines',
                'Philippines',
                'maria.santos@example.edu',
                'Education',
                'FIP',
                '2026',
            ],
            [
                'Dr. Kenji Tanaka',
                'Laki-laki',
                'Senior Lecturer',
                'Osaka University',
                'Japan',
                'kenji.tanaka@example.edu',
                'Engineering',
                'FT',
                '2025',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1F4E78'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D9E2F3'],
                    ],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                $sheet->freezePane('A2');

                if ($lastRow >= 1 && $lastColumn !== '') {
                    $sheet->setAutoFilter("A1:{$lastColumn}{$lastRow}");
                }
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Alternating zebra style & borders for rows
                for ($row = 2; $row <= $lastRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(22);
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A{$row}:{$lastColumn}{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('F2F5F9');
                    }
                    $sheet->getStyle("A{$row}:{$lastColumn}{$row}")
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->getColor()
                        ->setRGB('E2E8F0');
                }

                $widths = [
                    'A' => 28,
                    'B' => 18,
                    'C' => 25,
                    'D' => 34,
                    'E' => 20,
                    'F' => 34,
                    'G' => 28,
                    'H' => 16,
                ];

                foreach ($widths as $column => $width) {
                    $sheet->getColumnDimension($column)->setWidth($width);
                }

                $sheet->getStyle("A2:{$lastColumn}{$lastRow}")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);
            },
        ];
    }
}
