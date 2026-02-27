<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeSessionController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeFormBuilderController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeSubmissionController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeReviewerController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeDashboardController;
use App\Http\Controllers\InovChallenge\Admin\InovChallengeReportController;
use App\Http\Controllers\InovChallenge\Dosen\InovChallengeDosenController;
use App\Http\Controllers\InovChallenge\Dosen\InovChallengeTeamController;

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

// DOSEN ROUTES
Route::prefix('dosen/inov-challenge')->name('dosen.inov_challenge.')->middleware(['auth', 'role:dosen'])->group(function () {

    // Dashboard & Session List
    Route::get('/', [InovChallengeDosenController::class, 'index'])->name('index');
    Route::get('/sessions', [InovChallengeDosenController::class, 'sessions'])->name('sessions.index');
    Route::get('/sessions/{session}', [InovChallengeDosenController::class, 'sessionDetail'])->name('sessions.show');
    Route::post('/sessions/{session}/join', [InovChallengeDosenController::class, 'joinSession'])->name('sessions.join');

    // My Submissions
    Route::get('/submissions', [InovChallengeDosenController::class, 'mySubmissions'])->name('submissions.index');
    Route::get('/submissions/create/{session}', [InovChallengeDosenController::class, 'createSubmission'])->name('submissions.create');
    Route::post('/submissions', [InovChallengeDosenController::class, 'storeSubmission'])->name('submissions.store');
    Route::get('/submissions/{submission}', [InovChallengeDosenController::class, 'showSubmission'])->name('submissions.show');

    // Phase Submissions
    Route::get('/submissions/{submission}/phase-1', [InovChallengeDosenController::class, 'editPhase1'])->name('submissions.phase1.edit');
    Route::post('/submissions/{submission}/phase-1', [InovChallengeDosenController::class, 'storePhase1'])->name('submissions.phase1.store');

    Route::get('/submissions/{submission}/phase-2', [InovChallengeDosenController::class, 'editPhase2'])->name('submissions.phase2.edit');
    Route::post('/submissions/{submission}/phase-2', [InovChallengeDosenController::class, 'storePhase2'])->name('submissions.phase2.store');

    Route::get('/submissions/{submission}/phase-3', [InovChallengeDosenController::class, 'editPhase3'])->name('submissions.phase3.edit');
    Route::post('/submissions/{submission}/phase-3', [InovChallengeDosenController::class, 'storePhase3'])->name('submissions.phase3.store');

    // Team Management
    Route::prefix('submissions/{submission}/team')->name('team.')->group(function () {
        Route::get('/', [InovChallengeTeamController::class, 'index'])->name('index');
        Route::post('/members', [InovChallengeTeamController::class, 'addMember'])->name('add_member');
        Route::delete('/members/{member}', [InovChallengeTeamController::class, 'removeMember'])->name('remove_member');
        Route::post('/invite-external', [InovChallengeTeamController::class, 'inviteExternal'])->name('invite_external');
        Route::post('/members/{member}/resend-invitation', [InovChallengeTeamController::class, 'resendInvitation'])->name('resend_invitation');
    });
});

// ALUMNI ROUTES (to be expanded in Sprint 4)
Route::prefix('alumni/inov-challenge')->name('alumni.inov_challenge.')->middleware(['auth', 'role:alumni'])->group(function () {
    // Placeholder for Sprint 4
});

// REVIEWER ROUTES (to be expanded in Sprint 5)
Route::prefix('reviewer/inov-challenge')->name('reviewer.inov_challenge.')->middleware(['auth', 'role:reviewer_inovchalange'])->group(function () {
    // Placeholder for Sprint 5
});
