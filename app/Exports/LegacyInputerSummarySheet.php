<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * "Rekap Penginput" sheet: who inputted the legacy respondents, grouped by
 * Direktorat / Fakultas / Prodi / Tidak Diketahui with a subtotal row per group.
 */
class LegacyInputerSummarySheet implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithTitle
{
    protected array $breakdown;

    /** Spreadsheet row numbers (1-based, incl. heading) of group subtotal rows */
    protected array $groupRows = [];

    public function __construct(array $breakdown)
    {
        $this->breakdown = $breakdown;
    }

    public function title(): string
    {
        return 'Rekap Penginput';
    }

    public function headings(): array
    {
        return ['Tipe', 'Penginput', 'Total', 'Selesai', 'Belum Selesai', 'Rasio Selesai (%)'];
    }

    public function collection()
    {
        $rows = new Collection();
        $rowNumber = 1; // heading row

        $grandTotal = 0;
        $grandFinished = 0;

        foreach ($this->breakdown as $group) {
            $rowNumber++;
            $this->groupRows[] = $rowNumber;
            $rows->push([
                $group['label'],
                'Subtotal ' . $group['label'],
                $group['total'],
                $group['finished'],
                $group['total'] - $group['finished'],
                $group['rate'],
            ]);

            foreach ($group['inputers'] as $inp) {
                $rowNumber++;
                $rows->push([
                    $group['label'],
                    $inp['name'],
                    $inp['total'],
                    $inp['finished'],
                    $inp['total'] - $inp['finished'],
                    $inp['rate'],
                ]);
            }

            $grandTotal += $group['total'];
            $grandFinished += $group['finished'];
        }

        $rows->push([
            'TOTAL',
            'Semua Penginput',
            $grandTotal,
            $grandFinished,
            $grandTotal - $grandFinished,
            $grandTotal > 0 ? round(($grandFinished / $grandTotal) * 100, 1) : 0,
        ]);

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0D9488']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        if ($lastRow > 1) {
            $sheet->getStyle("A2:F{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']],
                ],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getStyle("C2:F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Group subtotal rows
            foreach ($this->groupRows as $r) {
                $sheet->getStyle("A{$r}:F{$r}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCFBF1']], // Teal 100
                ]);
            }

            // Grand total row
            $sheet->getStyle("A{$lastRow}:F{$lastRow}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '115E59']], // Teal 800
            ]);
        }

        return [];
    }
}
