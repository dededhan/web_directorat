<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InovChalenge\SessionController;
use App\Http\Controllers\InovChalenge\TahapController;
use App\Http\Controllers\InovChalenge\DosenController;
use App\Http\Controllers\InovChalenge\MemberController;
use App\Http\Controllers\InovChalenge\AlumniController;
use App\Http\Controllers\InovChalenge\SubmissionAdminController;
use App\Http\Controllers\InovChalenge\ReviewerController;
use App\Http\Controllers\InovChalenge\RegistrationController;
use App\Http\Controllers\InovChalenge\AccountManagementController;
use App\Http\Controllers\InovChalenge\RoleDashboardController;

/*
|--------------------------------------------------------------------------
| Innovation Challenge Routes
|--------------------------------------------------------------------------
*/

// ── Public Registration Routes ────────────────────────────────────────────
Route::prefix('inovchalenge/register')
    ->name('inovchalenge.register.')
    ->group(function () {
        Route::get('/', [RegistrationController::class, 'showForm'])
            ->name('form');
        Route::post('/', [RegistrationController::class, 'register'])
            ->name('submit');
    });

// ── Admin Routes ──────────────────────────────────────────────────────────
Route::prefix('admin_inovasi/inovchalenge')->name('admin_inovasi.inovchalenge.')
    ->middleware(['auth', 'role:admin_inovasi'])
    ->group(function () {

        // Sessions CRUD
        Route::resource('sessions', SessionController::class);

        // Session status actions
        Route::patch('sessions/{session}/activate', [SessionController::class, 'activate'])
            ->name('sessions.activate');
        Route::patch('sessions/{session}/close', [SessionController::class, 'close'])
            ->name('sessions.close');

        // Tahap edit + update
        Route::get('tahap/{tahap}/edit', [TahapController::class, 'edit'])
            ->name('tahap.edit');
        Route::put('tahap/{tahap}', [TahapController::class, 'update'])
            ->name('tahap.update');

        // Tahap fields CRUD
        Route::post('tahap/{tahap}/fields', [TahapController::class, 'storeField'])
            ->name('tahap.fields.store');
        Route::put('fields/{field}', [TahapController::class, 'updateField'])
            ->name('tahap.fields.update');
        Route::delete('fields/{field}', [TahapController::class, 'destroyField'])
            ->name('tahap.fields.destroy');
        Route::patch('tahap/{tahap}/fields/reorder', [TahapController::class, 'reorderFields'])
            ->name('tahap.fields.reorder');
        Route::patch('fields/{field}/move', [TahapController::class, 'moveField'])
            ->name('tahap.fields.move');

        // Tahap sections CRUD
        Route::post('tahap/{tahap}/sections', [TahapController::class, 'storeSection'])
            ->name('tahap.sections.store');
        Route::put('sections/{section}', [TahapController::class, 'updateSection'])
            ->name('tahap.sections.update');
        Route::delete('sections/{section}', [TahapController::class, 'destroySection'])
            ->name('tahap.sections.destroy');
        Route::patch('tahap/{tahap}/sections/reorder', [TahapController::class, 'reorderSections'])
            ->name('tahap.sections.reorder');

        // Submissions management (scoped per session)
        Route::get('sessions/{session}/submissions', [SubmissionAdminController::class, 'index'])
            ->name('submissions.index');
        Route::get('sessions/{session}/submissions/{submission}', [SubmissionAdminController::class, 'show'])
            ->name('submissions.show');
        Route::patch('sessions/{session}/submissions/{submission}/status', [SubmissionAdminController::class, 'updateStatus'])
            ->name('submissions.updateStatus');
        Route::patch('sessions/{session}/submissions/{submission}/assign-reviewer', [SubmissionAdminController::class, 'assignReviewer'])
            ->name('submissions.assignReviewer');
        Route::patch('submission-tahap/{submissionTahap}/status', [SubmissionAdminController::class, 'updateTahapStatus'])
            ->name('submissions.updateTahapStatus');

        // Member approval by admin
        Route::patch('sessions/{session}/submissions/{submission}/members/{member}/approve', [SubmissionAdminController::class, 'approveMember'])
            ->name('submissions.members.approve');
        Route::patch('sessions/{session}/submissions/{submission}/members/{member}/reject', [SubmissionAdminController::class, 'rejectMember'])
            ->name('submissions.members.reject');
    });

// ── Dosen Routes ──────────────────────────────────────────────────────────
Route::prefix('subdirektorat-inovasi/dosen/inovchalenge')
    ->name('subdirektorat-inovasi.dosen.inovchalenge.')
    ->middleware(['auth', 'role:dosen'])
    ->group(function () {

        // Sessions browsing
        Route::get('sessions', [DosenController::class, 'sessions'])
            ->name('sessions.index');
        Route::get('sessions/{session}', [DosenController::class, 'showSession'])
            ->name('sessions.show');

        // Submissions
        Route::get('submissions', [DosenController::class, 'mySubmissions'])
            ->name('submissions.index');
        Route::post('sessions/{session}/submissions', [DosenController::class, 'store'])
            ->name('submissions.store');
        Route::get('submissions/{submission}', [DosenController::class, 'showSubmission'])
            ->name('submissions.show');

        // Identitas Tim (gate step)
        Route::get('submissions/{submission}/identitas', [DosenController::class, 'showIdentitas'])
            ->name('submissions.identitas');
        Route::post('submissions/{submission}/identitas', [DosenController::class, 'saveIdentitas'])
            ->name('submissions.identitas.save');

        // Tahap form
        Route::get('submissions/{submission}/tahap/{tahapId}', [DosenController::class, 'showTahap'])
            ->name('submissions.tahap');
        Route::post('submissions/{submission}/tahap/{tahapId}/save', [DosenController::class, 'saveTahap'])
            ->name('submissions.tahap.save');
        Route::post('submissions/{submission}/tahap/{tahapId}/submit', [DosenController::class, 'submitTahap'])
            ->name('submissions.tahap.submit');

        // Team members
        Route::post('submissions/{submission}/members', [MemberController::class, 'store'])
            ->name('members.store');
        Route::put('submissions/{submission}/members/{member}', [MemberController::class, 'update'])
            ->name('members.update');
        Route::delete('submissions/{submission}/members/{member}', [MemberController::class, 'destroy'])
            ->name('members.destroy');
        Route::get('members/search', [MemberController::class, 'searchUsers'])
            ->name('members.search');

        // Member read-only view (non-Ketua dosen sees submission but cannot edit)
        Route::get('team-submissions', [DosenController::class, 'memberSubmissions'])
            ->name('team.index');
        Route::get('team-submissions/{submission}', [DosenController::class, 'showMemberSubmission'])
            ->name('team.show');
        Route::get('team-submissions/{submission}/tahap/{tahapId}', [DosenController::class, 'showMemberTahap'])
            ->name('team.tahap');
    });

// ── Alumni Routes ─────────────────────────────────────────────────────────
Route::prefix('subdirektorat-inovasi/alumni/inovchalenge')
    ->name('subdirektorat-inovasi.alumni.inovchalenge.')
    ->middleware(['auth', 'role:alumni'])
    ->group(function () {

        Route::get('invitations', [AlumniController::class, 'invitations'])
            ->name('invitations.index');
        Route::patch('invitations/{member}/approve', [AlumniController::class, 'approve'])
            ->name('invitations.approve');
        Route::patch('invitations/{member}/reject', [AlumniController::class, 'reject'])
            ->name('invitations.reject');
    });

// ── Reviewer Routes ───────────────────────────────────────────────────────
Route::prefix('reviewer-inovchalenge')
    ->name('reviewer_inovchalenge.')
    ->middleware(['auth', 'role:reviewer_inovchalenge'])
    ->group(function () {

        Route::get('dashboard', [ReviewerController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('assignments', [ReviewerController::class, 'index'])
            ->name('assignments.index');
        Route::get('assignments/{submission}', [ReviewerController::class, 'show'])
            ->name('assignments.show');
        Route::post('assignments/{submission}/review/{tahapId}', [ReviewerController::class, 'storeReview'])
            ->name('assignments.review');
    });

// ── Admin Account Management Routes ──────────────────────────────────────
Route::prefix('admin_inovasi/accounts')
    ->name('admin_inovasi.accounts.')
    ->middleware(['auth', 'role:admin_inovasi'])
    ->group(function () {

        // Account CRUD
        Route::get('/', [AccountManagementController::class, 'index'])
            ->name('index');
        Route::get('create', [AccountManagementController::class, 'create'])
            ->name('create');
        Route::post('/', [AccountManagementController::class, 'store'])
            ->name('store');
        Route::get('{user}/edit', [AccountManagementController::class, 'edit'])
            ->name('edit');
        Route::put('{user}', [AccountManagementController::class, 'update'])
            ->name('update');
        Route::delete('{user}', [AccountManagementController::class, 'destroy'])
            ->name('destroy');

        // Registration approval
        Route::get('registrations', [AccountManagementController::class, 'registrations'])
            ->name('registrations');
        Route::patch('registrations/{registration}/approve', [AccountManagementController::class, 'approve'])
            ->name('registrations.approve');
        Route::patch('registrations/{registration}/decline', [AccountManagementController::class, 'decline'])
            ->name('registrations.decline');
    });

// ── Role-Specific Dashboard Routes (alumni, peneliti, dudi, pppk, mahasiswa) ──
Route::prefix('inovchalenge/dashboard')
    ->name('inovchalenge.role.')
    ->middleware(['auth', 'role:alumni,peneliti,dudi,pppk,mahasiswa'])
    ->group(function () {

        Route::get('/', [RoleDashboardController::class, 'dashboard'])
            ->name('dashboard');
        Route::put('profile', [RoleDashboardController::class, 'updateProfile'])
            ->name('profile.update');
        Route::patch('invitations/{member}/approve', [RoleDashboardController::class, 'approveInvitation'])
            ->name('invitations.approve');
        Route::patch('invitations/{member}/reject', [RoleDashboardController::class, 'rejectInvitation'])
            ->name('invitations.reject');
    });
