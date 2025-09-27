<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\MatchmakingSession;
use App\Models\MatchmakingSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Monarobase\CountryList\CountryListFacade as Countries;
use Carbon\Carbon;

class MatchmakingDosenController extends Controller
{
    public function listSessions()
    {
        $sessions = MatchmakingSession::where('status', 'Buka')
            ->whereDate('periode_awal', '<=', Carbon::now())
            ->whereDate('periode_akhir', '>=', Carbon::now())
            ->latest()
            ->get();
            
        return view('subdirektorat-inovasi.dosen.matchresearch.list-sesi', compact('sessions'));
    }

    public function manageSubmissions()
    {
        $submissions = MatchmakingSubmission::where('user_id', Auth::id())
            ->with('session')
            ->latest()
            ->paginate(10);

        return view('subdirektorat-inovasi.dosen.matchresearch.manajemen', compact('submissions'));
    }

    public function createSubmissionForm($sessionId)
    {
        $session = MatchmakingSession::findOrFail($sessionId);
        
        $countriesList = Countries::getList('en', 'php');
        
        $formattedCountries = [];
        foreach ($countriesList as $code => $name) {
            $formattedCountries[] = ['code' => $code, 'name' => $name];
        }

        return view('subdirektorat-inovasi.dosen.matchresearch.form-pengajuan', [
            'session' => $session,
            'countries' => $formattedCountries 
        ]);
    }


}
