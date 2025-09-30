<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ApcSession;
use App\Models\ApcSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApcDosenController extends Controller
{
    public function listSessions()
    {
        $allSessions = ApcSession::latest()->get();
        $sessions = $allSessions->filter(function ($session) {
            return $session->computed_status === 'Buka';
        });

        return view('subdirektorat-inovasi.dosen.apc.list-sesi', compact('sessions'));
    }

    public function manageSubmissions()
    {
        ApcSession::syncSubmissionsForClosedSessions();

        $submissions = ApcSubmission::with('session')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        $groupedSubmissions = $submissions->groupBy('apc_session_id');

        return view('subdirektorat-inovasi.dosen.apc.manajemen', [
            'groupedSubmissions' => $groupedSubmissions
        ]);
    }

    public function createSubmissionForm($sessionId)
    {
        $session = ApcSession::findOrFail($sessionId);

        if ($session->computed_status !== 'Buka') {
            return redirect()->route('subdirektorat-inovasi.dosen.apc.list-sesi')->with('error', 'Sesi pengajuan ini sudah ditutup.');
        }
        
        return view('subdirektorat-inovasi.dosen.apc.form-pengajuan', compact('session'));
    }

        public function showDetails(ApcSubmission $submission)
    {
        // Authorization: Ensure the logged-in user owns this submission
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Eager load relationships for efficiency
        $submission->load('authors', 'session');

        return view('subdirektorat-inovasi.dosen.apc.details-proposal', compact('submission'));
    }
}

