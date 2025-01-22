<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboardadmin');
    })->name('admin.dashboard');
    
    // News
    Route::get('/news', function () {
        return view('admin.newsadmin');
    })->name('admin.news');
});