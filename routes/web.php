<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('home');
});



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboardadmin');
    })->name('admin.dashboard');
    
    // News
    Route::get('/news', function () {
        return view('admin.newsadmin');
    })->name('admin.news');

   
    Route::get('/qsranking', function () {
        return view('admin.qsrankingadmin');
    })->name('admin.qsranking');


});
Route::get('/qsrangking/qs_employerrespondent', function () {
    return view('qsrangking.qs_employerrespondent');
})->name('qs_employerrespondent');

Route::get('/pemeringkatan/landingpage', function () {
    return view('pemeringkatan.landingpagepemeringkatan');
})->name('pemeringkatan.landingpage');

