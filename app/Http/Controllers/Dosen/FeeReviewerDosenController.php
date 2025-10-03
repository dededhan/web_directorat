<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\FeeReviewerSession;
use App\Models\FeeReviewerReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FeeReviewerDosenController extends Controller
{
    public function listSessions()
    {
        $sessions = FeeReviewerSession::latest()->get()->filter(function ($session) {
            $now = Carbon::now();
            $periodeAkhir = Carbon::parse($session->periode_akhir);
            return $session->status === 'Buka' && $now->lte($periodeAkhir);
        });

        return view('subdirektorat-inovasi.dosen.fee_reviewer.list-sesi', compact('sessions'));
    }

    public function manageReports()
    {
        $reports = FeeReviewerReport::with('session')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        $groupedReports = $reports->groupBy('fee_reviewer_session_id');

        return view('subdirektorat-inovasi.dosen.fee_reviewer.manajemen', [
            'groupedReports' => $groupedReports
        ]);
    }

    public function createReportForm($sessionId)
    {
        $session = FeeReviewerSession::findOrFail($sessionId);

        $now = Carbon::now();
        $periodeAkhir = Carbon::parse($session->periode_akhir);
        
        if ($session->status !== 'Buka' || $now->gt($periodeAkhir)) {
            return redirect()->route('subdirektorat-inovasi.dosen.fee_reviewer.list-sesi')->with('error', 'Sesi pengajuan ini sudah ditutup.');
        }
        
        return view('subdirektorat-inovasi.dosen.fee_reviewer.form-pengajuan', compact('session'));
    }

    public function showDetails(FeeReviewerReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $report->load('session');

        return view('subdirektorat-inovasi.dosen.fee_reviewer.details-report', compact('report'));
    }
}
