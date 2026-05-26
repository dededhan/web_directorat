<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PresentingReport;
use App\Models\PresentingSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresentingSubmissionController extends Controller
{
    public function createForm(PresentingReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $session = $report->session;
        if (!$session || $session->computed_status !== 'Buka') {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Sesi sudah ditutup. Laporan akhir tidak dapat diubah.');
        }

        if ($report->status !== 'disetujui') {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Anda hanya bisa melengkapi laporan akhir setelah pengajuan disetujui.');
        }

        $submission = $report->submission;

        return view('subdirektorat-inovasi.dosen.presenting.form-laporan-akhir', compact('report', 'submission'));
    }

    public function store(Request $request, PresentingReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $session = $report->session;
        if (!$session || $session->computed_status !== 'Buka') {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Sesi sudah ditutup. Laporan akhir tidak dapat diubah.');
        }

        if ($report->status !== 'disetujui') {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Anda hanya bisa melengkapi laporan akhir setelah pengajuan disetujui.');
        }

        $validated = $request->validate([
            'bukti_perjalanan' => 'required|file|mimes:pdf|max:10240',
            'sertifikat_presenter' => 'required|file|mimes:pdf|max:10240',
            'ppt' => 'required|file|mimes:pdf,ppt,pptx|max:20480',
            'bukti_partner_riset' => 'nullable|file|mimes:pdf|max:10240',
            'sp_setneg' => 'nullable|file|mimes:pdf|max:10240',
            'responden_internasional_qs' => 'nullable|array',
            'responden_internasional_qs.*' => 'nullable|string|max:255',
            'manuscript_pdf' => 'required_without:manuscript_link|nullable|file|mimes:pdf|max:10240',
            'manuscript_link' => 'required_without:manuscript_pdf|nullable|url|max:255',
        ], [
            'manuscript_pdf.required_without' => 'Anda harus mengunggah file PDF manuskrip atau memasukkan tautan (URL) manuskrip.',
            'manuscript_link.required_without' => 'Anda harus memasukkan tautan (URL) manuskrip atau mengunggah file PDF manuskrip.',
            'manuscript_link.url' => 'Format tautan (URL) manuskrip tidak valid. Pastikan dimulai dengan http:// atau https://',
        ]);

        $data = ['presenting_report_id' => $report->id];

        $responden = collect($request->input('responden_internasional_qs', []))
            ->map(fn ($value) => trim($value))
            ->filter(fn ($value) => $value !== '');

        if ($responden->isNotEmpty() && $responden->count() < 1) {
            return back()->withErrors([
                'responden_internasional_qs' => 'Minimal 1 responden QS ketika diisi.',
            ])->withInput();
        }

        if ($request->hasFile('bukti_perjalanan')) {
            $data['bukti_perjalanan_path'] = $request->file('bukti_perjalanan')->store('presenting/bukti_perjalanan', 'public');
        }

        if ($request->hasFile('sertifikat_presenter')) {
            $data['sertifikat_presenter_path'] = $request->file('sertifikat_presenter')->store('presenting/sertifikat_presenter', 'public');
        }

        if ($request->hasFile('ppt')) {
            $data['ppt_path'] = $request->file('ppt')->store('presenting/ppt', 'public');
        }

        if ($request->hasFile('bukti_partner_riset')) {
            $data['bukti_partner_riset_path'] = $request->file('bukti_partner_riset')->store('presenting/bukti_partner_riset', 'public');
        }

        if ($request->hasFile('sp_setneg')) {
            $data['sp_setneg_path'] = $request->file('sp_setneg')->store('presenting/sp_setneg', 'public');
        }

        if ($request->hasFile('manuscript_pdf')) {
            $data['manuscript_path'] = $request->file('manuscript_pdf')->store('presenting/manuscript', 'public');
        }

        if ($request->filled('manuscript_link')) {
            $data['manuscript_link'] = $request->input('manuscript_link');
        }

        $data['responden_internasional_qs'] = $responden->isNotEmpty() ? $responden->values()->all() : null;

        PresentingSubmission::create($data);

        return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')->with('success', 'Laporan akhir berhasil diajukan!');
    }

    public function update(Request $request, PresentingReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $session = $report->session;
        if (!$session || $session->computed_status !== 'Buka') {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Sesi sudah ditutup. Laporan akhir tidak dapat diubah.');
        }

        if ($report->status !== 'disetujui') {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Anda hanya bisa melengkapi laporan akhir setelah pengajuan disetujui.');
        }

        $submission = $report->submission;
        if (!$submission) {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')
                ->with('error', 'Laporan akhir tidak ditemukan.');
        }

        $validated = $request->validate([
            'bukti_perjalanan' => 'nullable|file|mimes:pdf|max:10240',
            'sertifikat_presenter' => 'nullable|file|mimes:pdf|max:10240',
            'ppt' => 'nullable|file|mimes:pdf,ppt,pptx|max:20480',
            'bukti_partner_riset' => 'nullable|file|mimes:pdf|max:10240',
            'sp_setneg' => 'nullable|file|mimes:pdf|max:10240',
            'responden_internasional_qs' => 'nullable|array',
            'responden_internasional_qs.*' => 'nullable|string|max:255',
            'manuscript_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'manuscript_link' => 'nullable|url|max:255',
        ], [
            'manuscript_link.url' => 'Format tautan (URL) manuskrip tidak valid. Pastikan dimulai dengan http:// atau https://',
        ]);

        // Pastikan salah satu manuskrip (PDF lama/baru atau Tautan baru/lama) terisi
        $hasManuscript = ($submission->manuscript_path && !$request->boolean('delete_manuscript_pdf')) 
            || $request->hasFile('manuscript_pdf') 
            || $request->filled('manuscript_link');

        if (!$hasManuscript) {
            return back()->withErrors([
                'manuscript_pdf' => 'Anda harus mengunggah file PDF manuskrip atau memasukkan tautan (URL) manuskrip.',
            ])->withInput();
        }

        $data = [];

        $responden = collect($request->input('responden_internasional_qs', []))
            ->map(fn ($value) => trim($value))
            ->filter(fn ($value) => $value !== '');

        if ($responden->isNotEmpty() && $responden->count() < 1) {
            return back()->withErrors([
                'responden_internasional_qs' => 'Minimal 1 responden QS ketika diisi.',
            ])->withInput();
        }

        if ($request->hasFile('bukti_perjalanan')) {
            if ($submission->bukti_perjalanan_path) {
                Storage::disk('public')->delete($submission->bukti_perjalanan_path);
            }
            $data['bukti_perjalanan_path'] = $request->file('bukti_perjalanan')->store('presenting/bukti_perjalanan', 'public');
        }

        if ($request->hasFile('sertifikat_presenter')) {
            if ($submission->sertifikat_presenter_path) {
                Storage::disk('public')->delete($submission->sertifikat_presenter_path);
            }
            $data['sertifikat_presenter_path'] = $request->file('sertifikat_presenter')->store('presenting/sertifikat_presenter', 'public');
        }

        if ($request->hasFile('ppt')) {
            if ($submission->ppt_path) {
                Storage::disk('public')->delete($submission->ppt_path);
            }
            $data['ppt_path'] = $request->file('ppt')->store('presenting/ppt', 'public');
        }

        if ($request->hasFile('bukti_partner_riset')) {
            if ($submission->bukti_partner_riset_path) {
                Storage::disk('public')->delete($submission->bukti_partner_riset_path);
            }
            $data['bukti_partner_riset_path'] = $request->file('bukti_partner_riset')->store('presenting/bukti_partner_riset', 'public');
        }

        if ($request->hasFile('sp_setneg')) {
            if ($submission->sp_setneg_path) {
                Storage::disk('public')->delete($submission->sp_setneg_path);
            }
            $data['sp_setneg_path'] = $request->file('sp_setneg')->store('presenting/sp_setneg', 'public');
        }

        if ($request->hasFile('manuscript_pdf')) {
            if ($submission->manuscript_path) {
                Storage::disk('public')->delete($submission->manuscript_path);
            }
            $data['manuscript_path'] = $request->file('manuscript_pdf')->store('presenting/manuscript', 'public');
        } elseif ($request->boolean('delete_manuscript_pdf')) {
            if ($submission->manuscript_path) {
                Storage::disk('public')->delete($submission->manuscript_path);
            }
            $data['manuscript_path'] = null;
        }

        $data['manuscript_link'] = $request->input('manuscript_link');

        $data['responden_internasional_qs'] = $responden->isNotEmpty() ? $responden->values()->all() : null;

        $submission->update($data);

        return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')->with('success', 'Laporan akhir berhasil diperbarui!');
    }
}
