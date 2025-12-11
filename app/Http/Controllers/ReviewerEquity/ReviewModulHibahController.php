<?php

namespace App\Http\Controllers\ReviewerEquity;

use App\Http\Controllers\Controller;
use App\Models\ProposalModul;
use App\Models\HibahModulReview;
use App\Models\HibahModulAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewModulHibahController extends Controller
{
    public function index()
    {
        $proposals = ProposalModul::where('reviewer_id', Auth::id())
            ->with(['user', 'user.prodi'])
            ->latest()
            ->paginate(10);
        
        return view('reviewer_equity.hibah_modul.index', compact('proposals'));
    }

    public function show(ProposalModul $proposal)
    {
        // Verify this proposal is assigned to current reviewer
        abort_if($proposal->reviewer_id !== Auth::id(), 403, 'Unauthorized access to this proposal');
        
        $proposal->load([
            'user',
            'sesi.moduls.subChapters',
            'files',
            'reviews.reviewer',
            'reviews.modul'
        ]);
        
        return view('reviewer_equity.hibah_modul.show', compact('proposal'));
    }

    public function storeReview(Request $request, ProposalModul $proposal, HibahModulAkhir $modul)
    {
        // Verify this proposal is assigned to current reviewer
        abort_if($proposal->reviewer_id !== Auth::id(), 403);

        $validated = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'komentar' => 'required|string|max:2000',
        ]);

        // Create or update review for this modul
        HibahModulReview::updateOrCreate(
            [
                'proposal_modul_id' => $proposal->id,
                'hibah_modul_akhir_id' => $modul->id,
                'reviewer_id' => Auth::id(),
            ],
            [
                'nilai' => $validated['nilai'],
                'komentar' => $validated['komentar'],
                'status_review' => 'reviewed',
            ]
        );

        return back()->with('success', 'Review untuk modul berhasil disimpan!');
    }

    public function submitFinalReview(Request $request, ProposalModul $proposal)
    {
        // Verify this proposal is assigned to current reviewer
        abort_if($proposal->reviewer_id !== Auth::id(), 403);

        // Calculate average score from all modul reviews
        $averageScore = HibahModulReview::where('proposal_modul_id', $proposal->id)
            ->where('reviewer_id', Auth::id())
            ->avg('nilai');

        // Check if all moduls have been reviewed
        $totalModuls = $proposal->sesi->moduls->count();
        $reviewedModuls = HibahModulReview::where('proposal_modul_id', $proposal->id)
            ->where('reviewer_id', Auth::id())
            ->distinct('hibah_modul_akhir_id')
            ->count();

        if ($reviewedModuls < $totalModuls) {
            return back()->with('error', 'Anda harus menyelesaikan review untuk semua modul terlebih dahulu.');
        }

        // Update proposal with final review
        $proposal->update([
            'komentar_reviewer' => 'Review selesai dengan rata-rata nilai: ' . number_format($averageScore, 2),
            'nilai_reviewer' => $averageScore,
            'tanggal_review' => now(),
            'status' => 'reviewed',
        ]);

        return redirect()
            ->route('reviewer_equity.hibah_modul.index')
            ->with('success', 'Review final berhasil disubmit dengan nilai rata-rata: ' . number_format($averageScore, 2));
    }
}

