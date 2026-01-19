<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\SulitestLoginController;
use App\Http\Controllers\Pemeringkatan\SulitestController;
use App\Http\Controllers\Pemeringkatan\SulitestRiwayatController;
use App\Http\Controllers\Pemeringkatan\SulitestQuestionBankController;
use App\Http\Controllers\Pemeringkatan\SulitestImportController;
use App\Http\Controllers\Pemeringkatan\SulitestExamController;
use App\Http\Controllers\Pemeringkatan\SulitestExportController;
use App\Http\Controllers\Pemeringkatan\Admin\TheImpactCmsController;
use App\Http\Controllers\Pemeringkatan\Admin\AkreditasiController;
use App\Http\Controllers\Pemeringkatan\Admin\InternationalStudentController;
use App\Http\Controllers\Pemeringkatan\IndikatorController;
use App\Http\Controllers\Pemeringkatan\RankingController;
use App\Http\Controllers\Pemeringkatan\Admin\DosenInternasionalController;
use App\Http\Controllers\Pemeringkatan\InternationalFacultyStaffController;
use App\Http\Controllers\Pemeringkatan\Admin\InternationalFacultyStaffActivitiesController;
use App\Http\Controllers\Pemeringkatan\Admin\AdminRespondenController;
use App\Http\Controllers\Pemeringkatan\Admin\AdminRespondenReportController;
use App\Http\Controllers\Pemeringkatan\Admin\AdminRespondenExportController;
use App\Http\Controllers\Pemeringkatan\Admin\AdminRespondenEmailController;
use App\Http\Controllers\Pemeringkatan\Admin\RespondenAnswerController;
use App\Http\Controllers\Pemeringkatan\Admin\RespondenAnswerGraphController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\SejarahContentController;
use App\Http\Controllers\Pemeringkatan\SdgInitiativeController;
use App\Http\Controllers\Pemeringkatan\AdminMataKuliahController;

//public routes
Route::prefix('pemeringkatan')->name('pemeringkatan.')->group(function () {
    
    // Main landing page
    Route::get('/home', [BeritaController::class, 'pemeringkatanLanding'])->name('landing');
    
    // About/Profile pages
    Route::get('/tupoksi', function () {
        return view('pemeringkatan.tupoksi.index');
    })->name('tupoksi');
    
    Route::get('/struktur-organisasi', function () {
        return view('pemeringkatan.struktur-organisasi.index');
    })->name('struktur-organisasi');
    
    Route::get('/sejarah', [SejarahContentController::class, 'showPublic'])->name('sejarah');
    
    // Ranking pages
    Route::prefix('ranking-unj')->name('ranking-unj.')->group(function () {
        Route::get('/', [RankingController::class, 'showAllRankings'])->name('index');
        Route::get('/pemeringkatan-klaster-pendidikan-tinggi', function () {
            return view('pemeringkatan.ranking-universitas.klaster-perguruan-tinggi');
        })->name('pemeringkatan-klaster-pendidikan-tinggi');
        Route::get('/{slug}', [RankingController::class, 'show'])->name('show');
    });
    
    Route::get('/klaster-perguruan-tinggi', function () {
        return view('pemeringkatan.ranking-universitas.klaster-perguruan-tinggi');
    })->name('klaster-perguruan-tinggi');
    
    // THE Impact Rankings
    Route::prefix('the-ir-initiatives')->name('the-ir.')->group(function () {
        Route::get('/', [SdgInitiativeController::class, 'index'])->name('index');
        Route::get('/sdg/{id}', [SdgInitiativeController::class, 'show'])->name('sdg.show');
    });
    
    // Indikator
    Route::get('/indikator', [IndikatorController::class, 'showAllIndikators'])->name('indikator.index');
    
    // Sustainability programs
    Route::prefix('sustainability')->name('sustainability.')->group(function () {
        Route::get('/kegiatan', [\App\Http\Controllers\AdminSustainabilityController::class, 'publicKegiatanIndex'])->name('kegiatan');
        
        Route::get('/mata-kuliah', [AdminMataKuliahController::class, 'matakuliahSustainabilityView'])->name('mata-kuliah');
        
        Route::get('/program', function () {
            return view('pemeringkatan.program-sustainability.index');
        })->name('program');
    });
    
    // International programs
    Route::prefix('program')->name('program.')->group(function () {
        Route::get('/global-engagement', function () {
            return view('pemeringkatan.program.global-engagement');
        })->name('global-engagement');
        
        Route::get('/lecturer-expose', function () {
            return view('pemeringkatan.program.lecturer-expose');
        })->name('lecturer-expose');
        
        Route::get('/international-faculty-staff', [InternationalFacultyStaffController::class, 'publicIndex'])->name('international-faculty-staff');
        
        Route::get('/international-student-mobility', function () {
            return view('pemeringkatan.program.international-student-mobility');
        })->name('international-student-mobility');
    });
    
    // Data responden
    Route::get('/data-responden', function () {
        return view('pemeringkatan.data-responden.index');
    })->name('data-responden.index');
    
    // Sulitest
    Route::get('/sulitest', function () {
        return view('pemeringkatan.sulitest.index');
    })->name('sulitest.index');
});

//admin routes

Route::prefix('admin_pemeringkatan')->name('admin_pemeringkatan.')
    ->middleware(['auth', 'role:admin_pemeringkatan'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin_pemeringkatan.dashboard');
        })->name('dashboard');

        //the
        Route::prefix('the-impact-cms')->name('the-impact-cms.')->group(function () {
            Route::get('/', [TheImpactCmsController::class, 'dashboard'])->name('dashboard');
            Route::post('/initialize', [TheImpactCmsController::class, 'initializeSdgs'])->name('initialize');
            
            Route::get('/{sdg}/editor', [TheImpactCmsController::class, 'editor'])->name('editor');
            Route::get('/{sdg}/create', [TheImpactCmsController::class, 'create'])->name('content.create');
            Route::post('/{sdg}/content', [TheImpactCmsController::class, 'storeContent'])->name('content.store');
            
            Route::get('/content/{content}/edit', [TheImpactCmsController::class, 'edit'])->name('content.edit');
            Route::put('/content/{content}', [TheImpactCmsController::class, 'updateContent'])->name('content.update');
            Route::delete('/content/{content}', [TheImpactCmsController::class, 'deleteContent'])->name('content.delete');
            Route::post('/content/{content}/move', [TheImpactCmsController::class, 'moveContent'])->name('content.move');
        });

        Route::prefix('sulitest-question-banks')->name('sulitest_question_banks.')->group(function () {
            Route::get('/', [SulitestQuestionBankController::class, 'index'])->name('index');
            Route::post('/', [SulitestQuestionBankController::class, 'store'])->name('store');
            Route::get('/{questionBank}', [SulitestQuestionBankController::class, 'show'])->name('show');
            Route::delete('/{questionBank}', [SulitestQuestionBankController::class, 'destroy'])->name('destroy');

            //imprto
            Route::get('/download/template', [SulitestImportController::class, 'downloadTemplate'])->name('download_template');
            Route::post('/{questionBank}/import', [SulitestImportController::class, 'importQuestions'])->name('import');
            Route::post('/{questionBank}/import-excel', [SulitestImportController::class, 'importFromExcel'])->name('import_excel');
            Route::delete('/{questionBank}/clear-all', [SulitestQuestionBankController::class, 'clearAllQuestions'])->name('clear_all');
            
            //crud questions
            Route::post('/{questionBank}/questions', [SulitestQuestionBankController::class, 'storeQuestion'])->name('questions.store');
            Route::get('/questions/{question}/edit', [SulitestQuestionBankController::class, 'editQuestion'])->name('questions.edit');
            Route::put('/questions/{question}', [SulitestQuestionBankController::class, 'updateQuestion'])->name('questions.update');
            Route::delete('/questions/{question}', [SulitestQuestionBankController::class, 'destroyQuestion'])->name('questions.destroy');

            //crud categories
            Route::post('/{questionBank}/categories', [SulitestQuestionBankController::class, 'storeCategory'])->name('categories.store');
            Route::get('/categories/{category}', [SulitestQuestionBankController::class, 'showCategory'])->name('categories.show');
            Route::put('/categories/{category}', [SulitestQuestionBankController::class, 'updateCategory'])->name('categories.update');
            Route::delete('/categories/{category}', [SulitestQuestionBankController::class, 'destroyCategory'])->name('categories.destroy');
        });

        Route::prefix('sulitest-exams')->name('sulitest_exams.')->group(function () {
            Route::get('/', [SulitestExamController::class, 'index'])->name('index');
            Route::get('/create', [SulitestExamController::class, 'create'])->name('create');
            Route::post('/', [SulitestExamController::class, 'store'])->name('store');
            Route::get('/{exam}', [SulitestExamController::class, 'show'])->name('show');
            Route::get('/{exam}/edit', [SulitestExamController::class, 'edit'])->name('edit');
            Route::put('/{exam}', [SulitestExamController::class, 'update'])->name('update');
            Route::delete('/{exam}', [SulitestExamController::class, 'destroy'])->name('destroy');

            Route::post('/{exam}/assign', [SulitestExamController::class, 'assignParticipants'])->name('participants.assign');
            Route::delete('/{exam}/remove/{user}', [SulitestExamController::class, 'removeParticipant'])->name('participants.remove');
        });

        Route::prefix('peserta')->name('peserta.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Pemeringkatan\SulitestPesertaController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Pemeringkatan\SulitestPesertaController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Pemeringkatan\SulitestPesertaController::class, 'store'])->name('store');
            Route::get('/{peserta}', [\App\Http\Controllers\Pemeringkatan\SulitestPesertaController::class, 'show'])->name('show');
            Route::get('/{peserta}/edit', [\App\Http\Controllers\Pemeringkatan\SulitestPesertaController::class, 'edit'])->name('edit');
            Route::put('/{peserta}', [\App\Http\Controllers\Pemeringkatan\SulitestPesertaController::class, 'update'])->name('update');
            Route::delete('/{peserta}', [\App\Http\Controllers\Pemeringkatan\SulitestPesertaController::class, 'destroy'])->name('destroy');
            Route::get('/get-prodi/{fakultasId}', [\App\Http\Controllers\Pemeringkatan\SulitestPesertaController::class, 'getProdiByFakultas'])->name('get_prodi');
        });

        Route::prefix('hasil')->name('hasil.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Pemeringkatan\SulitestHasilController::class, 'index'])->name('index');
            Route::get('/{exam}', [\App\Http\Controllers\Pemeringkatan\SulitestHasilController::class, 'show'])->name('show');
            Route::get('/{exam}/analytics', [\App\Http\Controllers\Pemeringkatan\SulitestHasilController::class, 'analytics'])->name('analytics');
            Route::get('/{exam}/export', [\App\Http\Controllers\Pemeringkatan\SulitestHasilController::class, 'export'])->name('export');
            Route::get('/{exam}/export-analytics', [SulitestExportController::class, 'exportAnalytics'])->name('export_analytics');
            Route::get('/session/{session}/detail', [\App\Http\Controllers\Pemeringkatan\SulitestHasilController::class, 'detail'])->name('detail');
        });

        // Data Akreditasi routes
        Route::resource('/data-akreditasi', AkreditasiController::class);
        Route::get('/data-akreditasi/{id}/detail', [AkreditasiController::class, 'getAkreditasiDetail'])
            ->name('data-akreditasi.detail');

        // Mahasiswa International routes
        Route::resource('/mahasiswa-international', InternationalStudentController::class);
        Route::get('/mahasiswa-international/{id}/detail', [InternationalStudentController::class, 'getStudentDetail'])
            ->name('mahasiswa-international.detail');

        // Indikator Pemeringkatan routes
        Route::post('/indikator/upload', [IndikatorController::class, 'uploadImage'])
            ->name('indikator.upload');
        Route::get('/indikator/{id}/detail', [IndikatorController::class, 'getIndikatorDetail'])
            ->name('indikator.detail');
        Route::resource('/indikator', IndikatorController::class);

        // Ranking Pemeringkatan routes
        Route::post('/ranking/upload', [RankingController::class, 'upload'])
            ->name('ranking.upload');
        Route::get('/ranking/{id}/detail', [RankingController::class, 'getRankingDetail'])
            ->name('ranking.detail');
        Route::resource('/ranking', RankingController::class)->except(['show']);

        // International Lecture routes
        Route::get('/international-lecture/{id}/detail', [DosenInternasionalController::class, 'getDosenDetail'])
            ->name('international-lecture.detail');
        Route::resource('/international-lecture', DosenInternasionalController::class);

        // International Faculty Staff routes
        Route::get('/international-faculty-staff/{id}/detail', [InternationalFacultyStaffController::class, 'getStaffDetail'])
            ->name('international-faculty-staff.detail');
        Route::resource('/international-faculty-staff', InternationalFacultyStaffController::class);

        // International Faculty Activities routes
        Route::post('/international-faculty-activities/upload-image', [InternationalFacultyStaffActivitiesController::class, 'uploadImage'])
            ->name('international-faculty-activities-upload-image');
        Route::resource('/international-faculty-activities', InternationalFacultyStaffActivitiesController::class);

        // Responden routes
        Route::get('/responden/laporan', [AdminRespondenReportController::class, 'laporan'])
            ->name('responden.laporan');

        Route::get('/responden/graph', [RespondenAnswerGraphController::class, 'index'])
            ->name('responden.graph');

        Route::resource('/responden', AdminRespondenController::class)->except(['update']);
        Route::put('/responden/{responden}', [AdminRespondenController::class, 'update'])
            ->name('responden.update');

        Route::post('/responden/update-status/{id}', [AdminRespondenController::class, 'updateStatus'])
            ->name('responden.updateStatus');

        Route::post('/responden/import', [AdminRespondenController::class, 'import'])
            ->name('responden.import');
        Route::get('/responden/filter', [AdminRespondenController::class, 'filter'])
            ->name('responden.filter');

        Route::get('/responden/export/excel', [AdminRespondenExportController::class, 'exportExcel'])
            ->name('responden.export.excel');
        Route::get('/responden/export/csv', [AdminRespondenExportController::class, 'exportCSV'])
            ->name('responden.export.csv');

        // Email Template Management Routes
        Route::get('/email', [AdminRespondenEmailController::class, 'index'])
            ->name('email.index');
        Route::get('/email/{id}/edit', [AdminRespondenEmailController::class, 'edit'])
            ->name('email.edit');
        Route::put('/email/{id}', [AdminRespondenEmailController::class, 'update'])
            ->name('email.update');
        Route::post('/email/{id}/reset', [AdminRespondenEmailController::class, 'reset'])
            ->name('email.reset');
        Route::get('/email/{id}/preview', [AdminRespondenEmailController::class, 'preview'])
            ->name('email.preview');

        Route::resource('/qsresponden', RespondenAnswerController::class)->except(['show']);
        Route::get('/qsresponden-export', [RespondenAnswerController::class, 'export'])
            ->name('qsresponden.export');
        Route::post('/qsresponden-import', [RespondenAnswerController::class, 'import'])
            ->name('qsresponden.import');

        // CMS Module Routes
        // Berita (News)
        Route::resource('/berita', \App\Http\Controllers\BeritaController::class);
        Route::post('/berita/upload', [\App\Http\Controllers\BeritaController::class, 'upload'])
            ->name('berita.upload');
        
        // Alumni Berdampak  
        Route::resource('/alumni-berdampak', \App\Http\Controllers\AdminAlumniBerdampakController::class);
        
        // Kegiatan Sustainability
        Route::resource('/kegiatan-sustainability', \App\Http\Controllers\AdminSustainabilityController::class);
        Route::get('/kegiatan-sustainability/{id}/detail', 
            [\App\Http\Controllers\AdminSustainabilityController::class, 'getSustainabilityDetail'])
            ->name('kegiatan-sustainability.detail');
        
        // Mata Kuliah Sustainability
        Route::resource('/mata-kuliah-sustainability', \App\Http\Controllers\Pemeringkatan\AdminMataKuliahController::class);
        
        // User Management - Fakultas, Prodi, Admin Pemeringkatan only
        Route::resource('/manageuser', \App\Http\Controllers\Pemeringkatan\Admin\ManageUserController::class)
            ->parameters(['manageuser' => 'user']);
        Route::put('/manageuser/{user}/toggle-status', 
            [\App\Http\Controllers\Pemeringkatan\Admin\ManageUserController::class, 'toggleStatus'])
            ->name('manageuser.toggleStatus');
    });

//exam
Route::prefix('sulitest')->name('sulitest.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [SulitestLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [SulitestLoginController::class, 'login']);
    });


    Route::middleware(['auth', 'role:sulitest_user'])->group(function () {
        Route::get('/dashboard', [SulitestController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [SulitestLoginController::class, 'logout'])->name('logout');
        Route::post('/test/{exam}/start', [SulitestController::class, 'startTest'])->name('test.start');
        Route::get('/test-session/{session}/{questionNumber?}', [SulitestController::class, 'showTest'])->name('test.show');
        Route::post('/test-session/{session}/submit', [SulitestController::class, 'submitAnswer'])->name('test.submit');
        Route::post('/test-session/{session}/autosave', [SulitestController::class, 'autosaveAnswer'])->name('test.autosave');
        Route::post('/test-session/{session}/log-activity', [SulitestController::class, 'logActivity'])->name('test.logActivity');
        Route::post('/test-session/{session}/toggle-flag', [SulitestController::class, 'toggleFlag'])->name('test.toggleFlag');

        Route::get('/results/{session}', [SulitestController::class, 'showResults'])->name('results.show');
        
        Route::get('/riwayat', [SulitestRiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{session}', [SulitestRiwayatController::class, 'detail'])->name('riwayat.detail');
        Route::get('/riwayat/{session}/download', [SulitestRiwayatController::class, 'download'])->name('riwayat.download');
        
        Route::get('/pengaturan-akun', [SulitestController::class, 'editAccount'])->name('pengaturan-akun.edit');
        Route::put('/pengaturan-akun', [SulitestController::class, 'updateAccount'])->name('pengaturan-akun.update');
        Route::get('/pengaturan-akun/get-prodi/{fakultasId}', [SulitestController::class, 'getProdiByFakultas'])->name('pengaturan-akun.get-prodi');
    });
});

