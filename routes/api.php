<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminRespondenController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\InstagramApiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProgramKegiatanController;
use App\Http\Controllers\PublikasiRisetController;
use App\Http\Controllers\AdminMataKuliahController;
use App\Http\Controllers\AdminSustainabilityController;
use App\Http\Controllers\InternationalFacultyStaffActivitiesController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Existing API Routes have been moved here from web.php
Route::get('/responden-chart-data', [AdminRespondenController::class, 'getChartData'])->name('api.responden.chart-data');
Route::get('/carousel-images', [GalleryController::class, 'getCarouselImages']);
Route::get('/announcements', [PengumumanController::class, 'getActiveAnnouncements'])->name('api.announcements');
Route::get('/youtube-videos', [YoutubeController::class, 'getFrontendVideos'])->name('api.youtube-videos');
Route::get('/instagram-posts', [InstagramApiController::class, 'getPosts']);
Route::get('/documents', [DokumenController::class, 'apiGetDocuments'])->name('api.documents');
Route::get('/Berita/{id}', [BeritaController::class, 'getBeritaDetail']);

// SDG Center API routes
Route::get('/sdgscenter/programs', [ProgramKegiatanController::class, 'getSDGCenterPrograms'])->name('api.sdgscenter.programs');
Route::get('/sdgscenter/publications', [PublikasiRisetController::class, 'getSDGCenterPublications'])->name('api.sdgscenter.publications');

// Sustainability data routes
Route::prefix('pemeringkatan/sustainability')->name('api.pemeringkatan.sustainability.')->group(function() {
    Route::get('/data', [AdminMataKuliahController::class, 'getSustainabilityData'])->name('data');
    Route::get('/kegiatan/yearly', [AdminSustainabilityController::class, 'getYearlyData'])->name('kegiatan.yearly');
    Route::get('/kegiatan/faculty', [AdminSustainabilityController::class, 'getFacultyData'])->name('kegiatan.faculty');
    Route::get('/kegiatan/distinct-years', [AdminSustainabilityController::class, 'getDistinctYears'])->name('kegiatan.distinctYears');
});

Route::get('/aktivitas-dosen-asing/{id}', [InternationalFacultyStaffActivitiesController::class, 'show'])->name('api.aktivitas-dosen-asing.show');
