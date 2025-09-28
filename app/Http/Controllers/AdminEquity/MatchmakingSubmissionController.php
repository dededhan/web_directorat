<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\MatchmakingSubmission;
use Illuminate\Http\Request;


class MatchmakingSubmissionController extends Controller
{

    public function show(MatchmakingSubmission $submission)
    {
        // Eager load relasi yang dibutuhkan
        $submission->load('user', 'session', 'members.user');
        return view('admin_equity.matchresearch.submission-detail', compact('submission'));
    }


    public function showReport(MatchmakingSubmission $submission)
    {
        $submission->load('user', 'session', 'report');

        if (!$submission->report) {
            return redirect()->route('admin_equity.matchresearch.submission.show', $submission->id)
                             ->with('error', 'Laporan untuk proposal ini belum diisi.');
        }

        return view('admin_equity.matchresearch.report-detail', compact('submission'));
    }


    public function updateStatus(Request $request, MatchmakingSubmission $submission)
    {
        $validated = $request->validate([
            'status' => 'required|in:diterima,ditolak_awal',
            'rejection_note' => 'required_if:status,ditolak_awal|nullable|string',
        ]);

        $submission->status = $validated['status'];
        if ($validated['status'] === 'ditolak_awal') {
            $submission->rejection_note = $validated['rejection_note'];
        } else {
            $submission->rejection_note = null;
        }

        $submission->save();

        return redirect()->route('admin_equity.matchresearch.show', $submission->matchmaking_session_id)
                         ->with('success', 'Status proposal berhasil diperbarui!');
    }

 
    public function updateReportStatus(Request $request, MatchmakingSubmission $submission)
    {
        $validated = $request->validate([
            'status' => 'required|in:lolos,revisi,tolak',
            'rejection_note' => 'required_if:status,revisi,tolak|nullable|string',
        ]);

        $submission->status = $validated['status'];
        if (in_array($validated['status'], ['revisi', 'tolak'])) {
            $submission->rejection_note = $validated['rejection_note'];
        } else {
            $submission->rejection_note = null;
        }

        $submission->save();

        return redirect()->route('admin_equity.matchresearch.show', $submission->matchmaking_session_id)
                         ->with('success', 'Hasil penilaian laporan berhasil disimpan!');
    }
}
