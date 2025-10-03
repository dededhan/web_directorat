<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\FeeReviewerSession;
use App\Models\FeeReviewerReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FeeReviewerReportController extends Controller
{
    public function store(Request $request, $sessionId)
    {
        $validated = $request->validate([
            'judul_artikel' => 'required|string|max:255',
            'nama_jurnal' => 'required|string|max:255',
            'link_scimagojr' => 'required|url',
            'tanggal_review' => 'required|date',
            'bukti_undangan' => 'required|file|mimes:pdf|max:10240',
            'bukti_hasil_review' => 'required|file|mimes:pdf|max:10240',
            'bukti_pengiriman_tepat_waktu' => 'required|file|mimes:pdf|max:10240',
            'bukti_lain' => 'nullable|file|mimes:pdf|max:10240',
            'surat_pernyataan' => 'required|file|mimes:pdf|max:10240',
        ]);

        $validated['fee_reviewer_session_id'] = $sessionId;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'diajukan';

        if ($request->hasFile('bukti_undangan')) {
            $validated['bukti_undangan_path'] = $request->file('bukti_undangan')->store('fee_reviewer/bukti_undangan', 'public');
        }

        if ($request->hasFile('bukti_hasil_review')) {
            $validated['bukti_hasil_review_path'] = $request->file('bukti_hasil_review')->store('fee_reviewer/bukti_hasil_review', 'public');
        }

        if ($request->hasFile('bukti_pengiriman_tepat_waktu')) {
            $validated['bukti_pengiriman_tepat_waktu_path'] = $request->file('bukti_pengiriman_tepat_waktu')->store('fee_reviewer/bukti_pengiriman', 'public');
        }

        if ($request->hasFile('bukti_lain')) {
            $validated['bukti_lain_path'] = $request->file('bukti_lain')->store('fee_reviewer/bukti_lain', 'public');
        }

        if ($request->hasFile('surat_pernyataan')) {
            $validated['surat_pernyataan_path'] = $request->file('surat_pernyataan')->store('fee_reviewer/surat_pernyataan', 'public');
        }

        FeeReviewerReport::create($validated);

        return redirect()->route('subdirektorat-inovasi.dosen.fee_reviewer.manajemen')->with('success', 'Laporan fee reviewer berhasil diajukan!');
    }

    public function edit(FeeReviewerReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($report->status, ['diajukan', 'ditolak'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.fee_reviewer.manajemen')
                ->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $session = $report->session;

        return view('subdirektorat-inovasi.dosen.fee_reviewer.form-edit', compact('report', 'session'));
    }

    public function update(Request $request, FeeReviewerReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($report->status, ['diajukan', 'ditolak'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.fee_reviewer.manajemen')
                ->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $validated = $request->validate([
            'judul_artikel' => 'required|string|max:255',
            'nama_jurnal' => 'required|string|max:255',
            'link_scimagojr' => 'required|url',
            'tanggal_review' => 'required|date',
            'bukti_undangan' => 'nullable|file|mimes:pdf|max:10240',
            'bukti_hasil_review' => 'nullable|file|mimes:pdf|max:10240',
            'bukti_pengiriman_tepat_waktu' => 'nullable|file|mimes:pdf|max:10240',
            'bukti_lain' => 'nullable|file|mimes:pdf|max:10240',
            'surat_pernyataan' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('bukti_undangan')) {
            if ($report->bukti_undangan_path) {
                Storage::disk('public')->delete($report->bukti_undangan_path);
            }
            $validated['bukti_undangan_path'] = $request->file('bukti_undangan')->store('fee_reviewer/bukti_undangan', 'public');
        }

        if ($request->hasFile('bukti_hasil_review')) {
            if ($report->bukti_hasil_review_path) {
                Storage::disk('public')->delete($report->bukti_hasil_review_path);
            }
            $validated['bukti_hasil_review_path'] = $request->file('bukti_hasil_review')->store('fee_reviewer/bukti_hasil_review', 'public');
        }

        if ($request->hasFile('bukti_pengiriman_tepat_waktu')) {
            if ($report->bukti_pengiriman_tepat_waktu_path) {
                Storage::disk('public')->delete($report->bukti_pengiriman_tepat_waktu_path);
            }
            $validated['bukti_pengiriman_tepat_waktu_path'] = $request->file('bukti_pengiriman_tepat_waktu')->store('fee_reviewer/bukti_pengiriman', 'public');
        }

        if ($request->hasFile('bukti_lain')) {
            if ($report->bukti_lain_path) {
                Storage::disk('public')->delete($report->bukti_lain_path);
            }
            $validated['bukti_lain_path'] = $request->file('bukti_lain')->store('fee_reviewer/bukti_lain', 'public');
        }

        if ($request->hasFile('surat_pernyataan')) {
            if ($report->surat_pernyataan_path) {
                Storage::disk('public')->delete($report->surat_pernyataan_path);
            }
            $validated['surat_pernyataan_path'] = $request->file('surat_pernyataan')->store('fee_reviewer/surat_pernyataan', 'public');
        }

        $report->update($validated);

        return redirect()->route('subdirektorat-inovasi.dosen.fee_reviewer.manajemen')->with('success', 'Laporan fee reviewer berhasil diperbarui!');
    }

    public function destroy(FeeReviewerReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($report->status, ['diajukan', 'ditolak'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.fee_reviewer.manajemen')
                ->with('error', 'Laporan yang sudah diproses tidak dapat dihapus.');
        }

        if ($report->bukti_undangan_path) {
            Storage::disk('public')->delete($report->bukti_undangan_path);
        }
        if ($report->bukti_hasil_review_path) {
            Storage::disk('public')->delete($report->bukti_hasil_review_path);
        }
        if ($report->bukti_pengiriman_tepat_waktu_path) {
            Storage::disk('public')->delete($report->bukti_pengiriman_tepat_waktu_path);
        }
        if ($report->bukti_lain_path) {
            Storage::disk('public')->delete($report->bukti_lain_path);
        }
        if ($report->surat_pernyataan_path) {
            Storage::disk('public')->delete($report->surat_pernyataan_path);
        }

        $report->delete();

        return redirect()->route('subdirektorat-inovasi.dosen.fee_reviewer.manajemen')->with('success', 'Laporan fee reviewer berhasil dihapus!');
    }
}
