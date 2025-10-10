<?php

namespace App\Http\Controllers\ReviewerEquity;

use App\Http\Controllers\Controller;
use App\Models\ProposalModul;
use App\Models\ModulReview;
use App\Models\ModulSubChapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewModulHibahController extends Controller
{
    public function index()
    {
        $proposals = ProposalModul::where('reviewer_id', Auth::id())
            ->with(['sesi', 'user', 'anggota'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        
        return view('reviewer_equity.hibah_modul.index', compact('proposals'));
    }

    public function show(ProposalModul $proposal)
    {
        abort_if($proposal->reviewer_id !== Auth::id(), 403, 'Anda tidak ditugaskan untuk me-review proposal ini.');
        
        $proposal->load([
            'sesi.moduls.subChapters',
            'user',
            'anggota',
            'files.subChapter',
            'reviews' => function($query) {
                $query->where('reviewer_id', Auth::id());
            }
        ]);
        
        return view('reviewer_equity.hibah_modul.show', compact('proposal'));
    }

    public function storeReview(Request $request, ProposalModul $proposal, ModulSubChapter $subChapter)
    {
        abort_if($proposal->reviewer_id !== Auth::id(), 403);

        $request->validate([
            'komentar' => 'required|string',
            'nilai' => 'nullable|integer|min:0|max:100',
        ]);

        ModulReview::updateOrCreate(
            [
                'proposal_modul_id' => $proposal->id,
                'modul_sub_chapter_id' => $subChapter->id,
                'reviewer_id' => Auth::id(),
            ],
            [
                'komentar' => $request->komentar,
                'nilai' => $request->nilai,
            ]
        );

        $proposal->reviewerAssignments()
            ->where('reviewer_id', Auth::id())
            ->update(['reviewed_at' => now()]);

        return back()->with('success', 'Review berhasil disimpan.');
    }

    public function submitFinalReview(Request $request, ProposalModul $proposal)
    {
        abort_if($proposal->reviewer_id !== Auth::id(), 403);

        $request->validate([
            'komentar_reviewer' => 'required|string',
        ]);

        $proposal->update([
            'komentar_reviewer' => $request->komentar_reviewer,
        ]);

        $proposal->reviewerAssignments()
            ->where('reviewer_id', Auth::id())
            ->update(['reviewed_at' => now()]);

        return back()->with('success', 'Review final berhasil dikirim ke admin.');
    }
}
