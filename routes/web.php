<?php
use App\Http\Controllers\QuesionerGeneralController;
use App\Http\Controllers\AdminAlumniBerdampakController;
use App\Http\Controllers\RespondenAnswerController;
use App\Http\Controllers\KatsinovController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\GoogleController;

use App\Http\Middleware\HandleRespondenForm;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/login', [LoginController::class, 'showLog
inForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Google Login
Route::get('login/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth-google-callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);


Route::prefix('qsranking')->group(function(){
    Route::get('/qs-general', [QuesionerGeneralController::class, 'create'])->name('qs_general.index');
    Route::post('/qs-general', [QuesionerGeneralController::class, 'store'])->name('qs_general.store');

    // controller hijack :v
    Route::get('/qs-employee', [RespondenAnswerController::class, 'create'])->name('qs-employee.index')->middleware(HandleRespondenForm::class);
    Route::post('/qs-employee', [RespondenAnswerController::class, 'store'])->name('qs-employee.store')->middleware(HandleRespondenForm::class);
    Route::get('/qs-academic', [RespondenAnswerController::class, 'create'])->name('qs-academic.index')->middleware(HandleRespondenForm::class);
    Route::post('/qs-academic', [RespondenAnswerController::class, 'store'])->name('qs-academic.store')->middleware(HandleRespondenForm::class);
});

//Alumni
Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');
Route::get('/galeri/alumni', [AlumniController::class, 'index'])->name('alumni');

Route::get('/tupoksi', function () {
    return view('tupoksi.tupoksi');
})->name('tupoksi.tupoksi');

Route::get('/strukturorganisasi', function () {
    return view('struktur organisasi.strukturorganisasi');
})->name('strukturorganisasi');

// Route::get('/galeri/sustainability', function () {
//     return view('galeri.sustainability');
// })->name('galeri.sustainability'); 

Route::get('/galeri/sustainability', [App\Http\Controllers\AdminSustainabilityController::class, 'showPublic'])->name('galeri.sustainability');

Route::get('/katsinov/forminformasidasar', function () {
    return view('inovasi.katsinov.forminformasidasar');
})->name('katsinov.informasidasar');

Route::get('/register', function () {
    return view('register');
})->name('register');


// Route::get('/auth-google-redirect')

Route::get('/sdgscenter', function () {
    return view('Inovasi.katsinov.sdgscenter.sdgscenter');
})->name('sdgscenter');

Route::get('/katsinov/formberitaacara', function () {
    return view('inovasi.katsinov.formberitaacara');
})->name('katsinov.formberitaacara');

Route::get('/katsinov/formjudul', function () {
    return view('inovasi.katsinov.formjudul');
})->name('katsinov.formjudul');

Route::get('/katsinov/formrecordhasilpengukuran', function () {
    return view('inovasi.katsinov.formrecordhasilpengukuran');
})->name('katsinov.formrecordhasilpengukuran');

Route::get('/katsinov-data', function() {
    return App\Models\Katsinov::with('scores')->get();
});

Route::get('/katsinov/form', [KatsinovController::class, 'create'])
    ->name('katsinov.form')
    ->middleware('checked');

Route::post('/katsinov/store', [KatsinovController::class, 'store'])
    ->name('katsinov.store')
    ->middleware('checked');

    Route::get('/pemeringkatan/LandingPage', function () {
        return view('pemeringkatan.LandingPage');
    })->name('pemeringkatan.landingpage');

Route::get('/inovasi/landingpage', function () {
    return view('inovasi.landingPageHilirisasi');
})->name('inovasi.landingpage');

Route::get('/katsinov/pdf', [KatsinovController::class, 'downloadPDF'])->name('katsinov.pdf');

// collection of admin-like routes
require __DIR__ . '/admin.php';