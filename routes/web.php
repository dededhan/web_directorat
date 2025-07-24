<?php

use App\Http\Controllers\QuesionerGeneralController;
use App\Http\Controllers\AdminAlumniBerdampakController;
use App\Http\Controllers\RespondenAnswerController;
use App\Http\Controllers\KatsinovController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\SustainabilityController;
use App\Http\Controllers\FormRecordHasilPengukuranController;
use App\Http\Controllers\ProdukInovasiController;
use App\Http\Controllers\SejarahContentController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ProgramLayananController;
use App\Http\Middleware\HandleRespondenForm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\InternationalFacultyStaffController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\AdminMataKuliahController;
use App\Http\Controllers\AdminSustainabilityController;
use App\Http\Controllers\GlobalEngagementController;
use App\Http\Controllers\BeritasdgController;


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
});

//Alumni
Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');
Route::get('/galeri/alumni', [AlumniController::class, 'index'])->name('alumni');

// Document routes
Route::get('/document', [DokumenController::class, 'publicIndex'])->name('document.document');
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
// FIX: Added route for sdgscenter and corrected view path.
// Route::view('/sdgscenter', 'subdirektorat-inovasi.sdgscenter')->name('sdgscenter');
Route::get('/sdgscenter', function () {
    return view('subdirektorat-inovasi.katsinov.sdgscenter.sdgscenter');
})->name('sdgscenter');

// Inovasi Routes
Route::prefix('inovasi')->group(function () {
    Route::view('/risetunj', 'Inovasi.riset_unj.risetunj')->name('riset.unj');
    Route::view('/katsinov/forminformasidasar', 'inovasi.katsinov.forminformasidasar')->name('katsinov.informasidasar');
    Route::view('/katsinov/formberitaacara', 'inovasi.katsinov.formberitaacara')->name('katsinov.formberitaacara');
    Route::view('/katsinov/formjudul', 'inovasi.katsinov.formjudul')->name('katsinov.formjudul');
});

// Route::get('inovasi/risetunj', function () {
//     return view('Inovasi.riset_unj.risetunj');
// })->name('riset.unj');;

// Subdirektorat Inovasi Routes
Route::prefix('subdirektorat-inovasi')->name('subdirektorat-inovasi.')->group(function () {
    Route::view('/risetunj', 'subdirektorat-inovasi.riset_unj.risetunj')->name('riset.unj');
    Route::view('/inkubator/inkubator_bisnis_pendidikan', 'subdirektorat-inovasi.inkubator.inkubator_bisnis_pendidikan')->name('inkubator.inkubator_bisnis_pendidikan');
    Route::view('/inkubator/ekosisteminovasi', 'subdirektorat-inovasi.inkubator.ekosisteminovasi')->name('inkubator.ekosisteminovasi');
    Route::view('/inkubator/inovasiaward', 'subdirektorat-inovasi.inkubator.inovasiaward')->name('inkubator.inovasiaward');
    Route::get('/risetunj/produk_inovasi', [ProdukInovasiController::class, 'publicIndex'])->name('riset_unj.produk_inovasi.produkinovasi');
    Route::get('/landingpage', [BeritaController::class, 'landingPageInovasi'])->name('landingpage');
});


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

// Sejarah Routes
Route::get('/sejarah-pemeringkatan', [SejarahContentController::class, 'showPublic'])->name('Pemeringkatan.sejarah.sejarah');
Route::get('/sejarah-hilirisasi', [SejarahContentController::class, 'showPublic'])->name('subdirektorat-inovasi.sejarah.sejarah');

// Ranking UNJ Routes
Route::get('/ranking_unj', [RankingController::class, 'showAllRankings'])->name('Pemeringkatan.ranking_unj.rankingunj');
Route::get('/ranking_unj/{slug}', [RankingController::class, 'show'])->name('ranking.show');

// Pemeringkatan Routes
// FIX: Restored original inconsistent route prefixes ('/Pemeringkatans' and '/Pemeringkatan') to prevent "404 Not Found" errors.
// A future refactor to a single, lowercase prefix (e.g., 'pemeringkatan') is recommended for consistency.

Route::get('/tupoksipemeringkatan', function () {
    return view('Pemeringkatan.tupoksipemeringkatan.tupoksi');
})->name('tupoksipemeringkatan');

Route::get('/strukturorganisasipemeringkatan', function () {
    return view('Pemeringkatan.struktur organisasi.strukturorganisasi');
})->name('strukturorganisasipemeringkatan');
Route::get('/Pemeringkatans', [BeritaController::class, 'landingPagePemeringkatan'])->name('pemeringkatan.landingpage');
Route::view('/Pemeringkatans/Ranking-Universitas/klaster-perguruan-tinggi', 'Pemeringkatan.Ranking_Universitas.Pemeringkatan_Klaster_Perguruan_Tinggi')->name('pemeringkatan.klaster');
Route::get('/Pemeringkatans/matakuliahsustainability', [AdminMataKuliahController::class, 'matakuliahSustainabilityView'])->name('Pemeringkatan.matakuliahsustainability.matakuliahsustainability');
Route::view('/Pemeringkatans/program/global-engagement', 'Pemeringkatan.program.global-engagement')->name('Pemeringkatan.program.global-engagement');
Route::view('/Pemeringkatans/programsustainability/programsustainability', 'Pemeringkatan.programsustainability.programsustainability')->name('Pemeringkatan.programsustainability.programsustainability');
Route::view('/Pemeringkatan/kegiatansustainability', 'Pemeringkatan.kegiatansustainability.kegiatansustainability')->name('Pemeringkatan.kegiatansustainability.kegiatansustainability');
Route::view('/Pemeringkatan/dataresponden', 'Pemeringkatan.dataresponden.dataresponden')->name('Pemeringkatan.dataresponden.dataresponden');
Route::view('/Pemeringkatans/program/lecturer-expose', 'Pemeringkatan.program.lecturer-expose')->name('Pemeringkatan.program.lecturer-expose');
Route::get('/Pemeringkatans/program/international-faculty-staff', [InternationalFacultyStaffController::class, 'publicIndex'])->name('Pemeringkatan.program.international-faculty-staff');
Route::view('/Pemeringkatan/program/international-student-mobility', 'Pemeringkatan.program.international-student-mobility')->name('Pemeringkatan.program.international-student-mobility');
Route::get('/indikator', [\App\Http\Controllers\IndikatorController::class, 'showAllIndikators'])->name('Pemeringkatan.indikator.indikator');


Route::get('/survey/thank-you', function () {
    return view('qsrangking.thank_you');
})->name('survey.thankyou');
// Admin routes should be required at the end
require __DIR__ . '/api.php';
require __DIR__ . '/admin.php';