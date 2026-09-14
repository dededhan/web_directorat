<?php

use App\Http\Controllers\Hackaton\Admin\DashboardController as HackatonDashboardController;
use App\Http\Controllers\Hackaton\Admin\RegistrationController as HackatonAdminRegistrationController;
use App\Http\Controllers\Hackaton\ParticipantDashboardController;
use App\Http\Controllers\Hackaton\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::view('subdirektorat-inovasi/hackaton', 'subdirektorat-inovasi.hackaton.index')
	->name('hackaton.info');

Route::prefix('hackaton/register')
	->name('hackaton.register.')
	->group(function () {
		Route::get('/', [RegistrationController::class, 'showForm'])->name('form');
		Route::post('/', [RegistrationController::class, 'register'])->name('submit');
	});

Route::get('hackaton/dashboard', [ParticipantDashboardController::class, 'index'])
	->middleware(['auth', 'role:hackaton_dosen,hackaton_tendik,hackaton_alumni,hackaton_peneliti,hackaton_dudi,hackaton_pppk,hackaton_mahasiswa'])
	->name('hackaton.dashboard');

Route::prefix('admin-hackaton')
	->name('admin_hackaton.')
	->middleware(['auth', 'role:admin_hackaton'])
	->group(function () {
		Route::get('dashboard', [HackatonDashboardController::class, 'index'])->name('dashboard');

		Route::get('registrations', [HackatonAdminRegistrationController::class, 'index'])
			->name('registrations.index');
		Route::patch('registrations/{registration}/approve', [HackatonAdminRegistrationController::class, 'approve'])
			->name('registrations.approve');
		Route::patch('registrations/{registration}/decline', [HackatonAdminRegistrationController::class, 'decline'])
			->name('registrations.decline');
	});
