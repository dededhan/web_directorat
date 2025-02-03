<?php

use App\Http\Controllers\AdminRespondenController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('home');
});



Route::get('/login', [LoginController::class, 'showLog
inForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboardadmin');
    })->name('dashboard');
    
    // News
    Route::get('/news', function () {
        return view('admin.newsadmin');
    })->name('news');

    Route::resource('/responden', AdminRespondenController::class);

    Route::get('/manage-user', function () {
        return view('admin.manageuser');
    })->name('manageuser');

    
    Route::get('/sustainability', function () {
        return view('admin.sustainability');
    })->name('sustainability');

});

Route::get('/qsrangking/qs_general', function () {
    return view('qsrangking.qs_general');
})->name('qs_general');

Route::get('/galeri', function () {
    return view('galeri.galeri');
})->name('galeri.galeri');

Route::get('/tupoksi', function () {
    return view('tupoksi.tupoksi');
})->name('tupoksi.tupoksi');

Route::get('/pemeringkatan/landingpage', function () {
    return view('pemeringkatan.landingpagepemeringkatan');
})->name('pemeringkatan.landingpage');

