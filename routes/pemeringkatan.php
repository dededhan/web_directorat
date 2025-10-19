<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\SulitestLoginController;
use App\Http\Controllers\Pemeringkatan\SulitestController;
use App\Http\Controllers\Pemeringkatan\SulitestQuestionBankController;
use App\Http\Controllers\Pemeringkatan\SulitestImportController;
use App\Http\Controllers\Pemeringkatan\SulitestExamController;
use App\Http\Controllers\Admin\TheImpactCmsController;



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
            Route::get('/session/{session}/detail', [\App\Http\Controllers\Pemeringkatan\SulitestHasilController::class, 'detail'])->name('detail');
        });
    });


Route::get('/sulitest-unj', function () {
    return view('sulitest.page.index');
})->name('sulitest.page.index');

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
        
        Route::get('/riwayat', [SulitestController::class, 'riwayat'])->name('riwayat.index');
        Route::get('/riwayat/{session}', [SulitestController::class, 'riwayatDetail'])->name('riwayat.detail');
        Route::get('/riwayat/{session}/download', [SulitestController::class, 'riwayatDownload'])->name('riwayat.download');
    });
});

