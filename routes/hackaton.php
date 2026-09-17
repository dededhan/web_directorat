<?php

use App\Http\Controllers\Hackaton\Admin\DashboardController as HackatonDashboardController;
use App\Http\Controllers\Hackaton\Admin\RegistrationController as HackatonAdminRegistrationController;
use App\Http\Controllers\Hackaton\Admin\SessionController as HackatonAdminSessionController;
use App\Http\Controllers\Hackaton\Admin\TahapController as HackatonAdminTahapController;
use App\Http\Controllers\Hackaton\Admin\SubmissionAdminController as HackatonAdminSubmissionController;
use App\Http\Controllers\Hackaton\Admin\AccountManagementController as HackatonAdminAccountController;
use App\Http\Controllers\Hackaton\ParticipantDashboardController;
use App\Http\Controllers\Hackaton\PengusulController;
use App\Http\Controllers\Hackaton\MemberController;
use App\Http\Controllers\Hackaton\ReviewerController;
use App\Http\Controllers\Hackaton\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Hackathon Routes
|--------------------------------------------------------------------------
*/

// ── Public Info & Registration ──────────────────────────────────────────
Route::view('subdirektorat-inovasi/hackathon', 'subdirektorat-inovasi.hackaton.index')
    ->name('hackaton.info');
Route::redirect('subdirektorat-inovasi/hackaton', '/subdirektorat-inovasi/hackathon', 301);

Route::get('hackathon', function () {
    return redirect()->route('hackaton.info');
});
Route::get('hackaton', function () {
    return redirect()->route('hackaton.info');
});

Route::prefix('hackathon/register')
    ->name('hackaton.register.')
    ->group(function () {
        Route::get('/', [RegistrationController::class, 'showForm'])->name('form');
        Route::post('/', [RegistrationController::class, 'register'])->name('submit');
    });
Route::redirect('hackaton/register', '/hackathon/register', 301);

// ── Admin Hackathon Panel ────────────────────────────────────────────────
Route::prefix('admin-hackathon')
    ->name('admin_hackaton.')
    ->middleware(['auth', 'role:admin_hackaton'])
    ->group(function () {
        // Dashboard
        Route::get('dashboard', [HackatonDashboardController::class, 'index'])->name('dashboard');

        // Pendaftaran Peserta (Registrations)
        Route::get('registrations', [HackatonAdminRegistrationController::class, 'index'])
            ->name('registrations.index');
        Route::patch('registrations/{registration}/approve', [HackatonAdminRegistrationController::class, 'approve'])
            ->name('registrations.approve');
        Route::patch('registrations/{registration}/decline', [HackatonAdminRegistrationController::class, 'decline'])
            ->name('registrations.decline');

        // Sessions CRUD
        Route::resource('sessions', HackatonAdminSessionController::class);
        Route::patch('sessions/{session}/activate', [HackatonAdminSessionController::class, 'activate'])
            ->name('sessions.activate');
        Route::patch('sessions/{session}/close', [HackatonAdminSessionController::class, 'close'])
            ->name('sessions.close');

        // Tahap & Form Builder
        Route::get('tahap/{tahap}/edit', [HackatonAdminTahapController::class, 'edit'])
            ->name('tahap.edit');
        Route::put('tahap/{tahap}', [HackatonAdminTahapController::class, 'update'])
            ->name('tahap.update');

        Route::post('tahap/{tahap}/fields', [HackatonAdminTahapController::class, 'storeField'])
            ->name('tahap.fields.store');
        Route::put('fields/{field}', [HackatonAdminTahapController::class, 'updateField'])
            ->name('tahap.fields.update');
        Route::delete('fields/{field}', [HackatonAdminTahapController::class, 'destroyField'])
            ->name('tahap.fields.destroy');
        Route::patch('tahap/{tahap}/fields/reorder', [HackatonAdminTahapController::class, 'reorderFields'])
            ->name('tahap.fields.reorder');
        Route::patch('fields/{field}/move', [HackatonAdminTahapController::class, 'moveField'])
            ->name('tahap.fields.move');

        Route::post('tahap/{tahap}/sections', [HackatonAdminTahapController::class, 'storeSection'])
            ->name('tahap.sections.store');
        Route::put('sections/{section}', [HackatonAdminTahapController::class, 'updateSection'])
            ->name('tahap.sections.update');
        Route::delete('sections/{section}', [HackatonAdminTahapController::class, 'destroySection'])
            ->name('tahap.sections.destroy');
        Route::patch('tahap/{tahap}/sections/reorder', [HackatonAdminTahapController::class, 'reorderSections'])
            ->name('tahap.sections.reorder');

        // Submissions Management (scoped per session)
        Route::get('sessions/{session}/submissions', [HackatonAdminSubmissionController::class, 'index'])
            ->name('submissions.index');
        Route::get('sessions/{session}/submissions/scores', [HackatonAdminSubmissionController::class, 'scores'])
            ->name('submissions.scores');
        Route::get('sessions/{session}/submissions/scores/export', [HackatonAdminSubmissionController::class, 'exportExcel'])
            ->name('submissions.scores.export');
        Route::get('sessions/{session}/submissions/{submission}', [HackatonAdminSubmissionController::class, 'show'])
            ->name('submissions.show');
        Route::delete('sessions/{session}/submissions/{submission}', [HackatonAdminSubmissionController::class, 'destroy'])
            ->name('submissions.destroy');
        Route::patch('sessions/{session}/submissions/{submission}/status', [HackatonAdminSubmissionController::class, 'updateStatus'])
            ->name('submissions.updateStatus');
        Route::patch('sessions/{session}/submissions/{submission}/assign-reviewer', [HackatonAdminSubmissionController::class, 'assignReviewer'])
            ->name('submissions.assignReviewer');
        Route::patch('submission-tahap/{submissionTahap}/status', [HackatonAdminSubmissionController::class, 'updateTahapStatus'])
            ->name('submissions.updateTahapStatus');

        // Member Management by Admin
        Route::patch('sessions/{session}/submissions/{submission}/members/{member}/approve', [HackatonAdminSubmissionController::class, 'approveMember'])
            ->name('submissions.members.approve');
        Route::patch('sessions/{session}/submissions/{submission}/members/{member}/reject', [HackatonAdminSubmissionController::class, 'rejectMember'])
            ->name('submissions.members.reject');
        Route::post('sessions/{session}/submissions/{submission}/members', [HackatonAdminSubmissionController::class, 'storeMember'])
            ->name('submissions.members.store');
        Route::put('sessions/{session}/submissions/{submission}/members/{member}', [HackatonAdminSubmissionController::class, 'updateMember'])
            ->name('submissions.members.update');
        Route::delete('sessions/{session}/submissions/{submission}/members/{member}', [HackatonAdminSubmissionController::class, 'destroyMember'])
            ->name('submissions.members.destroy');
        Route::get('members/search', [HackatonAdminSubmissionController::class, 'searchUsers'])
            ->name('members.search');

        // Accounts Management
        Route::get('accounts', [HackatonAdminAccountController::class, 'index'])
            ->name('accounts.index');
        Route::get('accounts/create', [HackatonAdminAccountController::class, 'create'])
            ->name('accounts.create');
        Route::post('accounts', [HackatonAdminAccountController::class, 'store'])
            ->name('accounts.store');
        Route::get('accounts/{user}/edit', [HackatonAdminAccountController::class, 'edit'])
            ->name('accounts.edit');
        Route::put('accounts/{user}', [HackatonAdminAccountController::class, 'update'])
            ->name('accounts.update');
        Route::delete('accounts/{user}', [HackatonAdminAccountController::class, 'destroy'])
            ->name('accounts.destroy');
    });

// Fallback redirects for legacy admin URL
Route::redirect('admin-hackaton', '/admin-hackathon', 301);
Route::redirect('admin-hackaton/{any}', '/admin-hackathon/{any}', 301)->where('any', '.*');

// ── Portal Terpadu Semua Role Peserta & Reviewer ────────────────────────
$allParticipantAndReviewerRoles = 'hackaton_dosen,hackaton_tendik,hackaton_alumni,hackaton_peneliti,hackaton_dudi,hackaton_pppk,hackaton_mahasiswa,reviewer_hackaton,reviewer_inovchalenge,dosen,tendik';

Route::prefix('hackathon')
    ->name('hackaton.')
    ->middleware(['auth', "role:{$allParticipantAndReviewerRoles}"])
    ->group(function () {

        // Dashboard Terpadu (Dinamis Menyesuaikan Role)
        Route::get('dashboard', [ParticipantDashboardController::class, 'index'])
            ->name('dashboard');
        Route::put('dashboard/profile', [ParticipantDashboardController::class, 'updateProfile'])
            ->name('profile.update');

        // Kolaborator Undangan Tim (Approve / Reject)
        Route::patch('invitations/{member}/approve', [ParticipantDashboardController::class, 'approveInvitation'])
            ->name('invitations.approve');
        Route::patch('invitations/{member}/reject', [ParticipantDashboardController::class, 'rejectInvitation'])
            ->name('invitations.reject');

        // Read-only views for team members
        Route::get('team-submissions/{submission}', [ParticipantDashboardController::class, 'showSubmission'])
            ->name('team.show');
        Route::get('team-submissions/{submission}/tahap/{tahapId}', [ParticipantDashboardController::class, 'showTahap'])
            ->name('team.tahap');

        // ── Khusus Pengusul (Dosen & Tendik) ────────────────────────────
        Route::middleware(['role:hackaton_dosen,hackaton_tendik,dosen,tendik'])->group(function () {
            // Sessions browsing
            Route::get('sessions', [PengusulController::class, 'sessions'])
                ->name('sessions.index');
            Route::get('sessions/{session}', [PengusulController::class, 'showSession'])
                ->name('sessions.show');

            // Submissions
            Route::get('submissions', [PengusulController::class, 'mySubmissions'])
                ->name('submissions.index');
            Route::post('sessions/{session}/submissions', [PengusulController::class, 'store'])
                ->name('submissions.store');
            Route::get('submissions/{submission}', [PengusulController::class, 'showSubmission'])
                ->name('submissions.show');

            // Identitas Tim (Gate step)
            Route::get('submissions/{submission}/identitas', [PengusulController::class, 'showIdentitas'])
                ->name('submissions.identitas');
            Route::post('submissions/{submission}/identitas', [PengusulController::class, 'saveIdentitas'])
                ->name('submissions.identitas.save');

            // Form Tahap
            Route::get('submissions/{submission}/tahap/{tahapId}', [PengusulController::class, 'showTahap'])
                ->name('submissions.tahap');
            Route::post('submissions/{submission}/tahap/{tahapId}/save', [PengusulController::class, 'saveTahap'])
                ->name('submissions.tahap.save');
            Route::post('submissions/{submission}/tahap/{tahapId}/submit', [PengusulController::class, 'submitTahap'])
                ->name('submissions.tahap.submit');

            // Team Members Management
            Route::post('submissions/{submission}/members', [MemberController::class, 'store'])
                ->name('members.store');
            Route::put('submissions/{submission}/members/{member}', [MemberController::class, 'update'])
                ->name('members.update');
            Route::delete('submissions/{submission}/members/{member}', [MemberController::class, 'destroy'])
                ->name('members.destroy');
            Route::get('members/search', [MemberController::class, 'searchUsers'])
                ->name('members.search');

            // Anggota Tim read-only
            Route::get('my-team-submissions', [PengusulController::class, 'memberSubmissions'])
                ->name('members.team_index');
        });

        // ── Khusus Reviewer ─────────────────────────────────────────────
        Route::middleware(['role:reviewer_hackaton,reviewer_inovchalenge,admin_hackaton'])->prefix('reviewer')->name('reviewer.')->group(function () {
            Route::get('dashboard', [ReviewerController::class, 'dashboard'])
                ->name('dashboard');
            Route::get('assignments', [ReviewerController::class, 'index'])
                ->name('assignments.index');
            Route::get('assignments/{submission}', [ReviewerController::class, 'show'])
                ->name('assignments.show');
            Route::post('assignments/{submission}/review/{tahapId}', [ReviewerController::class, 'storeReview'])
                ->name('assignments.review');
        });
    });

// Fallback redirects for legacy participant/portal URLs
Route::redirect('hackaton/{any}', '/hackathon/{any}', 301)->where('any', '.*');
