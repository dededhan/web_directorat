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
use App\Http\Controllers\EquityFakultas\EquityFakultasController;


// Admin Equity Routes
Route::prefix('admin_equity')->name('admin_equity.')->middleware(['auth', 'role:admin_equity'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin_equity.dashboard');
    })->name('dashboard');

    // Equity News Management Routes
    Route::resource('news', \App\Http\Controllers\AdminEquity\EquityNewsController::class);

    // Hibah Modul Ajar Routes
    Route::prefix('hibah-modul')->name('hibah_modul.')->group(function () {
        // CRUD Sesi Hibah Modul
        Route::prefix('sesi')->name('sesi.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminEquity\SesiHibahModulController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\AdminEquity\SesiHibahModulController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\AdminEquity\SesiHibahModulController::class, 'store'])->name('store');
            Route::get('/{sesi}', [\App\Http\Controllers\AdminEquity\SesiHibahModulController::class, 'show'])->name('show');
            Route::get('/{sesi}/edit', [\App\Http\Controllers\AdminEquity\SesiHibahModulController::class, 'edit'])->name('edit');
            Route::put('/{sesi}', [\App\Http\Controllers\AdminEquity\SesiHibahModulController::class, 'update'])->name('update');
            Route::delete('/{sesi}', [\App\Http\Controllers\AdminEquity\SesiHibahModulController::class, 'destroy'])->name('destroy');
        });

        // Proposal Management
        Route::prefix('sesi/{sesi}/proposals')->name('proposals.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminEquity\ProposalModulAdminController::class, 'index'])->name('index');
            Route::get('/{proposal}', [\App\Http\Controllers\AdminEquity\ProposalModulAdminController::class, 'show'])->name('show');
            Route::post('/{proposal}/status', [\App\Http\Controllers\AdminEquity\ProposalModulAdminController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{proposal}/assign-reviewer', [\App\Http\Controllers\AdminEquity\ProposalModulAdminController::class, 'assignReviewer'])->name('assignReviewer');
        });

        // Modul Akhir (Template Laporan Akhir)
        Route::prefix('sesi/{sesi}/moduls')->name('moduls.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminEquity\ModulAkhirController::class, 'index'])->name('index');
            Route::post('/store-modul', [\App\Http\Controllers\AdminEquity\ModulAkhirController::class, 'storeModul'])->name('storeModul');
            Route::put('/modul/{modul}', [\App\Http\Controllers\AdminEquity\ModulAkhirController::class, 'updateModul'])->name('updateModul');
            Route::delete('/modul/{modul}', [\App\Http\Controllers\AdminEquity\ModulAkhirController::class, 'destroyModul'])->name('destroyModul');
            
            Route::post('/modul/{modul}/subchapter', [\App\Http\Controllers\AdminEquity\ModulAkhirController::class, 'storeSubChapter'])->name('storeSubChapter');
            Route::put('/subchapter/{subChapter}', [\App\Http\Controllers\AdminEquity\ModulAkhirController::class, 'updateSubChapter'])->name('updateSubChapter');
            Route::delete('/subchapter/{subChapter}', [\App\Http\Controllers\AdminEquity\ModulAkhirController::class, 'destroySubChapter'])->name('destroySubChapter');
        });
    });

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

    // 3. Insentif reviewer dan editorial board (ROUTE LAMA)
    Route::resource('incentive-reviewer', IncentiveReviewerController::class)->names('incentivereviewer');

    // Fee Reviewer
    Route::prefix('fee-reviewer')->name('fee_reviewer.')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminEquity\FeeReviewerSessionController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\AdminEquity\FeeReviewerSessionController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\AdminEquity\FeeReviewerSessionController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\AdminEquity\FeeReviewerSessionController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\AdminEquity\FeeReviewerSessionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\AdminEquity\FeeReviewerSessionController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\AdminEquity\FeeReviewerSessionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('fee-reviewer-report')->name('fee_reviewer.report.')->group(function () {
        Route::get('/{report}', [App\Http\Controllers\AdminEquity\FeeReviewerReportAdminController::class, 'show'])->name('show');
        Route::post('/{report}/status', [App\Http\Controllers\AdminEquity\FeeReviewerReportAdminController::class, 'updateStatus'])->name('updateStatus');
    });

    // Fee Editor
    Route::prefix('fee-editor')->name('fee_editor.')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminEquity\FeeEditorSessionController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\AdminEquity\FeeEditorSessionController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\AdminEquity\FeeEditorSessionController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\AdminEquity\FeeEditorSessionController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\AdminEquity\FeeEditorSessionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\AdminEquity\FeeEditorSessionController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\AdminEquity\FeeEditorSessionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('fee-editor-report')->name('fee_editor.report.')->group(function () {
        Route::get('/{report}', [App\Http\Controllers\AdminEquity\FeeEditorReportAdminController::class, 'show'])->name('show');
        Route::post('/{report}/status', [App\Http\Controllers\AdminEquity\FeeEditorReportAdminController::class, 'updateStatus'])->name('updateStatus');
    });

    // Presenting
    Route::prefix('presenting')->name('presenting.')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminEquity\PresentingSessionController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\AdminEquity\PresentingSessionController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\AdminEquity\PresentingSessionController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\AdminEquity\PresentingSessionController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\AdminEquity\PresentingSessionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\AdminEquity\PresentingSessionController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\AdminEquity\PresentingSessionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('presenting-report')->name('presenting.report.')->group(function () {
        Route::get('/{report}', [App\Http\Controllers\AdminEquity\PresentingReportAdminController::class, 'show'])->name('show');
        Route::post('/{report}/status', [App\Http\Controllers\AdminEquity\PresentingReportAdminController::class, 'updateStatus'])->name('updateStatus');
    });

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

    Route::prefix('visiting-professors')->name('visiting-professors.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminEquity\VisitingProfessorManagementController::class, 'index'])->name('index');
            Route::get('/export', [\App\Http\Controllers\AdminEquity\VisitingProfessorManagementController::class, 'export'])->name('export');
            Route::get('/{submission}', [\App\Http\Controllers\AdminEquity\VisitingProfessorManagementController::class, 'show'])->name('show');
            Route::patch('/{submission}/status', [\App\Http\Controllers\AdminEquity\VisitingProfessorManagementController::class, 'updateStatus'])->name('updateStatus');
        });

        // Lakukan hal yang sama untuk Joint Supervision dan Employer Meeting
    Route::prefix('joint-supervision')->name('joint-supervision.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminEquity\JointSupervisionManagementController::class, 'index'])->name('index');
            Route::get('/export', [\App\Http\Controllers\AdminEquity\JointSupervisionManagementController::class, 'export'])->name('export');
            Route::get('/{submission}', [\App\Http\Controllers\AdminEquity\JointSupervisionManagementController::class, 'show'])->name('show');
            Route::patch('/{submission}/status', [\App\Http\Controllers\AdminEquity\JointSupervisionManagementController::class, 'updateStatus'])->name('updateStatus');
        });
        
    Route::prefix('employer-meetings')->name('employer-meetings.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminEquity\EmployerMeetingManagementController::class, 'index'])->name('index');
            Route::get('/export', [\App\Http\Controllers\AdminEquity\EmployerMeetingManagementController::class, 'export'])->name('export');
            Route::get('/{submission}', [\App\Http\Controllers\AdminEquity\EmployerMeetingManagementController::class, 'show'])->name('show');
            Route::patch('/{submission}/status', [\App\Http\Controllers\AdminEquity\EmployerMeetingManagementController::class, 'updateStatus'])->name('updateStatus');
        });
});


Route::prefix('equity_fakultas')
    ->name('equity_fakultas.')
   ->middleware(['checked', 'role:equity_fakultas'])
    ->group(function () 
    {

        Route::get('/dashboard', [EquityFakultasController::class, 'index'])->name('dashboard');

        // Visiting Professors Routes
        Route::get('/visiting-professors/{visitingProfessor}/edit-draft', [\App\Http\Controllers\EquityFakultas\VisitingProfessorController::class, 'editDraft'])->name('visiting-professors.edit-draft');
        Route::put('/visiting-professors/{visitingProfessor}/update-draft', [\App\Http\Controllers\EquityFakultas\VisitingProfessorController::class, 'updateDraft'])->name('visiting-professors.update-draft');
        Route::post('/visiting-professors/{visitingProfessor}/confirm', [\App\Http\Controllers\EquityFakultas\VisitingProfessorController::class, 'confirm'])->name('visiting-professors.confirm');
        Route::resource('visiting-professors', \App\Http\Controllers\EquityFakultas\VisitingProfessorController::class);

        // Joint Supervision Routes
        Route::get('/joint-supervision/{jointSupervision}/edit-draft', [\App\Http\Controllers\EquityFakultas\JointSupervisionController::class, 'editDraft'])->name('joint-supervision.edit-draft');
        Route::put('/joint-supervision/{jointSupervision}/update-draft', [\App\Http\Controllers\EquityFakultas\JointSupervisionController::class, 'updateDraft'])->name('joint-supervision.update-draft');
        Route::post('/joint-supervision/{jointSupervision}/confirm', [\App\Http\Controllers\EquityFakultas\JointSupervisionController::class, 'confirm'])->name('joint-supervision.confirm');
        Route::resource('joint-supervision', \App\Http\Controllers\EquityFakultas\JointSupervisionController::class);

        // Employer Meetings Routes
        Route::get('/employer-meetings/{employerMeeting}/edit-draft', [\App\Http\Controllers\EquityFakultas\EmployerMeetingController::class, 'editDraft'])->name('employer-meetings.edit-draft');
        Route::put('/employer-meetings/{employerMeeting}/update-draft', [\App\Http\Controllers\EquityFakultas\EmployerMeetingController::class, 'updateDraft'])->name('employer-meetings.update-draft');
        Route::post('/employer-meetings/{employerMeeting}/confirm', [\App\Http\Controllers\EquityFakultas\EmployerMeetingController::class, 'confirm'])->name('employer-meetings.confirm');
        Route::resource('employer-meetings', \App\Http\Controllers\EquityFakultas\EmployerMeetingController::class);
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
});

// Reviewer Hibah Routes
Route::prefix('reviewer_hibah')->name('reviewer_hibah.')->middleware(['auth', 'role:reviewer_hibah'])->group(function () {
    Route::get('/dashboard', function () {
        return view('reviewer_equity.dashboard');
    })->name('dashboard');

    Route::get('/manageprofile', [App\Http\Controllers\Dosen\DosenProfileController::class, 'edit'])->name('manageprofile.edit');
    Route::put('/manageprofile', [App\Http\Controllers\Dosen\DosenProfileController::class, 'update'])->name('manageprofile.update');

    // Hibah Modul Review
    Route::prefix('hibah-modul')->name('hibah_modul.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ReviewerEquity\ReviewModulHibahController::class, 'index'])->name('index');
        Route::get('/{proposal}', [\App\Http\Controllers\ReviewerEquity\ReviewModulHibahController::class, 'show'])->name('show');
        Route::post('/{proposal}/subchapter/{subChapter}/review', [\App\Http\Controllers\ReviewerEquity\ReviewModulHibahController::class, 'storeReview'])->name('storeReview');
        Route::post('/{proposal}/submit-final', [\App\Http\Controllers\ReviewerEquity\ReviewModulHibahController::class, 'submitFinalReview'])->name('submitFinal');
    });
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

                    // Details Page (NEW)
                    Route::get('/submission/{submission}/details', [ApcDosenController::class, 'showDetails'])->name('details');

                    Route::get('/submission/{submission}/edit', [ApcSubmissionController::class, 'edit'])->name('edit');
                    Route::put('/submission/{submission}', [ApcSubmissionController::class, 'update'])->name('update');
                    Route::delete('/submission/{submission}', [ApcSubmissionController::class, 'destroy'])->name('destroy');

                    Route::post('/submission/{submission}/upload-payment', [ApcSubmissionController::class, 'uploadPaymentProof'])->name('upload-payment');
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
                    Route::prefix('report')->name('report.')->group(function () {
                        Route::get('/{submissionId}/form', [MatchmakingDosenReportController::class, 'show'])->name('form');
                        Route::post('/{submissionId}/store', [MatchmakingDosenReportController::class, 'storeOrUpdate'])->name('store');
                    });


                    Route::get('/logbook/{submission}', [\App\Http\Controllers\Dosen\MatchmakingLogbookController::class, 'show'])->name('logbook');
                });
                // Fee Reviewer
                Route::prefix('fee-reviewer')->name('fee_reviewer.')->group(function () {
                    Route::get('/list-sesi', [\App\Http\Controllers\Dosen\FeeReviewerDosenController::class, 'listSessions'])->name('list-sesi');
                    Route::get('/manajemen', [\App\Http\Controllers\Dosen\FeeReviewerDosenController::class, 'manageReports'])->name('manajemen');

                    Route::get('/{sessionId}/form', [\App\Http\Controllers\Dosen\FeeReviewerDosenController::class, 'createReportForm'])->name('form');
                    Route::post('/{sessionId}/store', [\App\Http\Controllers\Dosen\FeeReviewerReportController::class, 'store'])->name('store');

                    Route::get('/report/{report}/details', [\App\Http\Controllers\Dosen\FeeReviewerDosenController::class, 'showDetails'])->name('details');

                    Route::get('/report/{report}/edit', [\App\Http\Controllers\Dosen\FeeReviewerReportController::class, 'edit'])->name('edit');
                    Route::put('/report/{report}', [\App\Http\Controllers\Dosen\FeeReviewerReportController::class, 'update'])->name('update');
                    Route::delete('/report/{report}', [\App\Http\Controllers\Dosen\FeeReviewerReportController::class, 'destroy'])->name('destroy');
                });

                // Fee Editor
                Route::prefix('fee-editor')->name('fee_editor.')->group(function () {
                    Route::get('/list-sesi', [\App\Http\Controllers\Dosen\FeeEditorDosenController::class, 'listSessions'])->name('list-sesi');
                    Route::get('/manajemen', [\App\Http\Controllers\Dosen\FeeEditorDosenController::class, 'manageReports'])->name('manajemen');

                    Route::get('/{sessionId}/form', [\App\Http\Controllers\Dosen\FeeEditorDosenController::class, 'createReportForm'])->name('form');
                    Route::post('/{sessionId}/store', [\App\Http\Controllers\Dosen\FeeEditorReportController::class, 'store'])->name('store');

                    Route::get('/report/{report}/details', [\App\Http\Controllers\Dosen\FeeEditorDosenController::class, 'showDetails'])->name('details');

                    Route::get('/report/{report}/edit', [\App\Http\Controllers\Dosen\FeeEditorReportController::class, 'edit'])->name('edit');
                    Route::put('/report/{report}', [\App\Http\Controllers\Dosen\FeeEditorReportController::class, 'update'])->name('update');
                    Route::delete('/report/{report}', [\App\Http\Controllers\Dosen\FeeEditorReportController::class, 'destroy'])->name('destroy');
                });

                // Presenting
                Route::prefix('presenting')->name('presenting.')->group(function () {
                    Route::get('/list-sesi', [\App\Http\Controllers\Dosen\PresentingDosenController::class, 'listSessions'])->name('list-sesi');
                    Route::get('/manajemen', [\App\Http\Controllers\Dosen\PresentingDosenController::class, 'manageReports'])->name('manajemen');

                    Route::get('/{sessionId}/form', [\App\Http\Controllers\Dosen\PresentingDosenController::class, 'createReportForm'])->name('form');
                    Route::post('/{sessionId}/store', [\App\Http\Controllers\Dosen\PresentingReportController::class, 'store'])->name('store');

                    Route::get('/report/{report}/details', [\App\Http\Controllers\Dosen\PresentingDosenController::class, 'showDetails'])->name('details');

                    Route::get('/report/{report}/edit', [\App\Http\Controllers\Dosen\PresentingReportController::class, 'edit'])->name('edit');
                    Route::put('/report/{report}', [\App\Http\Controllers\Dosen\PresentingReportController::class, 'update'])->name('update');
                    Route::delete('/report/{report}', [\App\Http\Controllers\Dosen\PresentingReportController::class, 'destroy'])->name('destroy');

                    Route::get('/report/{report}/laporan-akhir', [\App\Http\Controllers\Dosen\PresentingSubmissionController::class, 'createForm'])->name('submission.form');
                    Route::post('/report/{report}/laporan-akhir', [\App\Http\Controllers\Dosen\PresentingSubmissionController::class, 'store'])->name('submission.store');
                    Route::put('/report/{report}/laporan-akhir', [\App\Http\Controllers\Dosen\PresentingSubmissionController::class, 'update'])->name('submission.update');
                });

                // API
                Route::get('/search-dosen', [DosenSearchController::class, 'search'])->name('search-dosen');

                // Hibah Modul Ajar untuk Dosen
                Route::prefix('hibah-modul')->name('hibah_modul.')->group(function () {
                    // List sesi yang dibuka dan manage proposals
                    Route::get('/sesi', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'listSesi'])->name('sesi');
                    Route::get('/manage', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'manageProposals'])->name('manage');
                    
                    // CRUD Proposal
                    Route::get('/sesi/{sesi}/create', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'createForm'])->name('create');
                    Route::post('/sesi/{sesi}/store', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'store'])->name('store');
                    Route::get('/proposal/{proposal}', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'show'])->name('show');
                    Route::get('/proposal/{proposal}/edit', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'edit'])->name('edit');
                    Route::put('/proposal/{proposal}', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'update'])->name('update');
                    Route::delete('/proposal/{proposal}', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'destroy'])->name('destroy');
                    
                    // Confirm/Submit Proposal
                    Route::post('/proposal/{proposal}/confirm', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'confirm'])->name('confirm');
                    Route::post('/proposal/{proposal}/confirm-verifikasi', [\App\Http\Controllers\Dosen\ProposalModulDosenController::class, 'confirmVerifikasi'])->name('confirmVerifikasi');
                    
                    // Laporan Akhir
                    Route::get('/proposal/{proposal}/laporan-akhir', [\App\Http\Controllers\Dosen\ModulAkhirDosenController::class, 'showLaporanAkhir'])->name('laporanAkhir');
                    Route::post('/proposal/{proposal}/subchapter/{subChapter}/upload', [\App\Http\Controllers\Dosen\ModulAkhirDosenController::class, 'uploadFile'])->name('uploadFile');
                    Route::delete('/file/{file}', [\App\Http\Controllers\Dosen\ModulAkhirDosenController::class, 'deleteFile'])->name('deleteFile');
                    Route::get('/file/{file}/download', [\App\Http\Controllers\Dosen\ModulAkhirDosenController::class, 'downloadFile'])->name('downloadFile');
                });
            });
            
    });

// Reviewer Hibah Routes
Route::prefix('reviewer-hibah')->name('reviewer_hibah.')->middleware(['auth', 'role:reviewer_hibah'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\ReviewerHibah\DashboardController::class, 'index'])->name('dashboard');
    
    // Hibah Modul Review
    Route::prefix('hibah-modul')->name('hibah_modul.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ReviewerEquity\ReviewModulHibahController::class, 'index'])->name('index');
        Route::get('/{proposal}', [\App\Http\Controllers\ReviewerEquity\ReviewModulHibahController::class, 'show'])->name('show');
        Route::post('/{proposal}/subchapter/{subChapter}/review', [\App\Http\Controllers\ReviewerEquity\ReviewModulHibahController::class, 'storeReview'])->name('storeReview');
        Route::post('/{proposal}/final', [\App\Http\Controllers\ReviewerEquity\ReviewModulHibahController::class, 'submitFinalReview'])->name('submitFinal');
    });
});