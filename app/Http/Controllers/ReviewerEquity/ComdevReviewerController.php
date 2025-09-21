<?php

namespace App\Http\Controllers\ReviewerEquity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ComdevReview;
use App\Models\ComdevSubmission; // Model Proposal Dosen
use App\Models\ComdevSubChapter;
use App\Enums\ComdevStatusEnum;

class ComdevReviewerController extends Controller
{
    /**
     * Menampilkan daftar proposal yang ditugaskan kepada reviewer.
     */
    public function index()
    {
        $reviewer = Auth::user();

        // Ambil semua submission yang di-assign ke reviewer ini
        // Eager load relasi untuk menghindari N+1 query problem
        $submissions = $reviewer->submissionsToReview()
                                ->with('sesi', 'user') // 'sesi' = ComdevProposal, 'user' = Dosen
                                ->latest()
                                ->paginate(15);

        return view('reviewer_equity.comdev.index', compact('submissions'));
    }
    public function storeReview(Request $request, ComdevSubmission $submission, ComdevSubChapter $subChapter)
    {
        $request->validate([
            'komentar' => 'required|string|min:1',
        ]);

        // Menggunakan updateOrCreate agar reviewer bisa mengedit komentarnya
        // atau membuat baru jika belum ada.
        $submission->reviews()->updateOrCreate(
            [
                'comdev_sub_chapter_id' => $subChapter->id,
                'reviewer_id'           => Auth::id(),
            ],
            [
                'komentar' => $request->komentar,
            ]
        );
        
        $assignedReviewerIds = $submission->reviewers()->pluck('users.id');

    if ($assignedReviewerIds->isNotEmpty()) {
        // 2. Dapatkan semua sub-bab dari modul yang sedang aktif
        $activeModule = $submission->activeModuleStatus->module ?? null;

        if ($activeModule) {
            $subChapterIds = $activeModule->subChapters()->pluck('id');

            if ($subChapterIds->isNotEmpty()) {
                // 3. Hitung total review yang seharusnya ada (jumlah reviewer * jumlah sub-bab)
                $expectedReviewsCount = $assignedReviewerIds->count() * $subChapterIds->count();

                // 4. Hitung review yang sudah masuk untuk modul ini
                $actualReviewsCount = ComdevReview::where('comdev_submission_id', $submission->id)
                    ->whereIn('comdev_sub_chapter_id', $subChapterIds)
                    ->whereIn('reviewer_id', $assignedReviewerIds)
                    ->count();

                // 5. Jika jumlahnya sama, berarti semua reviewer telah selesai mereview modul ini
                if ($expectedReviewsCount === $actualReviewsCount) {
                    $submission->update(['status' => ComdevStatusEnum::MENUNGGU_DI_ACC]);
                }
            }
        }
    }
   
    return back()->with('success', 'Komentar Anda berhasil disimpan.');
    }

    /**
     * Menampilkan halaman detail untuk mereview satu proposal.
     */
  public function show(ComdevSubmission $submission)
{
    // Pastikan relasi yang dibutuhkan sudah di-load untuk menghindari N+1 query
    $submission->load(
        // Load sesi, lalu modul di dalam sesi, lalu sub-bab di dalam modul
        'sesi.modules.subChapters',
        // Load semua file yang terhubung dengan submission ini
        'files',
        // Load semua review, dan juga user (reviewer) yang menulis review tsb
        'reviews.reviewer'
    );

    return view('reviewer_equity.comdev.show', compact('submission'));
}
}