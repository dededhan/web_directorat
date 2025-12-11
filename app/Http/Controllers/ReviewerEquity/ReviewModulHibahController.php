<?php

namespace App\Http\Controllers\ReviewerEquity;

use App\Http\Controllers\Controller;
use App\Models\ProposalModul;
use App\Models\HibahModulReview;
use App\Models\HibahModulSubChapter;
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
        
        $proposal->load(['user', 'user.prodi', 'files', 'reviews']);
        
        return view('reviewer_equity.hibah_modul.show', compact('proposal'));
    }

    public function storeReview(Request $request, ProposalModul $proposal, HibahModulSubChapter $subChapter)
    {
        // Verify this proposal is assigned to current reviewer
        abort_if($proposal->reviewer_id !== Auth::id(), 403);

        $validated = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'komentar' => 'nullable|string|max:1000',
        ]);

        // Check if file exists for this subchapter
        $fileExists = $proposal->files()
            ->where('hibah_modul_sub_chapter_id', $subChapter->id)
            ->exists();

        if (!$fileExists) {
            return back()->with('error', 'Tidak dapat memberikan review. File belum diupload untuk bagian ini.');
        }

        // Create or update review
        HibahModulReview::updateOrCreate(
            [
                'proposal_modul_id' => $proposal->id,
                'hibah_modul_sub_chapter_id' => $subChapter->id,
                'reviewer_id' => Auth::id(),
            ],
            [
                'nilai' => $validated['nilai'],
                'komentar' => $validated['komentar'],
            ]
        );

        return back()->with('success', 'Review berhasil disimpan!');
    }

    public function submitFinalReview(Request $request, ProposalModul $proposal)
    {
        // Verify this proposal is assigned to current reviewer
        abort_if($proposal->reviewer_id !== Auth::id(), 403);

        $validated = $request->validate([
            'komentar_reviewer' => 'required|string|max:2000',
        ]);

        // Calculate average score
        $averageScore = $proposal->reviews()
            ->where('reviewer_id', Auth::id())
            ->avg('nilai');

        // Update proposal with final review
        $proposal->update([
            'komentar_reviewer' => $validated['komentar_reviewer'],
            'nilai_reviewer' => $averageScore,
            'tanggal_review' => now(),
            'status' => 'reviewed',
        ]);

        return redirect()
            ->route('reviewer_equity.hibah_modul.index')
            ->with('success', 'Review final berhasil disubmit!');
    }
}
