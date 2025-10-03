<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\FeeReviewerReport;
use Illuminate\Http\Request;

class FeeReviewerReportAdminController extends Controller
{
    public function show($id)
    {
        $report = FeeReviewerReport::with(['user', 'session'])->findOrFail($id);
        return view('admin_equity.fee_reviewer.report-detail', compact('report'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:diajukan,diverifikasi,disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $report = FeeReviewerReport::findOrFail($id);
        $report->update($validated);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui!');
    }
}
