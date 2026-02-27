<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeSessionController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeFormBuilderController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeSubmissionController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeReviewerController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeDashboardController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeReportController;

// ADMIN INNOVATION CHALLENGE ROUTES
Route::prefix('admin/inov-challenge')->name('admin.inov_challenge.')->middleware(['auth', 'role:inovchalange'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [InovChallengeDashboardController::class, 'index'])->name('dashboard');

    // Session Management
    Route::resource('sessions', InovChallengeSessionController::class);
    Route::post('sessions/{session}/activate', [InovChallengeSessionController::class, 'activate'])->name('sessions.activate');
    Route::post('sessions/{session}/close', [InovChallengeSessionController::class, 'close'])->name('sessions.close');

    // Form Builder
    Route::prefix('sessions/{session}/forms')->name('forms.')->group(function () {
        Route::get('/', [InovChallengeFormBuilderController::class, 'index'])->name('index');
        Route::get('/create/{phase}', [InovChallengeFormBuilderController::class, 'create'])->name('create');
        Route::post('/', [InovChallengeFormBuilderController::class, 'store'])->name('store');
        Route::get('/{form}/edit', [InovChallengeFormBuilderController::class, 'edit'])->name('edit');
        Route::put('/{form}', [InovChallengeFormBuilderController::class, 'update'])->name('update');
        Route::delete('/{form}', [InovChallengeFormBuilderController::class, 'destroy'])->name('destroy');
        Route::get('/{form}/preview', [InovChallengeFormBuilderController::class, 'preview'])->name('preview');
        Route::get('/{form}/validation-rules', [InovChallengeFormBuilderController::class, 'showValidationRules'])->name('validation_rules'); // Debug only
    });

    // Submission Management
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [InovChallengeSubmissionController::class, 'index'])->name('index');
        Route::get('/{submission}', [InovChallengeSubmissionController::class, 'show'])->name('show');
        Route::post('/{submission}/approve/{phase}', [InovChallengeSubmissionController::class, 'approve'])->name('approve');
        Route::post('/{submission}/reject/{phase}', [InovChallengeSubmissionController::class, 'reject'])->name('reject');
        Route::post('/{submission}/unlock/{phase}', [InovChallengeSubmissionController::class, 'unlockPhase'])->name('unlock_phase');
        Route::get('/{submission}/phase-status', [InovChallengeSubmissionController::class, 'getPhaseStatus'])->name('phase_status');
        Route::get('/export', [InovChallengeSubmissionController::class, 'export'])->name('export');
    });

    // Reviewer Assignment
    Route::prefix('reviewers')->name('reviewers.')->group(function () {
        Route::get('/assign', [InovChallengeReviewerController::class, 'showAssignForm'])->name('assign');
        Route::post('/assign', [InovChallengeReviewerController::class, 'assign'])->name('assign.store');
        Route::delete('/remove/{review}', [InovChallengeReviewerController::class, 'remove'])->name('remove');
        Route::post('/reassign/{review}', [InovChallengeReviewerController::class, 'reassign'])->name('reassign');
    });

    // Reports & Statistics
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [InovChallengeReportController::class, 'index'])->name('index');
        Route::get('/export', [InovChallengeReportController::class, 'export'])->name('export');
    });
});

// DOSEN ROUTES (to be expanded in Sprint 3)
Route::prefix('dosen/inov-challenge')->name('dosen.inov_challenge.')->middleware(['auth', 'role:dosen'])->group(function () {
    // Placeholder for Sprint 3
});

// ALUMNI ROUTES (to be expanded in Sprint 4)
Route::prefix('alumni/inov-challenge')->name('alumni.inov_challenge.')->middleware(['auth', 'role:alumni'])->group(function () {
    // Placeholder for Sprint 4
});

// REVIEWER ROUTES (to be expanded in Sprint 5)
Route::prefix('reviewer/inov-challenge')->name('reviewer.inov_challenge.')->middleware(['auth', 'role:reviewer_inovchalange'])->group(function () {
    // Placeholder for Sprint 5
});
