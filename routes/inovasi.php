<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin_inovasi')->name('admin_inovasi.')
    ->middleware(['auth', 'role:admin_inovasi'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin_inovasi.dashboard');
        })->name('dashboard');

        // Add more routes here as needed
        
    });
