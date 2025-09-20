<?php
namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\ComdevProposal;      // Model Sesi
use App\Models\ComdevSubmission;   // Model Proposal Dosen
use App\Models\User;
use Illuminate\Http\Request;

class ComdevSubmissionAdminController extends Controller
{
    // Menampilkan daftar proposal yang masuk untuk sesi tertentu
    public function index(ComdevProposal $comdev)
    {
        $submissions = ComdevSubmission::where('comdev_proposal_id', $comdev->id)
                                       ->with('user') // Eager load user (dosen)
                                       ->paginate(10);
        return view('admin_equity.comdev.submissions.index', compact('comdev', 'submissions'));
    }

    // Menampilkan detail satu proposal untuk di-manage (assign reviewer, dll)
    public function show(ComdevProposal $comdev, ComdevSubmission $submission)
    {
        // Pastikan submission ini milik sesi ($comdev) yang benar
        abort_if($submission->comdev_proposal_id !== $comdev->id, 404);

        $reviewers = User::where('role', 'reviewer_equity')->get(); // Ambil semua user reviewer
        
        $assignedReviewers = $submission->reviewers()->pluck('users.id')->toArray(); // Ambil reviewer yang sudah di-assign

        return view('admin_equity.comdev.submissions.show', compact('comdev', 'submission', 'reviewers', 'assignedReviewers'));
    }
    
    // Logic untuk assign reviewer
    public function assignReviewer(Request $request, ComdevProposal $comdev, ComdevSubmission $submission)
    {
        $request->validate(['reviewers' => 'required|array']);

        // Sync akan menghapus yang lama dan memasukkan yang baru. Simpel dan efektif.
        $submission->reviewers()->sync($request->reviewers);

        return back()->with('success', 'Reviewer berhasil diperbarui.');
    }
}