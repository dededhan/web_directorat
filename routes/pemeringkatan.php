<?php

use Illuminate\Support\Facades\Route;

//
use App\Http\Controllers\Auth\SulitestLoginController;
use App\Http\Controllers\SulitestController;
use App\Http\Controllers\SulitestBankController;
use App\Http\Controllers\SulitestExamController;



Route::prefix('admin_pemeringkatan')->name('admin_pemeringkatan.')
    ->middleware(['auth', 'role:admin_pemeringkatan'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin_pemeringkatan.dashboard');
        })->name('dashboard');
        
        Route::prefix('question-banks')->name('question_banks.')->group(function () {
            Route::get('/', [SulitestBankController::class, 'index'])->name('index');
            Route::post('/', [SulitestBankController::class, 'store'])->name('store');
            Route::get('/{questionBank}', [SulitestBankController::class, 'show'])->name('show');
            // CRUD ENJENRIN
            Route::post('/{questionBank}/questions', [SulitestBankController::class, 'storeQuestion'])->name('questions.store');
            Route::get('/questions/{question}/edit', [SulitestBankController::class, 'editQuestion'])->name('questions.edit');
            Route::put('/questions/{question}', [SulitestBankController::class, 'updateQuestion'])->name('questions.update');
            Route::delete('/questions/{question}', [SulitestBankController::class, 'destroyQuestion'])->name('questions.destroy');
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



Route::prefix('sulitest')->name('sulitest.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [SulitestLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [SulitestLoginController::class, 'login']);
    });


    Route::middleware(['auth', 'role:sulitest_user'])->group(function () {
        
        Route::get('/dashboard', [SulitestController::class, 'dashboard'])->name('dashboard');

        Route::post('/logout', [SulitestLoginController::class, 'logout'])->name('logout');

        Route::post('/test/{test}/start', [SulitestController::class, 'startTest'])->name('test.start');
        Route::get('/test-session/{session}', [SulitestController::class, 'showTest'])->name('test.show');
        Route::post('/test-session/{session}/submit', [SulitestController::class, 'submitAnswer'])->name('test.submit');
        Route::get('/results/{session}', [SulitestController::class, 'showResults'])->name('results.show');
    });
});

