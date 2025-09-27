<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\MatchmakingReport;
use App\Models\MatchmakingSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class MatchmakingDosenReportController extends Controller
{

    public function show($submissionId)
    {
        $submission = MatchmakingSubmission::with('report')->findOrFail($submissionId);


        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }


        if (!in_array($submission->status, ['diterima', 'draft_laporan'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.matchresearch.manajemen')
                             ->with('error', 'Laporan tidak bisa diisi atau sudah dikirim.');
        }


        $report = $submission->report ?? new MatchmakingReport();
        

        $respondents = is_array($report->qs_respondents) ? $report->qs_respondents : [['name' => ''], ['name' => '']];


        return view('subdirektorat-inovasi.dosen.matchresearch.form-proposal', compact('submission', 'report', 'respondents'));
    }


    public function storeOrUpdate(Request $request, $submissionId)
    {
        $submission = MatchmakingSubmission::with('user')->findOrFail($submissionId);


        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }
        

        $validated = $request->validate([
            'proposal_path' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'article_path' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'journal_q1_name' => 'required|string|max:255',
            'scimagojr_link' => 'required|url|max:255',
            'submit_proof_path' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'review_proof_path' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'travel_proof_path' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'visit_days' => 'required|integer|min:1',
            'respondens' => 'required|array|min:2',
            'respondens.*.name' => 'required|string|max:255',
            'action' => 'required|in:save_draft,submit_final'
        ]);

        $report = MatchmakingReport::firstOrNew(['matchmaking_submission_id' => $submission->id]);
        
        $dataToUpdate = [
            'journal_q1_name' => $validated['journal_q1_name'],
            'scimagojr_link' => $validated['scimagojr_link'],
            'visit_days' => $validated['visit_days'],
            'qs_respondents' => $validated['respondens'],
        ];

        $fileFields = [
            'proposal_path' => 'ProposalFinal', 
            'article_path' => 'Artikel', 
            'submit_proof_path' => 'BuktiSubmit', 
            'review_proof_path' => 'BuktiReview', 
            'travel_proof_path' => 'BuktiPerjalanan'
        ];
        
        $proposerName = Str::slug($submission->user->name, '_');
        $date = Carbon::now()->format('Ymd');

        foreach ($fileFields as $field => $docType) {
            if ($request->hasFile($field)) {
                if ($report->{$field} && Storage::disk('public')->exists($report->{$field})) {
                    Storage::disk('public')->delete($report->{$field});
                }
                
                $file = $request->file($field);
                $extension = $file->getClientOriginalExtension();
                $filename = "{$proposerName}_{$docType}_{$date}.{$extension}";
                
                $path = $file->storeAs("matchmaking_reports/{$submission->id}", $filename, 'public');
                $dataToUpdate[$field] = $path;
            }
        }
        
        $report->fill($dataToUpdate)->save();

        if ($validated['action'] === 'submit_final') {
            $submission->status = 'menunggu_penilaian';
            $message = 'Laporan berhasil dikirim dan akan segera dinilai.';
        } else {
            $submission->status = 'draft_laporan';
            $message = 'Laporan berhasil disimpan sebagai draft.';
        }
        $submission->save();

        return redirect()->route('subdirektorat-inovasi.dosen.matchresearch.manajemen')->with('success', $message);
    }
}

