<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\FeeEditorSession;
use App\Models\FeeEditorReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FeeEditorReportController extends Controller
{
    public function store(Request $request, $sessionId)
    {
        $validated = $request->validate([
            'nama_jurnal' => 'required|string|max:255',
            'link_scimagojr' => 'required|url',
            'peran' => 'required|string|max:255',
            'penugasan_awal' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'penugasan_akhir' => 'required|integer|min:1900|max:' . (date('Y') + 10) . '|gte:penugasan_awal',
            'bukti_undangan' => 'required|file|mimes:pdf|max:10240',
            'link_laman_resmi' => 'required|url',
            'bukti_aktivitas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $validated['fee_editor_session_id'] = $sessionId;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'diajukan';

        if ($request->hasFile('bukti_undangan')) {
            $validated['bukti_undangan_path'] = $request->file('bukti_undangan')->store('fee_editor/bukti_undangan', 'public');
        }

        if ($request->hasFile('bukti_aktivitas')) {
            $validated['bukti_aktivitas_path'] = $request->file('bukti_aktivitas')->store('fee_editor/bukti_aktivitas', 'public');
        }

        FeeEditorReport::create($validated);

        return redirect()->route('subdirektorat-inovasi.dosen.fee_editor.manajemen')->with('success', 'Laporan fee editor berhasil diajukan!');
    }

    public function edit(FeeEditorReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($report->status, ['diajukan', 'ditolak'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.fee_editor.manajemen')
                ->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $session = $report->session;

        return view('subdirektorat-inovasi.dosen.fee_editor.form-edit', compact('report', 'session'));
    }

    public function update(Request $request, FeeEditorReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($report->status, ['diajukan', 'ditolak'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.fee_editor.manajemen')
                ->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $validated = $request->validate([
            'nama_jurnal' => 'required|string|max:255',
            'link_scimagojr' => 'required|url',
            'peran' => 'required|string|max:255',
            'penugasan_awal' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'penugasan_akhir' => 'required|integer|min:1900|max:' . (date('Y') + 10) . '|gte:penugasan_awal',
            'bukti_undangan' => 'nullable|file|mimes:pdf|max:10240',
            'link_laman_resmi' => 'required|url',
            'bukti_aktivitas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('bukti_undangan')) {
            if ($report->bukti_undangan_path) {
                Storage::disk('public')->delete($report->bukti_undangan_path);
            }
            $validated['bukti_undangan_path'] = $request->file('bukti_undangan')->store('fee_editor/bukti_undangan', 'public');
        }

        if ($request->hasFile('bukti_aktivitas')) {
            if ($report->bukti_aktivitas_path) {
                Storage::disk('public')->delete($report->bukti_aktivitas_path);
            }
            $validated['bukti_aktivitas_path'] = $request->file('bukti_aktivitas')->store('fee_editor/bukti_aktivitas', 'public');
        }

        $report->update($validated);

        return redirect()->route('subdirektorat-inovasi.dosen.fee_editor.manajemen')->with('success', 'Laporan fee editor berhasil diperbarui!');
    }

    public function destroy(FeeEditorReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($report->status, ['diajukan', 'ditolak'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.fee_editor.manajemen')
                ->with('error', 'Laporan yang sudah diproses tidak dapat dihapus.');
        }

        if ($report->bukti_undangan_path) {
            Storage::disk('public')->delete($report->bukti_undangan_path);
        }
        if ($report->bukti_aktivitas_path) {
            Storage::disk('public')->delete($report->bukti_aktivitas_path);
        }

        $report->delete();

        return redirect()->route('subdirektorat-inovasi.dosen.fee_editor.manajemen')->with('success', 'Laporan fee editor berhasil dihapus!');
    }
}
