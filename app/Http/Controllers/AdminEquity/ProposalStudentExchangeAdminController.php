<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\SesiStudentExchange;
use App\Models\ProposalStudentExchange;
use App\Models\User;
use Illuminate\Http\Request;

class ProposalStudentExchangeAdminController extends Controller
{
    /**
     * Display a listing of proposals for a specific session.
     */
    public function index(SesiStudentExchange $sesi)
    {
        $proposals = ProposalStudentExchange::where('sesi_student_exchange_id', $sesi->id)
            ->with(['user', 'anggota', 'mitra', 'reviewer'])
            ->latest()
            ->paginate(10);
        
        return view('admin_equity.student-exchange.proposals.index', compact('sesi', 'proposals'));
    }

    /**
     * Display the specified proposal with all related data.
     */
    public function show(SesiStudentExchange $sesi, ProposalStudentExchange $proposal)
    {
        // Ensure the proposal belongs to the session
        abort_if($proposal->sesi_student_exchange_id !== $sesi->id, 404);
        
        $proposal->load([
            'user',
            'anggota',
            'mitra',
            'reviewer',
            'submissionFiles.subChapter',
            'reviews.reviewer',
            'reviews.subChapter'
        ]);
        
        // Get available reviewers for assignment
        $reviewers = User::where('role', 'reviewer_student_exchange')->get();
        
        return view('admin_equity.student-exchange.proposals.show', compact('sesi', 'proposal', 'reviewers'));
    }

    /**
     * Update the status of a proposal.
     */
    public function updateStatus(Request $request, SesiStudentExchange $sesi, ProposalStudentExchange $proposal)
    {
        $request->validate([
            'status' => 'required|in:menunggu_verifikasi,diterima,ditolak,menunggu_direview,sedang_direview,lolos,tidak_lolos',
            'alasan_penolakan' => 'required_if:status,ditolak,tidak_lolos|nullable|string',
            'komentar_admin' => 'nullable|string',
        ]);

        $data = [
            'status' => $request->status,
            'alasan_penolakan' => $request->alasan_penolakan,
            'komentar_admin' => $request->komentar_admin,
        ];

        $proposal->update($data);

        return back()->with('success', 'Status proposal berhasil diperbarui.');
    }

    /**
     * Assign a reviewer to a proposal.
     */
    public function assignReviewer(Request $request, SesiStudentExchange $sesi, ProposalStudentExchange $proposal)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
        ]);

        // Verify the user is a reviewer
        $reviewer = User::findOrFail($request->reviewer_id);
        abort_if($reviewer->role !== 'reviewer_student_exchange', 403, 'User is not a valid reviewer');

        $proposal->update([
            'reviewer_id' => $request->reviewer_id,
            'status' => 'sedang_direview',
        ]);

        // Create or update reviewer assignment
        $proposal->reviewerAssignments()->updateOrCreate(
            ['reviewer_id' => $request->reviewer_id],
            ['assigned_at' => now()]
        );

        return back()->with('success', 'Reviewer berhasil ditugaskan.');
    }

    /**
     * Remove reviewer assignment from a proposal.
     */
    public function removeReviewer(SesiStudentExchange $sesi, ProposalStudentExchange $proposal)
    {
        $proposal->update([
            'reviewer_id' => null,
            'status' => 'menunggu_direview',
        ]);

        // Delete reviewer assignments
        $proposal->reviewerAssignments()->delete();

        return back()->with('success', 'Reviewer berhasil dihapus dari proposal.');
    }

    /**
     * Bulk update status for multiple proposals.
     */
    public function bulkUpdateStatus(Request $request, SesiStudentExchange $sesi)
    {
        $request->validate([
            'proposal_ids' => 'required|array',
            'proposal_ids.*' => 'exists:proposal_student_exchange,id',
            'status' => 'required|in:menunggu_verifikasi,diterima,ditolak,menunggu_direview,sedang_direview,lolos,tidak_lolos',
        ]);

        ProposalStudentExchange::whereIn('id', $request->proposal_ids)
            ->where('sesi_student_exchange_id', $sesi->id)
            ->update(['status' => $request->status]);

        return back()->with('success', 'Status proposal berhasil diperbarui secara massal.');
    }
}
