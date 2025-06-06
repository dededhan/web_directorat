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
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProgramLayananController;
use App\Http\Controllers\ProgramKegiatanController;
use App\Http\Middleware\HandleRespondenForm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\InternationalFacultyStaffController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\AdminRespondenController;
use App\Http\Controllers\AdminSustainabilityController;
use App\Http\Controllers\AdminMataKuliahController;

Route::get('/api/responden-chart-data', [AdminRespondenController::class, 'getChartData'])->name('api.responden.chart-data');

// Alternative: If you want to group it with other API routes
Route::prefix('api')->group(function () {
    Route::get('/responden-chart-data', [AdminRespondenController::class, 'getChartData'])->name('api.responden.chart-data');
});

Route::get('/', [BeritaController::class, 'homeNews'])->name('home');


Route::get('/kebijakan-privasi', function () {
    return view('privasi.kebijakan-privasi');
})->name('kebijakan-privasi');

Route::get('/api/carousel-images', [GalleryController::class, 'getCarouselImages']);

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

Route::get('daptarcalonadjunct', function () {
    return view('daptarcalonadjunct.daptarcalonadjunct');
})->name('daptar.calonadjunct');

Route::get('/subdirektorat-inovasi/inkubator/inkubator_bisnis_pendidikan', function () {
    return view('subdirektorat-inovasi.inkubator.inkubator_bisnis_pendidikan');
})->name('subdirektorat-inovasi.inkubator.inkubator_bisnis_pendidikan');

Route::get('/subdirektorat-inovasi/inkubator/ekosisteminovasi', function () {
    return view('subdirektorat-inovasi.inkubator.ekosisteminovasi');
})->name('subdirektorat-inovasi.inkubator.ekosisteminovasi');

Route::get('/subdirektorat-inovasi/inkubator/inovasiaward', function () {
    return view('subdirektorat-inovasi.inkubator.inovasiaward');
})->name('subdirektorat-inovasi.inkubator.inovasiaward');

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

// Inside your authenticated admin group or a relevant group
Route::get('/admin/katsinov/{id}/certificate', [KatsinovController::class, 'downloadCertificate'])
    ->name('admin.katsinov.certificate')
    ->middleware('auth'); // Or your specific admin middleware

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


// Route::get('/', [ProgramLayananController::class, 'showHome'])->name('home');
// Route::get('/hilirisasi', [ProgramLayananController::class, 'showHilirisasi'])->name('hilirisasi');
// Route::get('/pemeringkatan', [ProgramLayananController::class, 'showPemeringkatan'])->name('pemeringkatan');

    
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

Route::get('/indikator', [App\Http\Controllers\IndikatorController::class, 'showAllIndikators'])
    ->name('Pemeringkatan.indikator.indikator');

//pemeringkatan

Route::get('/Pemeringkatans', [BeritaController::class, 'landingPagePemeringkatan'])->name('pemeringkatan.landingpage');
Route::get('/Pemeringkatans/Ranking-Universitas/klaster-perguruan-tinggi', function () {
    return view('Pemeringkatan.Ranking_Universitas.Pemeringkatan_Klaster_Perguruan_Tinggi');
})->name('pemeringkatan.klaster');

Route::get('/Pemeringkatans/matakuliahsustainability', 
    [AdminMataKuliahController::class, 'matakuliahSustainabilityView'])
    ->name('Pemeringkatan.matakuliahsustainability.matakuliahsustainability');
Route::get('/pemeringkatan/sustainability-data', 
    [AdminMataKuliahController::class, 'getSustainabilityData'])
    ->name('pemeringkatan.sustainability.data');

Route::get('/Pemeringkatans/program/global-engagement', function () {
    return view('Pemeringkatan.program.global-engagement');
})->name('Pemeringkatan.program.global-engagement');

Route::get('/Pemeringkatans/programsustainability/programsustainability', function () {
    return view('Pemeringkatan.programsustainability.programsustainability');
})->name('Pemeringkatan.programsustainability.programsustainability');

Route::get('/Pemeringkatan/kegiatansustainability', function () {
    return view('Pemeringkatan.kegiatansustainability.kegiatansustainability');
})->name('Pemeringkatan.kegiatansustainability.kegiatansustainability');
Route::get('/Pemeringkatan/kegiatansustainability/yearly', [AdminSustainabilityController::class, 'getYearlyData']);
Route::get('/Pemeringkatan/kegiatansustainability/faculty', [AdminSustainabilityController::class, 'getFacultyData']);
Route::get('/Pemeringkatan/kegiatansustainability/get-distinct-years', [AdminSustainabilityController::class, 'getDistinctYears'])
     ->name('pemeringkatan.sustainability.distinctYears');

Route::get('/Pemeringkatan/dataresponden', function () {
    return view('Pemeringkatan.dataresponden.dataresponden');
})->name('Pemeringkatan.dataresponden.dataresponden');

Route::get('/Pemeringkatans/program/lecturer-expose', function () {
    return view('Pemeringkatan.program.lecturer-expose');
})->name('Pemeringkatan.program.lecturer-expose');

// Route::get('/Pemeringkatans/program/international-faculty-staff', function () {
//     return view('Pemeringkatan.program.international-faculty-staff');
// })->name('Pemeringkatan.program.international-faculty-staff');

Route::get('/Pemeringkatans/program/international-faculty-staff', [InternationalFacultyStaffController::class, 'publicIndex'])
    ->name('Pemeringkatan.program.international-faculty-staff');
    
Route::get('/Pemeringkatan/program/international-student-mobility', function () {
    return view('Pemeringkatan.program.international-student-mobility');
})->name('Pemeringkatan.program.international-student-mobility');





require __DIR__ . '/admin.php';
