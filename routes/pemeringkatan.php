<?php

use Illuminate\Support\Facades\Route;

//
use App\Http\Controllers\Auth\SulitestLoginController;
use App\Http\Controllers\SulitestController;
use App\Http\Controllers\SulitestBankController;


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
            
            // Routes for Questions CRUD
            Route::post('/{questionBank}/questions', [SulitestBankController::class, 'storeQuestion'])->name('questions.store');
            Route::get('/questions/{question}/edit', [SulitestBankController::class, 'editQuestion'])->name('questions.edit');
            Route::put('/questions/{question}', [SulitestBankController::class, 'updateQuestion'])->name('questions.update');
            Route::delete('/questions/{question}', [SulitestBankController::class, 'destroyQuestion'])->name('questions.destroy');
        });
});



Route::prefix('sulitest')->name('sulitest.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [SulitestLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [SulitestLoginController::class, 'login']);
    });


    Route::middleware(['auth', 'role:sulitest_user'])->group(function () {
        
        Route::get('/dashboard', function () {
            $dummyTests = [
                (object)[
                    'id' => 1,
                    'title' => 'Uji Coba Pengetahuan Umum',
                    'description' => 'Tes ini mengukur pengetahuan umum Anda tentang berbagai topik.',
                    'duration' => 10,
                    'question_count' => 3
                ],
                (object)[
                    'id' => 2,
                    'title' => 'Tes Logika Dasar',
                    'description' => 'Tes ini berisi soal-soal untuk menguji kemampuan logika dasar.',
                    'duration' => 15,
                    'question_count' => 5
                ]
            ];
            return view('sulitest.dashboard', ['tests' => $dummyTests]);
        })->name('dashboard');

        Route::post('/logout', [SulitestLoginController::class, 'logout'])->name('logout');

        Route::post('/test/{test}/start', [SulitestController::class, 'startTest'])->name('test.start');
        Route::get('/test-session/{session}', [SulitestController::class, 'showTest'])->name('test.show');
        Route::post('/test-session/{session}/submit', [SulitestController::class, 'submitAnswer'])->name('test.submit');
        Route::get('/results/{session}', [SulitestController::class, 'showResults'])->name('results.show');
    });
});

