<?php

namespace App\Http\Controllers\ReviewerEquity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ComdevReview;
use App\Models\ComdevSubmission;
use App\Models\ComdevModule;
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
    public function storeReview(Request $request, ComdevSubmission $submission, ComdevModule $module)
    {
        $request->validate([
            'komentar' => 'required|string|min:1',
            'penilaian' => 'nullable|array',
        ]);

        // Jika ada form penilaian, validasi sesuai dengan struktur form
        if ($module->form_penilaian && is_array($module->form_penilaian)) {
            foreach ($module->form_penilaian as $index => $kriteria) {
                if ($kriteria['type'] === 'number') {
                    $request->validate([
                        "penilaian.{$index}" => 'required|numeric',
                    ], [
                        "penilaian.{$index}.required" => "Kriteria '{$kriteria['label']}' wajib diisi.",
                        "penilaian.{$index}.numeric" => "Kriteria '{$kriteria['label']}' harus berupa angka.",
                    ]);
                } else {
                    $request->validate([
                        "penilaian.{$index}" => 'required|string',
                    ], [
                        "penilaian.{$index}.required" => "Kriteria '{$kriteria['label']}' wajib diisi.",
                    ]);
                }
            }
        }

        $submission->reviews()->updateOrCreate(
            [
                'comdev_module_id' => $module->id,
                'reviewer_id'      => Auth::id(),
            ],
            [
                'komentar'  => $request->komentar,
                'penilaian' => $request->penilaian ? json_encode($request->penilaian) : null,
            ]
        );
        
        $assignedReviewerIds = $submission->reviewers()->pluck('users.id');

        if ($assignedReviewerIds->isNotEmpty()) {
            $activeModule = $submission->activeModuleStatus->module ?? null;

            if ($activeModule) {
                $expectedReviewsCount = $assignedReviewerIds->count();

                $actualReviewsCount = ComdevReview::where('comdev_submission_id', $submission->id)
                    ->where('comdev_module_id', $activeModule->id)
                    ->whereIn('reviewer_id', $assignedReviewerIds)
                    ->count();

                if ($expectedReviewsCount === $actualReviewsCount) {
                    $submission->update(['status' => ComdevStatusEnum::MENUNGGU_DI_ACC]);
                }
            }
        }
   
    return back()->with('success', 'Komentar dan penilaian Anda berhasil disimpan.');
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