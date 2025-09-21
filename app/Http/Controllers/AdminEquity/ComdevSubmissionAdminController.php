<?php
namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\ComdevProposal;      // Model Sesi
use App\Models\ComdevSubmission;   // Model Proposal Dosen
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ComdevModule;

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
        $submission->load('files');

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

         if ($submission->status === 'diajukan') {
        $submission->update(['status' => 'sedang_direview']);
    }

    return back()->with('success', 'Reviewer berhasil diperbarui.');
    }
   
   
    public function updateModuleStatus(Request $request, ComdevSubmission $submission, ComdevModule $module)
    {
        $request->validate([
            'status' => 'required|in:proses,lolos,tidaklolos',
            'nominal_evaluasi' => 'nullable|numeric',
            'catatan_admin' => 'nullable|string',
        ]);

        // Gunakan updateOrCreate untuk membuat atau memperbarui status
        $submission->moduleStatuses()->updateOrCreate(
            [
                'comdev_module_id' => $module->id,
            ],
            [
                'status' => $request->status,
                'nominal_evaluasi' => $request->nominal_evaluasi,
                'catatan_admin' => $request->catatan_admin,
            ]
        );
        if ($request->status == 'lolos') {
        // Cari modul selanjutnya
        $nextModule = $submission->sesi->modules()
            ->where('urutan', '>', $module->urutan)
            ->orderBy('urutan')
            ->first();

        if ($nextModule) {
            // Buka modul selanjutnya
            $submission->moduleStatuses()->updateOrCreate(
                ['comdev_module_id' => $nextModule->id],
                ['status' => 'menunggu_unggahan']
            );
            $submission->update(['status' => 'proses_tahap_selanjutnya']);
        } else {
            // Tidak ada modul lagi, berarti Selesai
            $submission->update(['status' => 'selesai']);
        }
    } elseif ($request->status == 'tidaklolos') { // atau 'revisi'
        $submission->update(['status' => 'perbaikan_diperlukan']);
    }

    return back()->with('success', 'Status Modul berhasil diperbarui.');

        return back()->with('success', 'Status Modul berhasil diperbarui.');
    }
    public function updateStatus(Request $request, ComdevProposal $comdev, ComdevSubmission $submission)
    {
        // Pastikan submission ini milik sesi ($comdev) yang benar
        abort_if($submission->comdev_proposal_id !== $comdev->id, 404);

        // Daftar status yang valid untuk diubah secara manual
        $validStatuses = [
            'diajukan', 
            'sedang_direview', 
            'menunggu_verifikasi_admin', 
            'perbaikan_diperlukan', 
            'proses_tahap_selanjutnya', 
            'selesai',
            'ditolak'
        ];

        $request->validate([
            'status' => ['required', Rule::in($validStatuses)],
        ]);

        $submission->update(['status' => $request->status]);

        return back()->with('success', 'Status proposal berhasil diperbarui secara manual.');
    }
}