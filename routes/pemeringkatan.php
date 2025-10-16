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

            //imprto
            Route::get('/download/template', [SulitestImportController::class, 'downloadTemplate'])->name('download_template');
            Route::post('/{questionBank}/import', [SulitestImportController::class, 'importQuestions'])->name('import');
            Route::post('/{questionBank}/import-excel', [SulitestImportController::class, 'importFromExcel'])->name('import_excel');
            Route::delete('/{questionBank}/clear-all', [SulitestQuestionBankController::class, 'clearAllQuestions'])->name('clear_all');
            
            //crud
            Route::post('/{questionBank}/questions', [SulitestQuestionBankController::class, 'storeQuestion'])->name('questions.store');
            Route::get('/questions/{question}/edit', [SulitestQuestionBankController::class, 'editQuestion'])->name('questions.edit');
            Route::put('/questions/{question}', [SulitestQuestionBankController::class, 'updateQuestion'])->name('questions.update');
            Route::delete('/questions/{question}', [SulitestQuestionBankController::class, 'destroyQuestion'])->name('questions.destroy');
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

        Route::get('/results/{session}', [SulitestController::class, 'showResults'])->name('results.show');
    });
});

