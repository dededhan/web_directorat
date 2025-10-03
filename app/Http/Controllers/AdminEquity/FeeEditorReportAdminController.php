<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\FeeEditorReport;
use Illuminate\Http\Request;

class FeeEditorReportAdminController extends Controller
{
    public function show($id)
    {
        $report = FeeEditorReport::with(['user', 'session'])->findOrFail($id);
        return view('admin_equity.fee_editor.report-detail', compact('report'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:diajukan,diverifikasi,disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $report = FeeEditorReport::findOrFail($id);
        $report->update($validated);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui!');
    }
}
