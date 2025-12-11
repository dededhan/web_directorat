<?php

namespace App\Http\Controllers\ReviewerEquity;

use App\Http\Controllers\Controller;
use App\Models\ProposalStudentExchange;
use App\Models\StudentExchangeReview;
use App\Models\StudentExchangeModul;
use Illuminate\Http\Request;

class ReviewStudentExchangeController extends Controller
{
    public function index()
    {
        $proposals = ProposalStudentExchange::where('reviewer_id', auth()->id())
            ->with(['user', 'user.prodi', 'sesi', 'reviewer'])
            ->latest()
            ->paginate(10);

        return view('reviewer_equity.student_exchange.index', compact('proposals'));
    }

    public function show(ProposalStudentExchange $proposal)
    {
        // Verify this proposal is assigned to current reviewer
        if ($proposal->reviewer_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this proposal');
        }

        $proposal->load([
            'user',
            'sesi.moduls.subChapters',
            'files',
            'anggota',
            'reviews.reviewer',
            'reviews.modul'
        ]);

        return view('reviewer_equity.student_exchange.show', compact('proposal'));
    }

    public function storeReview(Request $request, ProposalStudentExchange $proposal, StudentExchangeModul $modul)
    {
        // Verify this proposal is assigned to current reviewer
        if ($proposal->reviewer_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'komentar' => 'required|string|max:2000',
        ]);

        // Create or update review for this modul
        StudentExchangeReview::updateOrCreate(
            [
                'student_exchange_proposal_id' => $proposal->id,
                'student_exchange_modul_id' => $modul->id,
                'reviewer_id' => auth()->id(),
            ],
            [
                'nilai' => $validated['nilai'],
                'komentar' => $validated['komentar'],
                'status_review' => 'reviewed',
            ]
        );

        return back()->with('success', 'Review untuk modul berhasil disimpan!');
    }

    public function submitFinalReview(Request $request, ProposalStudentExchange $proposal)
    {
        // Verify this proposal is assigned to current reviewer
        if ($proposal->reviewer_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'komentar_reviewer' => 'required|string|max:2000',
        ]);

        // Calculate average nilai from all modul reviews
        $avgNilai = $proposal->reviews()
            ->where('reviewer_id', auth()->id())
            ->avg('nilai');

        // Update proposal with final review
        $proposal->update([
            'komentar_reviewer' => $validated['komentar_reviewer'],
            'nilai_reviewer' => $avgNilai,
            'tanggal_review' => now(),
            'status' => 'reviewed',
        ]);

        return redirect()
            ->route('reviewer_equity.student_exchange.index')
            ->with('success', 'Review final berhasil disubmit ke admin!');
    }
}
