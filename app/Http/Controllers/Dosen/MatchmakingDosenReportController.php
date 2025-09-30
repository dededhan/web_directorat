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

        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if (!in_array($submission->status, ['diterima', 'draft_laporan', 'revisi'])) {
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
            'setneg_approval_path' => 'sometimes|nullable|file|mimes:pdf|max:5120',
            'visit_days' => 'nullable|integer|min:1|max:5',
            'respondens' => 'nullable|array',
            'respondens.*.name' => 'nullable|string|max:255',
            'action' => 'required|in:save_draft,submit_final',
        ]);

        DB::beginTransaction();
        try {
            $report = MatchmakingReport::firstOrNew(['matchmaking_submission_id' => $submissionId]);

            $data = $request->except(['_token', '_method', 'action', 'respondens']);


            $qsRespondents = collect($request->input('respondens', []))
                ->filter(fn($resp) => !empty($resp['name']))
                ->values()
                ->all();
            $data['qs_respondents'] = $qsRespondents;

            $fileFields = ['proposal_path', 'article_path', 'submit_proof_path', 'review_proof_path', 'travel_proof_path', 'setneg_approval_path'];
            $userName = Str::slug($submission->user->name, '_');

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {

                    if ($report->{$field} && Storage::disk('public')->exists($report->{$field})) {
                        Storage::disk('public')->delete($report->{$field});
                    }
                    

                    $file = $request->file($field);
                    $extension = $file->getClientOriginalExtension();
                    $filename = "{$userName}_{$field}.{$extension}";
                    $path = $file->storeAs("matchmaking_reports/{$submissionId}", $filename, 'public');


                    $data[$field] = $path;
                }
            }

            $report->fill($data);
            $report->save();
            
            $oldStatus = $submission->status;
            $newStatus = ($validated['action'] === 'submit_final') ? 'menunggu_penilaian' : 'draft_laporan';
            
            if ($oldStatus !== $newStatus) {
                $submission->status = $newStatus;
                
                $logNotes = ($newStatus === 'menunggu_penilaian') 
                    ? 'Dosen mengirimkan laporan akhir untuk dinilai.' 
                    : 'Dosen menyimpan draf laporan.';
                
                $submission->addStatusLog($newStatus, $logNotes);
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

