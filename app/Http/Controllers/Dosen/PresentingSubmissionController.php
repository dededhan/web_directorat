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
            'responden_internasional_qs' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = ['presenting_report_id' => $report->id];

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

        if ($request->hasFile('responden_internasional_qs')) {
            $data['responden_internasional_qs_path'] = $request->file('responden_internasional_qs')->store('presenting/responden_qs', 'public');
        }

        PresentingSubmission::create($data);

        return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')->with('success', 'Laporan akhir berhasil diajukan!');
    }

    public function update(Request $request, PresentingReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
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
            'responden_internasional_qs' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = [];

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

        if ($request->hasFile('responden_internasional_qs')) {
            if ($submission->responden_internasional_qs_path) {
                Storage::disk('public')->delete($submission->responden_internasional_qs_path);
            }
            $data['responden_internasional_qs_path'] = $request->file('responden_internasional_qs')->store('presenting/responden_qs', 'public');
        }

        $submission->update($data);

        return redirect()->route('subdirektorat-inovasi.dosen.presenting.manajemen')->with('success', 'Laporan akhir berhasil diperbarui!');
    }
}
