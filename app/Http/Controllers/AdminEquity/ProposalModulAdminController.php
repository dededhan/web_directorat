<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\SesiHibahModul;
use App\Models\ProposalModul;
use App\Models\User;
use Illuminate\Http\Request;

class ProposalModulAdminController extends Controller
{
    public function index(SesiHibahModul $sesi)
    {
        $proposals = ProposalModul::where('sesi_hibah_modul_id', $sesi->id)
            ->with(['user', 'anggota', 'reviewer'])
            ->latest()
            ->paginate(10);
        
        return view('admin_equity.hibah_modul.proposals.index', compact('sesi', 'proposals'));
    }

    public function show(SesiHibahModul $sesi, ProposalModul $proposal)
    {
        abort_if($proposal->sesi_hibah_modul_id !== $sesi->id, 404);
        
        $proposal->load([
            'user',
            'anggota',
            'reviewer',
            'files.subChapter',
            'reviews.reviewer',
            'reviews.subChapter'
        ]);
        
        $reviewers = User::where('role', 'reviewer_hibah')->get();
        
        return view('admin_equity.hibah_modul.proposals.show', compact('sesi', 'proposal', 'reviewers'));
    }

    public function updateStatus(Request $request, SesiHibahModul $sesi, ProposalModul $proposal)
    {
        $request->validate([
            'status' => 'required|in:menunggu_verifikasi,diterima,ditolak,menunggu_direview,sedang_direview,lolos,tidak_lolos',
            'alasan_penolakan' => 'required_if:status,ditolak,tidak_lolos|nullable|string',
            'nominal_hibah' => 'nullable|numeric',
            'komentar_admin' => 'nullable|string',
        ]);

        $data = [
            'status' => $request->status,
            'alasan_penolakan' => $request->alasan_penolakan,
            'nominal_hibah' => $request->nominal_hibah,
            'komentar_admin' => $request->komentar_admin,
        ];

        $proposal->update($data);

        return back()->with('success', 'Status proposal berhasil diperbarui.');
    }

    public function assignReviewer(Request $request, SesiHibahModul $sesi, ProposalModul $proposal)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
        ]);

        $proposal->update([
            'reviewer_id' => $request->reviewer_id,
            'status' => 'sedang_direview',
        ]);

        $proposal->reviewerAssignments()->updateOrCreate(
            ['reviewer_id' => $request->reviewer_id],
            ['assigned_at' => now()]
        );

        return back()->with('success', 'Reviewer berhasil ditugaskan.');
    }
}
