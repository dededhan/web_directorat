<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PresentingSession;
use App\Models\PresentingReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresentingDosenController extends Controller
{
    public function listSessions()
    {
        $sessions = PresentingSession::latest()->get()->filter(function ($session) {
            $now = Carbon::now();
            $periodeAkhir = Carbon::parse($session->periode_akhir);
            return $session->status === 'Buka' && $now->lte($periodeAkhir);
        });

        return view('subdirektorat-inovasi.dosen.presenting.list-sesi', compact('sessions'));
    }

    public function manageReports()
    {
        $reports = PresentingReport::with('session')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        $groupedReports = $reports->groupBy('presenting_session_id');

        return view('subdirektorat-inovasi.dosen.presenting.manajemen', [
            'groupedReports' => $groupedReports
        ]);
    }

    public function createReportForm($sessionId)
    {
        $session = PresentingSession::findOrFail($sessionId);

        $now = Carbon::now();
        $periodeAkhir = Carbon::parse($session->periode_akhir);
        
        if ($session->status !== 'Buka' || $now->gt($periodeAkhir)) {
            return redirect()->route('subdirektorat-inovasi.dosen.presenting.list-sesi')->with('error', 'Sesi pengajuan ini sudah ditutup.');
        }
        
        return view('subdirektorat-inovasi.dosen.presenting.form-pengajuan', compact('session'));
    }

    public function showDetails(PresentingReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $report->load(['session', 'submission']);

        return view('subdirektorat-inovasi.dosen.presenting.details-report', compact('report'));
    }
}
