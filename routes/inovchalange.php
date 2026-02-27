<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InovChalenge\SessionController;
use App\Http\Controllers\InovChalenge\TahapController;

/*
|--------------------------------------------------------------------------
| Innovation Challenge Routes
|--------------------------------------------------------------------------
*/

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
    });
