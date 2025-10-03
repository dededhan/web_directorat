<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\PresentingReport;
use Illuminate\Http\Request;

class PresentingReportAdminController extends Controller
{
    public function show(PresentingReport $report)
    {
        $report->load(['user', 'session', 'submission']);
        return view('admin_equity.presenting.report-detail', compact('report'));
    }

    public function updateStatus(Request $request, PresentingReport $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:diajukan,disetujui,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $report->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui!');
    }
}
