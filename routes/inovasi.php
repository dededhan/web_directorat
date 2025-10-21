<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin_inovasi')->name('admin_inovasi.')
    ->middleware(['auth', 'role:admin_inovasi'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin_inovasi.dashboard');
        })->name('dashboard');

        // Katsinov V2 Routes - New System with Tailwind
        Route::prefix('katsinov-v2')->name('katsinov-v2.')
            ->group(function () {
                Route::get('/', [\App\Http\Controllers\KatsinovV2Controller::class, 'index'])->name('index');
                
                // Settings Threshold
                Route::get('/settings', [\App\Http\Controllers\KatsinovV2Controller::class, 'settings'])->name('settings');
                Route::put('/settings', [\App\Http\Controllers\KatsinovV2Controller::class, 'updateSettings'])->name('settings.update');
                Route::get('/create', [\App\Http\Controllers\KatsinovV2Controller::class, 'create'])->name('create');
                Route::get('/edit/{id}', [\App\Http\Controllers\KatsinovV2Controller::class, 'edit'])->name('edit');
                Route::post('/store', [\App\Http\Controllers\KatsinovV2Controller::class, 'store'])->name('store');
                Route::get('/show/{id}', [\App\Http\Controllers\KatsinovV2Controller::class, 'show'])->name('show');
                
                // Workflow actions
                Route::post('/{id}/assign-reviewer', [\App\Http\Controllers\KatsinovV2Controller::class, 'assignReviewer'])->name('assign-reviewer');
                Route::post('/{id}/submit', [\App\Http\Controllers\KatsinovV2Controller::class, 'submitForReview'])->name('submit');
                Route::post('/{id}/start-review', [\App\Http\Controllers\KatsinovV2Controller::class, 'startReview'])->name('start-review');
                Route::post('/{id}/complete-review', [\App\Http\Controllers\KatsinovV2Controller::class, 'completeReview'])->name('complete-review');
                Route::post('/{id}/change-status', [\App\Http\Controllers\KatsinovV2Controller::class, 'changeStatus'])->name('change-status');
                Route::get('/{id}/review', [\App\Http\Controllers\KatsinovV2Controller::class, 'getReview'])->name('review');
                
                // Form pendukung
                Route::get('/{katsinov_id}/form-inovasi', [\App\Http\Controllers\KatsinovV2Controller::class, 'formInovasiIndex'])->name('form-inovasi');
                Route::post('/{katsinov_id}/form-inovasi', [\App\Http\Controllers\KatsinovV2Controller::class, 'formInovasiStore'])->name('form-inovasi.store');
                Route::get('/{katsinov_id}/form-lampiran', [\App\Http\Controllers\KatsinovV2Controller::class, 'formLampiranIndex'])->name('form-lampiran');
                Route::post('/{katsinov_id}/form-lampiran', [\App\Http\Controllers\KatsinovV2Controller::class, 'formLampiranStore'])->name('form-lampiran.store');
                Route::get('/{katsinov_id}/form-informasi-dasar', [\App\Http\Controllers\KatsinovV2Controller::class, 'formInformasiDasarIndex'])->name('form-informasi-dasar');
                Route::post('/{katsinov_id}/form-informasi-dasar', [\App\Http\Controllers\KatsinovV2Controller::class, 'formInformasiDasarStore'])->name('form-informasi-dasar.store');
                Route::get('/{katsinov_id}/form-berita-acara', [\App\Http\Controllers\KatsinovV2Controller::class, 'formBeritaAcaraIndex'])->name('form-berita-acara');
                Route::post('/{katsinov_id}/form-berita-acara', [\App\Http\Controllers\KatsinovV2Controller::class, 'formBeritaAcaraStore'])->name('form-berita-acara.store');
                Route::get('/{katsinov_id}/form-record-hasil', [\App\Http\Controllers\KatsinovV2Controller::class, 'formRecordHasilIndex'])->name('form-record-hasil');
                Route::post('/{katsinov_id}/form-record-hasil', [\App\Http\Controllers\KatsinovV2Controller::class, 'formRecordHasilStore'])->name('form-record-hasil.store');
                
                // Print
                Route::get('/{katsinov_id}/print', [\App\Http\Controllers\KatsinovV2Controller::class, 'printProposal'])->name('print');
                
                // Certificate
                Route::get('/{katsinov_id}/certificate', [\App\Http\Controllers\KatsinovV2Controller::class, 'generateCertificate'])->name('certificate');
                
                // Download Report Pengukuran
                Route::get('/{katsinov_id}/download-report', [\App\Http\Controllers\KatsinovV2Controller::class, 'downloadReport'])->name('download-report');
                
                // Summary
                Route::get('/{katsinov_id}/summary', [\App\Http\Controllers\KatsinovV2Controller::class, 'showSummary'])->name('summary');
                Route::get('/{katsinov_id}/print-summary', [\App\Http\Controllers\KatsinovV2Controller::class, 'printSummary'])->name('print-summary');
                Route::get('/{katsinov_id}/full-report', [\App\Http\Controllers\KatsinovV2Controller::class, 'fullReport'])->name('full-report');
                
                // Delete - Draft only
                Route::delete('/{id}', [\App\Http\Controllers\KatsinovV2Controller::class, 'destroy'])->name('destroy');
            });
        
    });
