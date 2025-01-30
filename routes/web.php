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

});

Route::get('/qsrangking/qs_employerrespondent', function () {
    return view('qsrangking.qs_employerrespondent');
})->name('qs_employerrespondent');

Route::get('/qsrangking/qs_academic', function () {
    return view('qsrangking.qs_academic');
})->name('qs_academic');

Route::get('/galeri', function () {
    return view('galeri.galeri');
})->name('galeri.galeri');

Route::get('/pemeringkatan/landingpage', function () {
    return view('pemeringkatan.landingpagepemeringkatan');
})->name('pemeringkatan.landingpage');

