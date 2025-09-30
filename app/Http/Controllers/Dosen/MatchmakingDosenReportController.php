<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\MatchmakingReport;
use App\Models\MatchmakingSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MatchmakingDosenReportController extends Controller
{
    /**
     * Menampilkan form laporan atau membuat instance baru jika belum ada.
     */
    public function show($submissionId)
    {
        $submission = MatchmakingSubmission::with('report')->findOrFail($submissionId);

        // Otorisasi: Pastikan pengguna yang login adalah pemilik submission
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Kondisi: Hanya bisa diisi jika status diterima atau draft laporan
        if (!in_array($submission->status, ['diterima', 'draft_laporan'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.matchresearch.manajemen')
                ->with('error', 'Laporan tidak dapat diisi atau diubah saat ini.');
        }

        $report = $submission->report ?? new MatchmakingReport();
        $respondents = old('respondens', $report->qs_respondents ?? [['name' => ''], ['name' => '']]);

        return view('subdirektorat-inovasi.dosen.matchresearch.form-proposal', compact('submission', 'report', 'respondents'));
    }

    /**
     * Menyimpan atau memperbarui data laporan.
     */
    public function storeOrUpdate(Request $request, $submissionId)
    {
        $submission = MatchmakingSubmission::findOrFail($submissionId);

        // Otorisasi
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $validated = $request->validate([
            'proposal_path' => 'sometimes|nullable|file|mimes:pdf,jpg,png|max:5120',
            'article_path' => 'sometimes|nullable|file|mimes:pdf,jpg,png|max:5120',
            'journal_q1_name' => 'nullable|string|max:255',
            'scimagojr_link' => 'nullable|url|max:255',
            'submit_proof_path' => 'sometimes|nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'review_proof_path' => 'sometimes|nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'travel_proof_path' => 'sometimes|nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'setneg_approval_path' => 'sometimes|nullable|file|mimes:pdf|max:5120', // Validasi untuk field baru
            'visit_days' => 'nullable|integer|min:1|max:5',
            'respondens' => 'nullable|array',
            'respondens.*.name' => 'nullable|string|max:255',
            'action' => 'required|in:save_draft,submit_final',
        ]);

        DB::beginTransaction();
        try {
            $report = MatchmakingReport::firstOrNew(['matchmaking_submission_id' => $submissionId]);

            $data = $request->except(['_token', '_method', 'action', 'respondens']);
            
            // Filter responden yang kosong
            $qsRespondents = collect($request->input('respondens', []))
                ->filter(fn($resp) => !empty($resp['name']))
                ->values()
                ->all();
            $data['qs_respondents'] = $qsRespondents;
            
            // Handle file uploads
            $fileFields = ['proposal_path', 'article_path', 'submit_proof_path', 'review_proof_path', 'travel_proof_path', 'setneg_approval_path'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    // Hapus file lama jika ada
                    if ($report->{$field} && Storage::disk('public')->exists($report->{$field})) {
                        Storage::disk('public')->delete($report->{$field});
                    }
                    $path = $request->file($field)->store("matchmaking_reports/{$submissionId}", 'public');
                    $data[$field] = $path;
                }
            }
            
            $report->fill($data);
            $report->save();

            // Update status submission berdasarkan aksi
            if ($validated['action'] === 'submit_final') {
                $submission->status = 'menunggu_penilaian';
            } else {
                $submission->status = 'draft_laporan';
            }
            $submission->save();

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.matchresearch.manajemen')
                ->with('success', 'Laporan berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan laporan matchmaking: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan laporan.')->withInput();
        }
    }
}
