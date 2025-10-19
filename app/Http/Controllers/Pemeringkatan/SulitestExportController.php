<?php

namespace App\Http\Controllers\Pemeringkatan;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Exports\SulitestAnalyticsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SulitestExportController extends Controller
{
    public function exportAnalytics(Exam $exam, Request $request)
    {
        $reportType = $request->get('type', 'overall');
        
        $validTypes = ['overall', 'by_fakultas', 'by_prodi', 'by_category'];
        if (!in_array($reportType, $validTypes)) {
            $reportType = 'overall';
        }

        //sumpah ini bener bener ngoasu
        $examTitle = preg_replace('/[\/\\\:*?"<>|]/', '_', $exam->title);
        $examTitle = str_replace(' ', '_', $examTitle);
        
        $filename = 'Laporan_' . $examTitle . '_' . $reportType . '_' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new SulitestAnalyticsExport($exam, $reportType), $filename);
    }
}
