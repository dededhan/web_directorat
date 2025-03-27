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


use App\Http\Controllers\BeritaController;

Route::get('/', [BeritaController::class, 'homeNews'])->name('home');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('Berita.show');
Route::get('/api/announcements', [App\Http\Controllers\PengumumanController::class, 'getActiveAnnouncements'])
    ->name('api.announcements');
Route::get('/program-layanan', [App\Http\Controllers\ProgramLayananController::class, 'showFrontend'])->name('program-layanan');    
// Route::get('/', function () {
//     return view('home');
// })->name('home');


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

// Document routes
Route::get('/document', [App\Http\Controllers\DokumenController::class, 'publicIndex'])
    ->name('document.document');

// API endpoint to get documents for the frontend
Route::get('/api/documents', [App\Http\Controllers\DokumenController::class, 'apiGetDocuments'])
    ->name('api.documents');

// Document preview and download routes
Route::get('/documents/preview/{id}', [App\Http\Controllers\DokumenController::class, 'preview'])
    ->name('documents.preview');
Route::get('/documents/download/{id}', [App\Http\Controllers\DokumenController::class, 'download'])
    ->name('documents.download');


Route::get('/tupoksi', function () {
    return view('tupoksi.tupoksi');
})->name('tupoksi.tupoksi');

Route::get('/profile', function () {
    return view('Profile1.profile');
})->name('profile.profile');

Route::get('/document', function () {
    return view('document.document');
})->name('document.document');

Route::get('/strukturorganisasi', function () {
    return view('struktur organisasi.strukturorganisasi');
})->name('strukturorganisasi');

// Route::get('/galeri/sustainability', function () {
//     return view('galeri.sustainability');
// })->name('galeri.sustainability'); 

Route::post('/admin/sustainability', [SustainabilityController::class, 'store'])
    ->name('admin.sustainability.store');
    
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

Route::get('/katsinov/lampiran', function () {
    return view('inovasi.admin_hilirisasi.lampiran');
})->name('admin.hilirisasi.lampiran');

Route::get('/Berita', function () {
    return view('Berita.beritahome');
})->name('Berita.beritahome');
Route::get('/Berita', [BeritaController::class, 'allNews'])->name('Berita.beritahome');


Route::get('/admin/Katsinov/formrecordhasilpengukuran', [FormRecordHasilPengukuranController::class, 'index'])
    ->name('admin.Katsinov.formrecordhasilpengukuran.index');

Route::get('/katsinov-data', function() {
    return App\Models\Katsinov::with('scores')->get();
});

Route::get('/katsinov/form', [KatsinovController::class, 'create'])
    ->name('katsinov.form')
    ->middleware('checked');

Route::post('/katsinov/store', [KatsinovController::class, 'store'])
    ->name('katsinov.store')
    ->middleware('checked');

Route::get('/pemeringkatan/landingpage', function () {
    return view('Pemeringkatan.LandingPagePemeringkatan');
})->name('pemeringkatan.landingpage');

Route::get('/inovasi/landingpage', function () {
    return view('Inovasi.LandingPageHilirisasi');
})->name('inovasi.landingpage');

Route::get('/katsinov/pdf', [KatsinovController::class, 'downloadPDF'])->name('katsinov.pdf');

// collection of admin-like routes
require __DIR__ . '/admin.php';