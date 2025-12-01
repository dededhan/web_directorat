<?php

use App\Http\Controllers\QuesionerGeneralController;
use App\Http\Controllers\AdminAlumniBerdampakController;
use App\Http\Controllers\Pemeringkatan\Admin\RespondenAnswerController;
use App\Http\Controllers\KatsinovController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\SustainabilityController;
use App\Http\Controllers\FormRecordHasilPengukuranController;
use App\Http\Controllers\ProdukInovasiController;
use App\Http\Controllers\SejarahContentController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\Pemeringkatan\RankingController;
use App\Http\Controllers\ProgramLayananController;
use App\Http\Middleware\HandleRespondenForm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Pemeringkatan\InternationalFacultyStaffController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\Pemeringkatan\AdminMataKuliahController;
use App\Http\Controllers\AdminSustainabilityController;
use App\Http\Controllers\GlobalEngagementController;
use App\Http\Controllers\BeritasdgController;
use App\Http\Controllers\Auth\SulitestLoginController;
use App\Http\Controllers\RisetUnjController;
use App\Http\Controllers\MitraKolaborasiController;
use App\Http\Controllers\LanguageController;

// Language switching route
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', [BeritaController::class, 'homeNews'])->name('home');

Route::get('/kebijakan-privasi', function () {
    return view('privasi.kebijakan-privasi');
})->name('kebijakan-privasi');

Route::get('/program-layanan', [ProgramLayananController::class, 'showFrontend'])->name('program-layanan');
Route::get('/instagram/{id}/preview', [InstagramController::class, 'preview'])->name('instagram.preview');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/reload-captcha', function () {return response()->json(['captcha'=> captcha_img('default')]);
})->name('captcha.reload');


// Google Login
Route::get('login/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth-google-callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);


Route::prefix('qsranking')->group(function () {
    Route::get('/qs-general', [QuesionerGeneralController::class, 'create'])->name('qs_general.index');
    Route::post('/qs-general', [QuesionerGeneralController::class, 'store'])->name('qs_general.store');
    Route::get('/qs-employee', [RespondenAnswerController::class, 'create'])->name('qs-employee.index')->middleware(HandleRespondenForm::class);
    Route::post('/qs-employee', [RespondenAnswerController::class, 'store'])->name('qs-employee.store')->middleware(HandleRespondenForm::class);
    Route::get('/qs-academic', [RespondenAnswerController::class, 'create'])->name('qs-academic.index')->middleware(HandleRespondenForm::class);
    Route::post('/qs-academic', [RespondenAnswerController::class, 'store'])->name('qs-academic.store')->middleware(HandleRespondenForm::class);

    Route::get('/thank-you', function () {
        return view('qsrangking.thank_you');
    })->name('survey.thankyou');

    Route::get('/already-submitted', function () {
        return view('qsrangking.already_submitted');
    })->name('survey.already_submitted');
});



Route::prefix('qsranking')->group(function () {
    Route::get('/qs-general', [QuesionerGeneralController::class, 'create'])->name('qs_general.index');
    Route::post('/qs-general', [QuesionerGeneralController::class, 'store'])->name('qs_general.store');
    Route::get('/qs-employee', [RespondenAnswerController::class, 'create'])->name('qs-employee.index')->middleware(HandleRespondenForm::class);
    Route::post('/qs-employee', [RespondenAnswerController::class, 'store'])->name('qs-employee.store')->middleware(HandleRespondenForm::class);
    Route::get('/qs-academic', [RespondenAnswerController::class, 'create'])->name('qs-academic.index')->middleware(HandleRespondenForm::class);
    Route::post('/qs-academic', [RespondenAnswerController::class, 'store'])->name('qs-academic.store')->middleware(HandleRespondenForm::class);

    Route::get('/thank-you', function () {
        return view('qsrangking.thank_you');
    })->name('survey.thankyou');

    Route::get('/already-submitted', function () {
        return view('qsrangking.already_submitted');
    })->name('survey.already_submitted');
});


//Alumni
Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');
Route::get('/galeri/alumni', [AlumniController::class, 'index'])->name('alumni');

// Document routes
Route::get('/document', [DokumenController::class, 'publicIndex'])->name('documents.public.index');
Route::get('/documents/preview/{id}', [DokumenController::class, 'preview'])->name('documents.preview');
Route::get('/documents/download/{id}', [DokumenController::class, 'download'])->name('documents.download');

// Berita routes
Route::get('/Berita', [BeritaController::class, 'allNews'])->name('Berita.beritahome');
Route::get('/Berita/all', [BeritaController::class, 'allNews'])->name('berita.all');
// FIX: Added route for filtering news by category
Route::get('/Berita/kategori/{kategori}', [BeritaController::class, 'allNews'])->name('berita.kategori');
Route::get('/Berita/detail/{slug}', [BeritaController::class, 'show'])->name('Berita.show');
Route::get('/berita/{id}', function ($id) {
    return redirect()->route('Berita.show', ['id' => $id]);
});

Route::get('/sdg/{id}', function ($id) {
    // Memastikan view untuk SDG yang diminta ada
    if (!view()->exists("subdirektorat-inovasi.sdg.sdg{$id}")) {
        abort(404);
    }
    return view("subdirektorat-inovasi.sdg.sdg{$id}");
})->where('id', '^(1[0-7]|[1-9])$')->name('sdg.show');

Route::get('/sdg/{sdg_id}/berita/{slug}', [BeritasdgController::class, 'show'])
    ->where('sdg_id', '^(1[0-7]|[1-9])$')
    ->name('sdg.berita.show');
// Static Pages
Route::view('/tupoksi', 'tupoksi.tupoksi')->name('tupoksi.tupoksi');
Route::view('/profile', 'Profile1.profile')->name('profile.profile');
Route::view('/strukturorganisasi', 'struktur organisasi.strukturorganisasi')->name('strukturorganisasi');
Route::view('/daptarcalonadjunct', 'daptarcalonadjunct.daptarcalonadjunct')->name('daptar.calonadjunct');
Route::view('/register', 'register')->name('register');

// RUTE BARU UNTUK HALAMAN EQUITY
Route::get('/equity', [App\Http\Controllers\EquityController::class, 'index'])->name('equity');
Route::get('/equity/news/{slug}', [App\Http\Controllers\EquityController::class, 'showNews'])->name('equity.news.show');

// FIX: Added route for sdgscenter and corrected view path.
// Route::view('/sdgscenter', 'subdirektorat-inovasi.sdgscenter')->name('sdgscenter');
Route::get('/sdgscenter', function () {
    return view('subdirektorat-inovasi.katsinov.sdgscenter.sdgscenter');
})->name('sdgscenter');

// Inovasi Routes
Route::prefix('inovasi')->group(function () {
    Route::view('/katsinov/forminformasidasar', 'inovasi.katsinov.forminformasidasar')->name('katsinov.informasidasar');
    Route::view('/katsinov/formberitaacara', 'inovasi.katsinov.formberitaacara')->name('katsinov.formberitaacara');
    Route::view('/katsinov/formjudul', 'inovasi.katsinov.formjudul')->name('katsinov.formjudul');
});

// Route::get('inovasi/risetunj', function () {
//     return view('Inovasi.riset_unj.risetunj');
// })->name('riset.unj');;

// Subdirektorat Inovasi Routes
Route::prefix('subdirektorat-inovasi')->name('subdirektorat-inovasi.')->group(function () {
    Route::get('/risetunj', [RisetUnjController::class, 'publicIndex'])->name('riset.unj');
    Route::get('/risetunj/graph', [RisetUnjController::class, 'showGraph'])->name('riset.graph');
    Route::view('/inkubator/inkubator_bisnis_pendidikan', 'subdirektorat-inovasi.inkubator.inkubator_bisnis_pendidikan')->name('inkubator.inkubator_bisnis_pendidikan');
    Route::view('/inkubator/ekosisteminovasi', 'subdirektorat-inovasi.inkubator.ekosisteminovasi')->name('inkubator.ekosisteminovasi');
    Route::view('/inkubator/inovasiaward', 'subdirektorat-inovasi.inkubator.inovasiaward')->name('inkubator.inovasiaward');
    Route::get('/risetunj/produk_inovasi', [ProdukInovasiController::class, 'publicIndex'])->name('riset_unj.produk_inovasi.produkinovasi');
    Route::get('/risetunj/produk_inovasi/{produk}', [ProdukInovasiController::class, 'show'])->name('riset_unj.produk_inovasi.show');
    Route::get('/landingpage', [BeritaController::class, 'landingPageInovasi'])->name('landingpage');  

});
 Route::get('/riset/download', [RisetUnjController::class, 'showDownloadForm'])
     ->name('riset.public.download');

// 2. Route untuk MEMPROSES password dan memulai download
Route::post('/riset/verify-download', [RisetUnjController::class, 'verifyAndDownload'])
     ->name('riset.public.verify_and_download');

Route::get('/pimpinan', [PimpinanController::class, 'showPublic'])->name('pimpinan.pimpinan');

Route::get('/galeri/sustainability', [AdminSustainabilityController::class, 'showPublic'])->name('galeri.sustainability');
Route::post('/admin/sustainability', [SustainabilityController::class, 'store'])->name('admin.sustainability.store');

// Katsinov Routes
Route::get('/admin/Katsinov/formrecordhasilpengukuran', [FormRecordHasilPengukuranController::class, 'index'])->name('admin.Katsinov.formrecordhasilpengukuran.index');
Route::get('/katsinov-data', fn() => \App\Models\Katsinov::with('scores')->get());
Route::get('/katsinov/form', [KatsinovController::class, 'create'])->name('katsinov.form')->middleware('checked');
Route::post('/katsinov/store', [KatsinovController::class, 'store'])->name('katsinov.store')->middleware('checked');
Route::get('/admin/katsinov/{id}/certificate', [KatsinovController::class, 'downloadCertificate'])->name('admin.katsinov.certificate')->middleware('auth');
Route::get('/katsinov/pdf', [KatsinovController::class, 'downloadPDF'])->name('katsinov.pdf');
Route::get('/katsinov/{katsinov_id}/summary-rating', [KatsinovController::class, 'showRatingSummary'])->name('admin.katsinov.summary-rating');

// ============================================
// just in case
// ============================================


// Main landing page redirects
Route::redirect('/Pemeringkatans', '/pemeringkatan', 301);

// About/Profile redirects
Route::redirect('/tupoksipemeringkatan', '/pemeringkatan/tupoksi', 301);
Route::redirect('/strukturorganisasipemeringkatan', '/pemeringkatan/struktur-organisasi', 301);
Route::redirect('/sejarah-pemeringkatan', '/pemeringkatan/sejarah', 301);

// Ranking redirects
Route::redirect('/ranking_unj', '/pemeringkatan/ranking-unj', 301);
Route::redirect('/Pemeringkatans/Ranking-Universitas/klaster-perguruan-tinggi', '/pemeringkatan/klaster-perguruan-tinggi', 301);
Route::redirect('/indikator', '/pemeringkatan/indikator', 301);

// THE Impact Rankings redirects
Route::redirect('/the-ir-initiatives', '/pemeringkatan/the-ir-initiatives', 301);

// Sustainability program redirects
Route::redirect('/Pemeringkatan/kegiatansustainability', '/pemeringkatan/sustainability/kegiatan', 301);
Route::redirect('/Pemeringkatans/matakuliahsustainability', '/pemeringkatan/sustainability/mata-kuliah', 301);
Route::redirect('/Pemeringkatans/programsustainability/programsustainability', '/pemeringkatan/sustainability/program', 301);

// International program redirects
Route::redirect('/Pemeringkatans/program/global-engagement', '/pemeringkatan/program/global-engagement', 301);
Route::redirect('/Pemeringkatans/program/lecturer-expose', '/pemeringkatan/program/lecturer-expose', 301);
Route::redirect('/Pemeringkatans/program/international-faculty-staff', '/pemeringkatan/program/international-faculty-staff', 301);
Route::redirect('/Pemeringkatan/program/international-student-mobility', '/pemeringkatan/program/international-student-mobility', 301);

// Data responden redirect
Route::redirect('/Pemeringkatan/dataresponden', '/pemeringkatan/data-responden', 301);

// Sulitest redirect
Route::redirect('/Pemeringkatan/sulitest', '/pemeringkatan/sulitest', 301);

// Sejarah Hilirisasi (
Route::get('/sejarah-hilirisasi', [SejarahContentController::class, 'showPublic'])->name('subdirektorat-inovasi.sejarah.sejarah');

Route::get('/subdirektorat-inovasi/riset-unj/produk-inovasi/mitra-kolaborasi', [MitraKolaborasiController::class, 'showPublicByCategory'])
     ->name('subdirektorat-inovasi.riset_unj.produk_inovasi.mitra-kolaborasi');


Route::get('/survey/thank-you', function () {
    return view('qsrangking.thank_you');
})->name('survey.thankyou');

Route::get('/maintenance', function () {
    return view('maintenance.index');
})->name('maintenance.page');




require __DIR__ . '/api.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/pemeringkatan.php';
require __DIR__ . '/inovasi.php';
require __DIR__ . '/equity.php';

