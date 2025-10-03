<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\FeeEditorSession;
use App\Models\FeeEditorReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FeeEditorDosenController extends Controller
{
    public function listSessions()
    {
        $sessions = FeeEditorSession::latest()->get()->filter(function ($session) {
            $now = Carbon::now();
            $periodeAkhir = Carbon::parse($session->periode_akhir);
            return $session->status === 'Buka' && $now->lte($periodeAkhir);
        });

        return view('subdirektorat-inovasi.dosen.fee_editor.list-sesi', compact('sessions'));
    }

    public function manageReports()
    {
        $reports = FeeEditorReport::with('session')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        $groupedReports = $reports->groupBy('fee_editor_session_id');

        return view('subdirektorat-inovasi.dosen.fee_editor.manajemen', [
            'groupedReports' => $groupedReports
        ]);
    }

    public function createReportForm($sessionId)
    {
        $session = FeeEditorSession::findOrFail($sessionId);

        $now = Carbon::now();
        $periodeAkhir = Carbon::parse($session->periode_akhir);
        
        if ($session->status !== 'Buka' || $now->gt($periodeAkhir)) {
            return redirect()->route('subdirektorat-inovasi.dosen.fee_editor.list-sesi')->with('error', 'Sesi pengajuan ini sudah ditutup.');
        }
        
        return view('subdirektorat-inovasi.dosen.fee_editor.form-pengajuan', compact('session'));
    }

    public function showDetails(FeeEditorReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $report->load('session');

        return view('subdirektorat-inovasi.dosen.fee_editor.details-report', compact('report'));
    }
}
