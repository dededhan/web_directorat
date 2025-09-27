<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\MatchmakingSession;
use App\Models\MatchmakingSubmission;
use Illuminate\Http\Request;

class MatchresearchController extends Controller
{

    public function index()
    {
        $sessions = MatchmakingSession::latest()->paginate(10);
        return view('admin_equity.matchresearch.index', compact('sessions'));
    }


    public function create()
    {
        return view('admin_equity.matchresearch.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
        ]);

        $validated['status'] = 'Buka';
        MatchmakingSession::create($validated);

        return redirect()->route('admin_equity.matchresearch.index')
                         ->with('success', 'Sesi Matchmaking berhasil dibuat!');
    }


    public function show($id)
    {
        $session = MatchmakingSession::with('submissions.user')->findOrFail($id);
        return view('admin_equity.matchresearch.show', compact('session'));
    }


    public function edit($id)
    {
        $session = MatchmakingSession::findOrFail($id);
        return view('admin_equity.matchresearch.edit', compact('session'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'status' => 'required|in:Buka,Tutup',
        ]);

        $session = MatchmakingSession::findOrFail($id);
        $session->update($validated);

        return redirect()->route('admin_equity.matchresearch.index')
                         ->with('success', 'Sesi Matchmaking berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $session = MatchmakingSession::findOrFail($id);
        $session->delete();

        return redirect()->route('admin_equity.matchresearch.index')
                         ->with('success', 'Sesi Matchmaking berhasil dihapus!');
    }

 
    public function showSubmission(MatchmakingSubmission $submission)
    {
        // Eager load relasi yang dibutuhkan
        $submission->load('user', 'session', 'members.user');
        return view('admin_equity.matchresearch.submission-detail', compact('submission'));
    }
    

    public function showFullReport(MatchmakingSubmission $submission)
    {
        $submission->load('user', 'session', 'report');

        if (!$submission->report) {
            return redirect()->route('admin_equity.matchresearch.submission.show', $submission->id)
                             ->with('error', 'Laporan untuk proposal ini belum diisi.');
        }

        return view('admin_equity.matchresearch.report-detail', compact('submission'));
    }



    public function updateSubmissionStatus(Request $request, MatchmakingSubmission $submission)
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

