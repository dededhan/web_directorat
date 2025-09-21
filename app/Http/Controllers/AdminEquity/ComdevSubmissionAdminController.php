<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\ComdevProposal;      // Model Sesi
use App\Models\ComdevSubmission;   // Model Proposal Dosen
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ComdevModule;
use Illuminate\Validation\ValidationException;
use App\Enums\ComdevStatusEnum;
use Illuminate\Validation\Rule;

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
        $submission->load(
            'files',
            'reviewers',
            'sesi.modules.subChapters', // Untuk menampilkan struktur modul & sub-bab
            'reviews.reviewer',       // Memuat review DAN user yang mereview
            'reviews.subChapter'      // Memuat sub-bab yang direview
        );

        $reviewers = User::where('role', 'reviewer_equity')->get(); // Ambil semua user reviewer

        $assignedReviewers = $submission->reviewers()->pluck('users.id')->toArray(); // Ambil reviewer yang sudah di-assign
        $reviewerIdsWithComments = $submission->reviews()->pluck('reviewer_id')->unique()->toArray();

        return view('admin_equity.comdev.submissions.show', compact('comdev', 'submission', 'reviewers', 'assignedReviewers', 'reviewerIdsWithComments'));
    }

    // Logic untuk assign reviewer
    public function assignReviewer(Request $request, ComdevProposal $comdev, ComdevSubmission $submission)
    {
        $request->validate(['reviewers' => 'nullable|array']);

        // 1. Dapatkan daftar ID reviewer yang sudah memberikan komentar untuk submission ini.
        $reviewerIdsWithComments = $submission->reviews()->pluck('reviewer_id')->unique()->toArray();

        // 2. Dapatkan daftar ID reviewer yang ingin ditugaskan dari form.
        $newlyAssignedIds = $request->input('reviewers', []);

        // 3. Cek apakah ada reviewer yang sudah berkomentar namun tidak ada di daftar yang baru.
        $removedReviewersWithComments = array_diff($reviewerIdsWithComments, $newlyAssignedIds);

        // 4. Jika ada, gagalkan proses dan kirim pesan error.
        if (!empty($removedReviewersWithComments)) {
            // Ambil nama reviewer untuk pesan error yang lebih jelas
            $reviewerNames = User::whereIn('id', $removedReviewersWithComments)->pluck('name')->join(', ');

            throw ValidationException::withMessages([
                'reviewers' => "Gagal menyimpan. Reviewer berikut tidak dapat dihapus karena sudah memberikan komentar: {$reviewerNames}.",
            ]);
        }

        // 5. Jika aman, baru lakukan sinkronisasi.
        $submission->reviewers()->sync($newlyAssignedIds);

        if (count($newlyAssignedIds) > 0) {
            // Hanya ubah status jika masih dalam tahap awal (diajukan atau menunggu review)
            if (in_array($submission->status, [ComdevStatusEnum::DIAJUKAN, ComdevStatusEnum::MENUNGGU_DIREVIEW])) {
                $submission->update(['status' => ComdevStatusEnum::SEDANG_DIREVIEW]);
            }
        } else {
            // Jika semua reviewer dihapus, kembalikan statusnya
            if ($submission->status === ComdevStatusEnum::SEDANG_DIREVIEW) {
                $submission->update(['status' => ComdevStatusEnum::MENUNGGU_DIREVIEW]);
            }
        }

        return back()->with('success', 'Penugasan reviewer berhasil diperbarui.');
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
                'nominal_disetujui' => $request->nominal_disetujui,
            ]
        );
        if ($request->status == 'lolos') {
            $nextModule = $submission->sesi->modules()
                ->where('urutan', '>', $module->urutan)
                ->orderBy('urutan')->first();

            if ($nextModule) {
                // ... (buka modul selanjutnya)
                $submission->update(['status' => ComdevStatusEnum::PROSES_TAHAP_SELANJUTNYA]);
            } else {
                // Final, semua modul lolos
                $submission->update(['status' => ComdevStatusEnum::SELESAI]);
            }
        } elseif ($request->status == 'tidaklolos') {
            $submission->update(['status' => ComdevStatusEnum::PERBAIKAN_DIPERLUKAN]);
        }

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

        $validStatuses = array_column(ComdevStatusEnum::cases(), 'value');

        $request->validate([
            'status' => ['required', Rule::in($validStatuses)],
        ]);

        $submission->update(['status' => $request->status]);

        return back()->with('success', 'Status proposal berhasil diperbarui secara manual.');
    }
}
