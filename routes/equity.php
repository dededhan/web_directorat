<?php

use Illuminate\Support\Facades\Route;

//comdev
use App\Http\Controllers\ComdevController;
use App\Http\Controllers\ComdevViewSesiController;
use App\Http\Controllers\Dosen\ComdevSubmisDosenController;
use App\Http\Controllers\Dosen\ComdevPropViewController;
use App\Http\Controllers\AdminEquity\ComdevSubmissionAdminController;
use App\Http\Controllers\AdminEquity\ComdevModuleController;
use App\Http\Controllers\Dosen\ComdevSubmissionFileController;
use App\Models\ComdevSubmission;
use App\Http\Controllers\ReviewerEquity\ComdevReviewerController;
use App\Http\Controllers\Dosen\ComdevLogbookController;
use App\Http\Controllers\AdminEquity\AdminEquityUserController;
use App\Http\Controllers\Dosen\DosenProfileController;
use App\Http\Controllers\AdminEquity\ApcSessionController;
use App\Http\Controllers\AdminEquity\ApcSubmissionAdminController;
use App\Http\Controllers\Dosen\ApcDosenController;
use App\Http\Controllers\Dosen\ApcSubmissionController;
use App\Http\Controllers\AdminEquity\MatchresearchController;
use App\Http\Controllers\Dosen\MatchmakingDosenController; 
use App\Http\Controllers\Dosen\DosenSearchController;
use App\Http\Controllers\Dosen\MatchmakingDosenSubmissionController; 
use App\Http\Controllers\Dosen\MatchmakingDosenReportController;
use App\Http\Controllers\AdminEquity\MatchmakingSubmissionController;
use App\Http\Controllers\AdminEquity\IncentiveReviewerController;


// Admin Equity Routes
Route::prefix('admin_equity')->name('admin_equity.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin_equity.dashboard');
    })->name('dashboard');

    Route::resource('manageuser', AdminEquityUserController::class)
        ->parameters(['manageuser' => 'user']);


    Route::resource('/comdev', \App\Http\Controllers\ComdevController::class);
    Route::prefix('comdev/{comdev}/submissions')->name('comdev.submissions.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminEquity\ComdevSubmissionAdminController::class, 'index'])->name('index');
        Route::get('/{submission}', [\App\Http\Controllers\AdminEquity\ComdevSubmissionAdminController::class, 'show'])->name('show');
        Route::post('/{submission}/assign-reviewer', [\App\Http\Controllers\AdminEquity\ComdevSubmissionAdminController::class, 'assignReviewer'])->name('assignReviewer');
    });
    Route::get('/comdev/{sesi}/modules', [ComdevModuleController::class, 'index'])->name('comdev.modules.index');
    Route::post('/comdev/{sesi}/modules/store', [ComdevModuleController::class, 'storeModule'])->name('comdev.modules.storeModule');
    Route::post('/comdev/{sesi}/modules/store-template', [ComdevModuleController::class, 'storeTemplate'])->name('comdev.modules.storeTemplate');
    Route::put('/submissions/{submission}/modules/{module}/status', [ComdevSubmissionAdminController::class, 'updateModuleStatus'])->name('comdev.submissions.updateModuleStatus');
    Route::put('/subchapters/{subChapter}', [ComdevModuleController::class, 'updateSubChapter'])->name('comdev.subchapters.update');
    Route::put('/comdev/{comdev}/submissions/{submission}/status', [ComdevSubmissionAdminController::class, 'updateStatus'])
        ->name('comdev.submissions.updateStatus');

    Route::prefix('modules/{module}/subchapters')->name('comdev.subchapters.')->group(function () {
        Route::post('/store', [ComdevModuleController::class, 'storeSubChapter'])->name('store');
    });

    Route::delete('/modules/{module}', [ComdevModuleController::class, 'destroyModule'])->name('comdev.modules.destroy');
    Route::delete('/subchapters/{subChapter}', [ComdevModuleController::class, 'destroySubChapter'])->name('comdev.subchapters.destroy');

    //APC
    Route::prefix('apc')->name('apc.')->group(function () {
        Route::get('/', [ApcSessionController::class, 'index'])->name('index');
        Route::get('/create', [ApcSessionController::class, 'create'])->name('create');
        Route::post('/', [ApcSessionController::class, 'store'])->name('store');
        Route::get('/{apc}', [ApcSessionController::class, 'show'])->name('show');
        Route::get('/{apc}/edit', [ApcSessionController::class, 'edit'])->name('edit');
        Route::put('/{apc}', [ApcSessionController::class, 'update'])->name('update');
        Route::delete('/{apc}', [ApcSessionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('apc-submission')->name('apc.submission.')->group(function () {
        Route::get('/{submission}', [ApcSubmissionAdminController::class, 'show'])->name('show');
        Route::post('/{submission}/status', [ApcSubmissionAdminController::class, 'updateStatus'])->name('updateStatus');
    });
    //

    // 3. Insentif reviewer dan editorial board
    Route::resource('incentive-reviewer', IncentiveReviewerController::class)->names('incentivereviewer');

    Route::get('/incentive-editor', function () {
        return view('admin_equity.incentiveeditor.index');
    })->name('incentiveeditor.index');

    // 5. Presenting at international scientific conferences & Match making
    Route::get('/conference', function () {
        return view('admin_equity.conference.index');
    })->name('conference.index');

    // 6. Visiting (inviting) Top Professors
    Route::get('/match-research', function () {
        return view('admin_equity.matchresearch.index');
    })->name('matchresearch.index');


    // matchmaking
    Route::prefix('matchresearch')->name('matchresearch.')->group(function () {
        //session
        Route::get('/', [MatchresearchController::class, 'index'])->name('index');
        Route::get('/create', [MatchresearchController::class, 'create'])->name('create');
        Route::post('/', [MatchresearchController::class, 'store'])->name('store');
        Route::get('/{id}', [MatchresearchController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MatchresearchController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MatchresearchController::class, 'update'])->name('update');
        Route::delete('/{id}', [MatchresearchController::class, 'destroy'])->name('destroy');

        //submission
        Route::get('/submissions/{submission}', [MatchmakingSubmissionController::class, 'show'])->name('submission.show');
        Route::post('/submissions/{submission}/status', [MatchmakingSubmissionController::class, 'updateStatus'])->name('submission.updateStatus');
        Route::get('/submissions/{submission}/report', [MatchmakingSubmissionController::class, 'showReport'])->name('submission.report.show');
        Route::post('/submissions/{submission}/report/status', [MatchmakingSubmissionController::class, 'updateReportStatus'])->name('submission.report.updateStatus');
    });


    Route::resource('incentive-reviewer', IncentiveReviewerController::class)->names('incentivereviewer');
});

Route::prefix('reviewer_equity')->name('reviewer_equity.')->middleware(['auth', 'role:reviewer_equity'])->group(function () {
    Route::get('/dashboard', function () {
        return view('reviewer_equity.dashboard');
    })->name('dashboard');

    Route::get('manageprofile', [App\Http\Controllers\Dosen\DosenProfileController::class, 'edit'])->name('manageprofile.edit');
    Route::put('manageprofile', [App\Http\Controllers\Dosen\DosenProfileController::class, 'update'])->name('manageprofile.update');

    Route::get('/comdev/assignments', [ComdevReviewerController::class, 'index'])->name('comdev.assignments.index');
    Route::get('/comdev/assignments/{submission}', [ComdevReviewerController::class, 'show'])->name('comdev.assignments.show');
    Route::post('/comdev/assignments/{submission}/subchapter/{subChapter}/review', [ComdevReviewerController::class, 'storeReview'])->name('comdev.assignments.storeReview');

    // Route::get('/proposals', [ReviewerController::class, 'index'])->name('proposals.index');
    // Route::get('/proposals/{proposal}', [ReviewerController::class, 'show'])->name('proposals.show');
});


Route::prefix('subdirektorat-inovasi')->name('subdirektorat-inovasi.')
    ->group(function () {
        Route::prefix('dosen')->name('dosen.')
            ->middleware(['checked', 'role:dosen'])
            ->group(function () {


                Route::get('manageprofile', [DosenProfileController::class, 'edit'])->name('manageprofile.edit');
                Route::put('manageprofile', [DosenProfileController::class, 'update'])->name('manageprofile.update');

                // Equity - Proposal Management
                Route::get('/equity/manajement', [ComdevPropViewController::class, 'index'])
                    ->name('equity.manajement.index');

                Route::get('/equity/proposal/{submission}/tahapan', [ComdevPropViewController::class, 'showTahapan'])->name('equity.proposal.tahapan');

                Route::get('/usulkan-proposal', [ComdevViewSesiController::class, 'index'])
                    ->name('equity.usulkan-proposal.index');





                Route::get('/equity/logbook/{submission}', [ComdevLogbookController::class, 'index'])
                    ->name('equity.logbook');

                // Route untuk menyimpan data logbook dari form (method POST)
                Route::post('/equity/logbook/{submission}', [ComdevLogbookController::class, 'store'])
                    ->name('logbook.store');



                // I've replaced the old static route with this new dynamic one.
                Route::get('/equity/proposal/{submission}/detail', function (ComdevSubmission $submission) {
                    // Security check: ensure the user owns this submission
                    if ($submission->user_id !== auth()->id()) {
                        abort(403, 'Akses Ditolak');
                    }

                    // FIX: Changed ->get() to ->paginate() to return a Paginator instance
                    // that the view's layout can use to render pagination links.
                    $submissions = ComdevSubmission::where('user_id', auth()->id())->latest()->paginate(10);

                    return view('subdirektorat-inovasi.dosen.equity.detail-proposal', [
                        'submission' => $submission,  // The specific proposal for the detail view content
                        'submissions' => $submissions, // The paginated collection for the layout
                    ]);
                })->name('equity.proposal.detail');



                Route::get('/equity/proposal/{sesi}/create-identitas', [ComdevSubmisDosenController::class, 'createIdentitas'])
                    ->name('equity.proposal.createIdentitas');

                // TAHAP 1: Menyimpan data identitas tim
                Route::post('/equity/proposal/{sesi}/store-identitas', [ComdevSubmisDosenController::class, 'storeIdentitas'])
                    ->name('equity.proposal.storeIdentitas');

                // TAHAP 2: Menampilkan form detail proposal (melanjutkan draft)
                Route::get('/equity/proposal/{submission}/create-pengajuan', [ComdevSubmisDosenController::class, 'createPengajuan'])
                    ->name('equity.proposal.createPengajuan'); // <-- NAMA INI YANG MEMPERBAIKI ERROR

                // TAHAP 2: Menyimpan/mengajukan detail proposal
                Route::put('/equity/proposal/{submission}/store-pengajuan', [ComdevSubmisDosenController::class, 'storePengajuan'])
                    ->name('equity.proposal.storePengajuan');

                // AKSI: Menghapus proposal yang masih berstatus draft
                Route::delete('/equity/proposal/{submission}/destroy-draft', [ComdevSubmisDosenController::class, 'destroyDraft'])
                    ->name('equity.proposal.destroyDraft');


                // UPLOAD FILE UNGGAH
                Route::post('/equity/proposal/{submission}/subchapter/{subChapter}/files', [ComdevSubmissionFileController::class, 'store'])->name('equity.files.store');
                Route::get('/equity/files/{file}/download', [ComdevSubmissionFileController::class, 'download'])->name('equity.files.download');
                Route::delete('/equity/files/{file}', [ComdevSubmissionFileController::class, 'destroy'])->name('equity.files.destroy');
                Route::get('/equity/templates/{templateName}/download', [ComdevSubmissionFileController::class, 'downloadTemplate'])->name('equity.templates.download');


                //apc
                Route::prefix('apc')->name('apc.')->group(function () {
                    Route::get('/list-sesi', [ApcDosenController::class, 'listSessions'])->name('list-sesi');
                    Route::get('/manajemen', [ApcDosenController::class, 'manageSubmissions'])->name('manajemen');

                    // Create
                    Route::get('/{sessionId}/form', [ApcDosenController::class, 'createSubmissionForm'])->name('form');
                    Route::post('/{sessionId}/store', [ApcSubmissionController::class, 'store'])->name('store');

                    Route::get('/submission/{submission}/edit', [ApcSubmissionController::class, 'edit'])->name('edit');
                    Route::put('/submission/{submission}', [ApcSubmissionController::class, 'update'])->name('update');
                    Route::delete('/submission/{submission}', [ApcSubmissionController::class, 'destroy'])->name('destroy');
                });

                // matchmaking
                Route::prefix('matchresearch')->name('matchresearch.')->group(function () {
                    // Tahap 1
                    Route::get('/list-sesi', [MatchmakingDosenController::class, 'listSessions'])->name('list-sesi');
                    Route::get('/manajemen', [MatchmakingDosenController::class, 'manageSubmissions'])->name('manajemen');
                    Route::get('/{sessionId}/form', [MatchmakingDosenController::class, 'createSubmissionForm'])->name('form');
                    Route::post('/{sessionId}/store', [MatchmakingDosenSubmissionController::class, 'store'])->name('store');

                    // Route untuk Edit dan Update
                    Route::get('/submission/{submission}/edit', [MatchmakingDosenSubmissionController::class, 'edit'])->name('edit');
                    Route::put('/submission/{submission}', [MatchmakingDosenSubmissionController::class, 'update'])->name('update');

                    // Tahap 2
                    Route::prefix('report')->name('report.')->group(function() {
                        Route::get('/{submissionId}/form', [MatchmakingDosenReportController::class, 'show'])->name('form');
                        Route::post('/{submissionId}/store', [MatchmakingDosenReportController::class, 'storeOrUpdate'])->name('store');
                    });


                });
                    // API
                    Route::get('/search-dosen', [DosenSearchController::class, 'search'])->name('search-dosen');
            });
    });
