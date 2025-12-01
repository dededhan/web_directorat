<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pemeringkatan\Admin\AdminRespondenController;
use App\Http\Controllers\Pemeringkatan\Admin\AdminRespondenReportController;
use App\Http\Controllers\Pemeringkatan\Admin\AdminRespondenExportController;

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\InstagramApiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProgramKegiatanController;
use App\Http\Controllers\PublikasiRisetController;
use App\Http\Controllers\Pemeringkatan\AdminMataKuliahController;
use App\Http\Controllers\AdminSustainabilityController;
use App\Http\Controllers\Pemeringkatan\Admin\InternationalFacultyStaffActivitiesController;
use App\Http\Controllers\RisetUnjController;
use App\Http\Controllers\Api\CountryController;
use App\Models\Prodi; 
use App\Http\Controllers\Pemeringkatan\Admin\RespondenAnswerGraphController; 


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/carousel-images', [GalleryController::class, 'getCarouselImages']);
Route::get('/announcements', [PengumumanController::class, 'getActiveAnnouncements'])->name('api.announcements');
Route::get('/youtube-videos', [YoutubeController::class, 'getFrontendVideos'])->name('api.youtube-videos');
Route::get('/instagram-posts', [InstagramApiController::class, 'getPosts']);
Route::get('/documents', [DokumenController::class, 'apiGetDocuments'])->name('api.documents');
Route::get('/Berita/{id}', [BeritaController::class, 'getBeritaDetail']);

Route::get('/sdgscenter/programs', [ProgramKegiatanController::class, 'getSDGCenterPrograms'])->name('api.sdgscenter.programs');
Route::get('/sdgscenter/publications', [PublikasiRisetController::class, 'getSDGCenterPublications'])->name('api.sdgscenter.publications');
Route::get('/public/sustainability-courses/{faculty}', [AdminMataKuliahController::class, 'getPublicSustainabilityCourses']);

Route::prefix('pemeringkatan/sustainability')->name('api.pemeringkatan.sustainability.')->group(function () {
    Route::get('/data', [AdminMataKuliahController::class, 'getSustainabilityData'])->name('data');
    Route::get('/kegiatan/yearly', [AdminSustainabilityController::class, 'getYearlyData'])->name('kegiatan.yearly');
    Route::get('/kegiatan/faculty', [AdminSustainabilityController::class, 'getFacultyData'])->name('kegiatan.faculty');
    Route::get('/kegiatan/distinct-years', [AdminSustainabilityController::class, 'getDistinctYears'])->name('kegiatan.distinctYears');
});

Route::get('/aktivitas-dosen-asing/{id}', [InternationalFacultyStaffActivitiesController::class, 'show'])->name('api.aktivitas-dosen-asing.show');

Route::get('/riset-unj/graph-data', [RisetUnjController::class, 'getGraphData'])->name('api.riset-unj.graph-data');


//Chart Responden
Route::get('/responden/chart-summary', [AdminRespondenReportController::class, 'getChartSummaryData'])
    ->name('api.responden.chartSummary');
Route::get('/responden/chart-prodi', [AdminRespondenReportController::class, 'getProdiChartData'])
    ->name('api.responden.chartProdi');
Route::get('/api/responden-chart-data', [AdminRespondenReportController::class, 'getChartData'])->name('api.responden.chart-data');
Route::get('/fakultas/report-data', [AdminRespondenReportController::class, 'getFacultyReportData'])
    ->name('api.fakultas.reportData')
    ->middleware('auth');

//Chart Responden Answer
//Chart Responden
Route::get('/responden-graph-data', [RespondenAnswerGraphController::class, 'getGraphData'])->name('api.responden.graph-data');

//equity
Route::get('/prodi/{fakultas_id}', function ($fakultas_id) {
    return Prodi::where('fakultas_id', $fakultas_id)->orderBy('name')->get();
});

Route::get('/countries', [CountryController::class, 'index'])->name('api.countries.index');