<?php

use App\Http\Controllers\QuesionerGeneralController;
use App\Http\Controllers\AdminAlumniBerdampakController;
use App\Http\Controllers\RespondenAnswerController;
use App\Http\Controllers\KatsinovController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\SustainabilityController;
use App\Http\Controllers\FormRecordHasilPengukuranController;
use App\Http\Controllers\ProdukInovasiController;
use App\Http\Controllers\SejarahContentController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\InstagramApiController;




use App\Http\Controllers\ProgramKegiatanController;


use App\Http\Middleware\HandleRespondenForm;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;


use App\Http\Controllers\BeritaController;

Route::get('/', [BeritaController::class, 'homeNews'])->name('home');

Route::get('/api/announcements', [App\Http\Controllers\PengumumanController::class, 'getActiveAnnouncements'])
    ->name('api.announcements');
Route::get('/program-layanan', [App\Http\Controllers\ProgramLayananController::class, 'showFrontend'])->name('program-layanan');
// Instagram

Route::get('/instagram/{id}/preview', [InstagramController::class, 'preview'])
    ->name('instagram.preview');


Route::get('/api/youtube-videos', [App\Http\Controllers\YoutubeController::class, 'getFrontendVideos'])
    ->name('api.youtube-videos');

// Route::get('/api/instagram-api-posts', [App\Http\Controllers\InstagramApiController::class, 'getPosts'])
//     ->name('api.instagram-api-posts');
Route::get('/api/instagram-posts', [InstagramApiController::class, 'getPosts']);
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


Route::prefix('qsranking')->group(function () {
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

// Berita routes
Route::get('/Berita', [BeritaController::class, 'allNews'])->name('Berita.beritahome');
Route::get('/Berita/all', [BeritaController::class, 'allNews'])->name('berita.all');
// Route::get('/Berita/{id}', [BeritaController::class, 'show'])->name('Berita.show');
Route::get('/Berita/detail/{slug}', [BeritaController::class, 'show'])->name('Berita.show');
Route::get('/Berita/kategori/{kategori}', [BeritaController::class, 'kategori'])->name('berita.kategori');
Route::get('/api/Berita/{id}', [BeritaController::class, 'getBeritaDetail']);

//jasinkes
Route::get('/berita/{id}', function ($id) {
    return redirect()->route('Berita.show', ['id' => $id]);
});


Route::get('/tupoksi', function () {
    return view('tupoksi.tupoksi');
})->name('tupoksi.tupoksi');

Route::get('/profile', function () {
    return view('Profile1.profile');
})->name('profile.profile');

Route::get('/document', function () {
    return view('document.document');
})->name('document.document');

Route::get('inovasi/risetunj', function () {
    return view('Inovasi.riset_unj.risetunj');
})->name('riset.unj');;

Route::get('subdirektorat-inovasi/risetunj', function () {
    return view('subdirektorat-inovasi.riset_unj.risetunj');
})->name('riset.unj');



Route::get('subdirektorat-inovasi/risetunj/produk_inovasi', [App\Http\Controllers\ProdukInovasiController::class, 'publicIndex'])
    ->name('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi');

Route::get('/strukturorganisasi', function () {
    return view('struktur organisasi.strukturorganisasi');
})->name('strukturorganisasi');

Route::get('/pimpinan', [App\Http\Controllers\PimpinanController::class, 'showPublic'])
    ->name('pimpinan.pimpinan');

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
    return view('subdirektorat-inovasi.katsinov.sdgscenter.sdgscenter');
})->name('sdgscenter');

Route::get('/api/sdgscenter/programs', [App\Http\Controllers\ProgramKegiatanController::class, 'getSDGCenterPrograms'])
    ->name('api.sdgscenter.programs');
Route::get('/api/sdgscenter/publications', [App\Http\Controllers\PublikasiRisetController::class, 'getSDGCenterPublications'])
    ->name('api.sdgscenter.publications');

Route::get('/berita/sampleberita', function () {
    return view('Berita.sampleberita');
})->name('berita.sample');

Route::get('/katsinov/formberitaacara', function () {
    return view('inovasi.katsinov.formberitaacara');
})->name('katsinov.formberitaacara');

Route::get('/katsinov/formjudul', function () {
    return view('inovasi.katsinov.formjudul');
})->name('katsinov.formjudul');

Route::get('/tupoksipemeringkatan', function () {
    return view('Pemeringkatan.tupoksipemeringkatan.tupoksi');
})->name('tupoksipemeringkatan');

Route::get('/strukturorganisasipemeringkatan', function () {
    return view('Pemeringkatan.struktur organisasi.strukturorganisasi');
})->name('strukturorganisasipemeringkatan');

// Route::get('/katsinov/lampiran', function () {
//     return view('inovasi.admin_hilirisasi.lampiran');
// })->name('admin.hilirisasi.lampiran');



Route::get('/admin/Katsinov/formrecordhasilpengukuran', [FormRecordHasilPengukuranController::class, 'index'])
    ->name('admin.Katsinov.formrecordhasilpengukuran.index');

Route::get('/katsinov-data', function () {
    return App\Models\Katsinov::with('scores')->get();
});

Route::get('/katsinov/form', [KatsinovController::class, 'create'])
    ->name('katsinov.form')
    ->middleware('checked');

Route::post('/katsinov/store', [KatsinovController::class, 'store'])
    ->name('katsinov.store')
    ->middleware('checked');

Route::get('/subdirektorat-inovasi/landingpage', [BeritaController::class, 'landingPageInovasi'])
    ->name('subdirektorat-inovasi.landingpage');

Route::get('/katsinov/pdf', [KatsinovController::class, 'downloadPDF'])->name('katsinov.pdf');


//Berita

Route::get('/Berita', function () {
    return view('Berita.beritahome');
})->name('Berita.beritahome');
Route::get('/Berita', [BeritaController::class, 'allNews'])->name('Berita.beritahome');



// Route::get('/sejarah-pemeringkatan', [SejarahContentController::class, 'showPublic'])
//     ->name('Pemeringkatan.sejarah.sejarah')
//     ->with('category', 'pemeringkatan');

// Route::get('/sejarah-hilirisasi', [SejarahContentController::class, 'showPublic'])
//     ->name('subdirektorat-inovasi.sejarah.sejarah')
//     ->with('category', 'inovasi');

Route::get('/sejarah-pemeringkatan', [SejarahContentController::class, 'showPublic'])
    ->name('Pemeringkatan.sejarah.sejarah');

Route::get('/sejarah-hilirisasi', [SejarahContentController::class, 'showPublic'])
    ->name('subdirektorat-inovasi.sejarah.sejarah');

// Route::get('/ranking_unj', function () {
//     return view('Pemeringkatan.ranking_unj.rankingunj');
// })->name('Pemeringkatan.ranking_unj.rankingunj');
// In web.php

Route::get('/katsinov/{katsinov_id}/record/summary', [KatsinovController::class, 'recordShow'])
    ->name('admin.katsinov.record.show')
    ->middleware(['auth']);
    Route::get('/katsinov/{katsinov_id}/summary-indicator-one', [KatsinovController::class, 'summaryIndicatorOne'])
    ->name('admin.katsinov.summary-indicator-one');
    Route::get('/katsinov/{katsinov_id}/summary-indicator-two', [KatsinovController::class, 'summaryIndicatortwo'])
    ->name('admin.katsinov.summary-indicator-two');

Route::get('/ranking_unj', [App\Http\Controllers\RankingController::class, 'showAllRankings'])
    ->name('Pemeringkatan.ranking_unj.rankingunj');

Route::get('/ranking_unj', [App\Http\Controllers\RankingController::class, 'showAllRankings'])
    ->name('Pemeringkatan.ranking_unj.rankingunj');
Route::get('/ranking_unj/{slug}', [App\Http\Controllers\RankingController::class, 'show'])
    ->name('ranking.show');

Route::get('/ranking_unj/Webometrics World University Ranking', function () {
    return view('Pemeringkatan.ranking_unj.Webometrics World University Ranking.Webometrics World University Ranking');
})->name('Pemeringkatan.ranking_unj.Webometrics World University Ranking.Webometrics World University Ranking');

Route::get('/ranking_unj/Times Higher Education Impact Rankings', function () {
    return view('Pemeringkatan.ranking_unj.Times Higher Education Impact Rankings.Times Higher Education Impact Rankings');
})->name('Pemeringkatan.ranking_unj.Times Higher Education Impact Rankings.Times Higher Education Impact Rankings');

Route::get('/ranking_unj/QS World University Ranking', function () {
    return view('Pemeringkatan.ranking_unj.QS World University Ranking.QS World University Ranking');
})->name('Pemeringkatan.ranking_unj.QS World University Ranking.QS World University Ranking');

Route::get('/ranking_unj/QS Asian University Rankings', function () {
    return view('Pemeringkatan.ranking_unj.QS Asian University Rankings.QS Asian University Rankings');
})->name('Pemeringkatan.ranking_unj.QS Asian University Rankings.QS Asian University Rankings');

Route::get('/ranking_unj/UI Greenmetric World University Ranking', function () {
    return view('Pemeringkatan.ranking_unj.UI Greenmetric World University Ranking.UI Greenmetric World University Ranking');
})->name('Pemeringkatan.ranking_unj.UI Greenmetric World University Ranking.UI Greenmetric World University Ranking');

Route::get('/ranking_unj/Pemeringkatan Klaster Pendidikan Tinggi', function () {
    return view('Pemeringkatan.ranking_unj.Pemeringkatan Klaster Pendidikan Tinggi.Pemeringkatan Klaster Pendidikan Tinggi');
})->name('Pemeringkatan.ranking_unj.Pemeringkatan Klaster Pendidikan Tinggi.Pemeringkatan Klaster Pendidikan Tinggi');

Route::get('/ranking_unj/scimago', function () {
    return view('Pemeringkatan.ranking_unj.scimago.scimago');
})->name('Pemeringkatan.ranking_unj.scimago.scimago');

Route::get('/ranking_unj/sinta', function () {
    return view('Pemeringkatan.ranking_unj.sinta.sinta');
})->name('Pemeringkatan.ranking_unj.sinta.sinta');

Route::get('/indikator', function () {
    return view('Pemeringkatan.indikator.indikator');
})->name('Pemeringkatan.indikator.indikator');

Route::get('/Pemeringkatans', [BeritaController::class, 'landingPagePemeringkatan'])->name('pemeringkatan.landingpage');
Route::get('/Pemeringkatans/Ranking-Universitas/klaster-perguruan-tinggi', function () {
    return view('Pemeringkatan.Ranking_Universitas.Pemeringkatan_Klaster_Perguruan_Tinggi');
})->name('pemeringkatan.klaster');

// collection of admin-like routes
require __DIR__ . '/admin.php';
