<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;

class SessionReportExport implements WithMultipleSheets
{
    protected $summaryData;
    protected $detailData;

    public function __construct(Collection $summaryData, Collection $detailData)
    {
        $this->summaryData = $summaryData;
        $this->detailData = $detailData;
    }

    public function sheets(): array
    {
        return [
            new SessionSummarySheet($this->summaryData),
            new SessionDetailSheet($this->detailData),
        ];
    }
}
