<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PresentingSession;
use App\Models\PresentingReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresentingReportController extends Controller
{
    public function store(Request $request, $sessionId)
    {
        $validated = $request->validate([
            'nama_conference' => 'required|string|max:255',
            'penyelenggaraan_ke' => 'required|integer|min:1',
            'lembaga_penyelenggara' => 'required|string|max:255',
            'link_website' => 'required|url',
            'tempat_pelaksanaan' => 'required|string|max:255',
            'negara_pelaksanaan' => 'required|string|max:255',
            'waktu_pelaksanaan_awal' => 'required|date',
            'waktu_pelaksanaan_akhir' => 'required|date|after_or_equal:waktu_pelaksanaan_awal',
            'judul_artikel' => 'required|string|max:500',
            'sdg_terkait' => 'required|array|min:1',
            'sdg_terkait.*' => 'in:SDG-1,SDG-2,SDG-3,SDG-4,SDG-5,SDG-6,SDG-7,SDG-8,SDG-9,SDG-10,SDG-11,SDG-12,SDG-13,SDG-14,SDG-15,SDG-16',
            'keywords_sdg' => 'required|array|min:1',
            'keywords_sdg.*' => 'string',
            'bukti_pendaftaran' => 'required|file|mimes:pdf|max:10240',
            'bukti_loa' => 'required|file|mimes:pdf|max:10240',
            'rencana_anggaran' => 'required|file|mimes:pdf|max:10240',
        ]);

        $validated['presenting_session_id'] = $sessionId;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'diajukan';
        $validated['sdg_terkait'] = json_encode($validated['sdg_terkait']);
        $validated['keywords_sdg'] = json_encode($validated['keywords_sdg']);

        if ($request->hasFile('bukti_pendaftaran')) {
            $validated['bukti_pendaftaran_path'] = $request->file('bukti_pendaftaran')->store('presenting/bukti_pendaftaran', 'public');
        }

        if ($request->hasFile('bukti_loa')) {
            $validated['bukti_loa_path'] = $request->file('bukti_loa')->store('presenting/bukti_loa', 'public');
        }

        if ($request->hasFile('rencana_anggaran')) {
            $validated['rencana_anggaran'] = $request->file('rencana_anggaran')->store('presenting/rencana_anggaran', 'public');
        }

        PresentingReport::create($validated);

        return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')->with('success', 'Laporan presenting berhasil diajukan!');
    }

    public function edit(PresentingReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($report->status, ['diajukan', 'ditolak'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $session = $report->session;

        return view('subdirektorat-inovasi.dosen.presenting.form-edit', compact('report', 'session'));
    }

    public function update(Request $request, PresentingReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($report->status, ['diajukan', 'ditolak'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $validated = $request->validate([
            'nama_conference' => 'required|string|max:255',
            'penyelenggaraan_ke' => 'required|integer|min:1',
            'lembaga_penyelenggara' => 'required|string|max:255',
            'link_website' => 'required|url',
            'tempat_pelaksanaan' => 'required|string|max:255',
            'negara_pelaksanaan' => 'required|string|max:255',
            'waktu_pelaksanaan_awal' => 'required|date',
            'waktu_pelaksanaan_akhir' => 'required|date|after_or_equal:waktu_pelaksanaan_awal',
            'judul_artikel' => 'required|string|max:500',
            'sdg_terkait' => 'required|array|min:1',
            'sdg_terkait.*' => 'in:SDG-1,SDG-2,SDG-3,SDG-4,SDG-5,SDG-6,SDG-7,SDG-8,SDG-9,SDG-10,SDG-11,SDG-12,SDG-13,SDG-14,SDG-15,SDG-16',
            'keywords_sdg' => 'required|array|min:1',
            'keywords_sdg.*' => 'string',
            'bukti_pendaftaran' => 'nullable|file|mimes:pdf|max:10240',
            'bukti_loa' => 'nullable|file|mimes:pdf|max:10240',
            'rencana_anggaran' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $validated['sdg_terkait'] = json_encode($validated['sdg_terkait']);
        $validated['keywords_sdg'] = json_encode($validated['keywords_sdg']);

        if ($request->hasFile('bukti_pendaftaran')) {
            if ($report->bukti_pendaftaran_path) {
                Storage::disk('public')->delete($report->bukti_pendaftaran_path);
            }
            $validated['bukti_pendaftaran_path'] = $request->file('bukti_pendaftaran')->store('presenting/bukti_pendaftaran', 'public');
        }

        if ($request->hasFile('bukti_loa')) {
            if ($report->bukti_loa_path) {
                Storage::disk('public')->delete($report->bukti_loa_path);
            }
            $validated['bukti_loa_path'] = $request->file('bukti_loa')->store('presenting/bukti_loa', 'public');
        }

        if ($request->hasFile('rencana_anggaran')) {
            if ($report->rencana_anggaran) {
                Storage::disk('public')->delete($report->rencana_anggaran);
            }
            $validated['rencana_anggaran'] = $request->file('rencana_anggaran')->store('presenting/rencana_anggaran', 'public');
        }

        $report->update($validated);

        return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')->with('success', 'Laporan presenting berhasil diperbarui!');
    }

    public function destroy(PresentingReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($report->status, ['diajukan', 'ditolak'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Laporan yang sudah diproses tidak dapat dihapus.');
        }

        if ($report->bukti_pendaftaran_path) {
            Storage::disk('public')->delete($report->bukti_pendaftaran_path);
        }
        if ($report->bukti_loa_path) {
            Storage::disk('public')->delete($report->bukti_loa_path);
        }
        if ($report->rencana_anggaran) {
            Storage::disk('public')->delete($report->rencana_anggaran);
        }

        $report->delete();

        return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')->with('success', 'Laporan presenting berhasil dihapus!');
    }
}
