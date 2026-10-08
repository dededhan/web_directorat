<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Legacy Responden report: detail sheet + optional "Rekap Penginput" sheet.
 */
class LegacyReportExport implements WithMultipleSheets
{
    protected $query;
    protected array $inputerBreakdown;

    public function __construct($query, array $inputerBreakdown = [])
    {
        $this->query = $query;
        $this->inputerBreakdown = $inputerBreakdown;
    }

    public function sheets(): array
    {
        $sheets = [new LegacyRespondenExport($this->query)];

        // Breakdown is empty for Prodi accounts (they only see their own inputs)
        if (!empty($this->inputerBreakdown)) {
            $sheets[] = new LegacyInputerSummarySheet($this->inputerBreakdown);
        }

        return $sheets;
    }
}
