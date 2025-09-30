<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\MatchmakingSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchmakingLogbookController extends Controller
{
    /**
     * Menampilkan halaman logbook untuk submission tertentu.
     */
    public function show(MatchmakingSubmission $submission)
    {

        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $submission->load(['session', 'user', 'members.user', 'report']);


        return view('subdirektorat-inovasi.dosen.matchresearch.logbook', compact('submission'));
    }
}

