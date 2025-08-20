<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KatsinovController;
use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\AdminRespondenController;
use App\Http\Controllers\AdminMataKuliahController;
use App\Http\Controllers\RespondenAnswerController;
use App\Http\Controllers\QuesionerGeneralController;
use App\Http\Controllers\DosenInternasionalController;
use App\Http\Controllers\AdminSustainabilityController;
use App\Http\Controllers\AdminAlumniBerdampakController;
use App\Http\Controllers\InternationalStudentController;
use App\Http\Controllers\ProgramKegiatanController;
use App\Http\Controllers\PublikasiRisetController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\FormInformasiDasarController;
use App\Http\Controllers\FormRecordHasilPengukuranController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProgramLayananController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\ProdukInovasiController;
use App\Http\Controllers\SejarahContentController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\GlobalEngagementController;

use Illuminate\Http\Request;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InternationalFacultyStaffController;
use App\Http\Controllers\InternationalFacultyStaffActivitiesController;
// Ganti route yang ada dengan:
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\IndikatorController;



Route::prefix('admin')->name('admin.')
    ->middleware(['checked', 'role:admin_direktorat'])
    ->group(function () {
        Route::get('/', function () {
            return redirect(route('admin.dashboard'));
        });
        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboardadmin');
        })->name('dashboard');

        // News
        Route::resource('/news', BeritaController::class)
            ->except(['show', 'edit', 'update']);
        Route::get('/berita/{id}/detail', [BeritaController::class, 'getBeritaDetail'])
            ->name('news.detail');
        Route::put('/berita/{id}', [BeritaController::class, 'update'])
            ->name('news.update');
        Route::post('/berita/upload', [BeritaController::class, 'upload'])->name('news.upload');

        Route::resource('/news-scroll', PengumumanController::class);
        Route::get('/pengumuman/{id}/detail', [PengumumanController::class, 'getPengumumanDetail'])
            ->name('news-scroll.detail');

        Route::resource('/program-layanan', ProgramLayananController::class);
        Route::get('/program-layanan/{id}/detail', [ProgramLayananController::class, 'getProgramDetail'])
            ->name('program-layanan.detail');
        Route::put('program-layanan/{programLayanan}', [ProgramLayananController::class, 'update'])->name('program-layanan.update');

        //Youtube
        Route::resource('/youtube', YoutubeController::class)
            ->except(['show', 'edit']);
        Route::get('/youtube/{id}/detail', [YoutubeController::class, 'getVideoDetail'])
            ->name('youtube.detail');
        Route::get('/youtube/{id}/preview', [YoutubeController::class, 'preview'])
            ->name('youtube.preview');

        // Instagram
        Route::resource('/instagram', InstagramController::class)
            ->except(['show', 'edit', 'update']);

        Route::get('/instagram/{id}/preview', [InstagramController::class, 'preview'])
            ->name('instagram.preview');

        Route::resource('/document', DokumenController::class);
        Route::get('document/{dokumen}/download', [DokumenController::class, 'download'])
            ->name('document.download');

        //sejarah
        Route::resource('/sejarah', SejarahContentController::class);

        Route::resource('/gallery', GalleryController::class);
        Route::get('/gallery/{id}/detail', [GalleryController::class, 'getGalleryDetail'])->name('gallery.detail');


        // Pimpinan routes
        Route::resource('/pimpinan', PimpinanController::class)
            ->except(['show', 'edit', 'create']);
        Route::get('/pimpinan/{id}/detail', [PimpinanController::class, 'getPimpinanDetail'])
            ->name('pimpinan.detail');
        Route::post('/pimpinan/upload', [PimpinanController::class, 'upload'])
            ->name('pimpinan.upload');

        Route::get('/responden/laporan', [AdminRespondenController::class, 'laporan'])
            ->name('responden_laporan');

        Route::resource('/responden', AdminRespondenController::class)->except(['update']);
        Route::put('/responden/{responden}', [AdminRespondenController::class, 'update'])
            ->name('responden.update');


        // Untuk update status khusus (POST)
        Route::post('/responden/update-status/{id}', [AdminRespondenController::class, 'updateStatus'])
            ->name('responden.updateStatus');

        Route::post('/responden/import', [AdminRespondenController::class, 'import'])->name('responden.import');
        Route::get('/responden/filter', [AdminRespondenController::class, 'filter'])->name('responden.filter');
        Route::get('/responden/export/excel', [AdminRespondenController::class, 'export'])
            ->name('responden.export');
        Route::get('/responden/export/csv', [AdminRespondenController::class, 'exportCSV'])
            ->name('responden.exportCSV');


        // Route::resource('/manageuser', UserController::class);
        // Route::put('/manageuser/{user}', [UserController::class, 'update'])
        //     ->name('manageuser.update');

        // Route::delete('/manageuser/{user}', [UserController::class, 'destroy'])
        //     ->name('manageuser.destroy');

        // Route::put('/manageuser/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('manageuser.toggleStatus');

        Route::resource('/manageuser', UserController::class)->parameters([
            'manageuser' => 'user'
        ]);

        // This route for toggling status is separate and is correct.
        Route::put('/manageuser/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('manageuser.toggleStatus');

        Route::resource('/sustainability', AdminSustainabilityController::class);
        Route::get('/sustainability/{id}/detail', [AdminSustainabilityController::class, 'getSustainabilityDetail'])
            ->name('sustainability.detail');

        Route::resource('/matakuliah', AdminMataKuliahController::class);
        Route::get('/matakuliah', [AdminMataKuliahController::class, 'index'])->name('matakuliah.index');
        Route::post('/matakuliah', [AdminMataKuliahController::class, 'store'])->name('matakuliah.store');

        Route::resource('/alumniberdampak', AdminAlumniBerdampakController::class);
        Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
        Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');

        Route::get('/qstable', function () {
            return view('admin.qstable');
        })->name('qstable');


        Route::get('/qsgeneraltable', [QuesionerGeneralController::class, 'index'])->name('qsgeneraltable');

        Route::resource('/qsresponden', RespondenAnswerController::class)->except(['create', 'store']);

        // mahasiswa
        Route::resource('/mahasiswainternational', InternationalStudentController::class);
        Route::get('/mahasiswainternational/{id}/detail', [InternationalStudentController::class, 'getStudentDetail'])
            ->name('mahasiswainternational.detail');

        Route::resource('/dataakreditasi', AkreditasiController::class);
        Route::get('/dataakreditasi/{id}/detail', [AkreditasiController::class, 'getAkreditasiDetail'])
            ->name('dataakreditasi.detail');

        Route::resource('/internationallecture', DosenInternasionalController::class);
        Route::get('/internationallecture/{id}/detail', [DosenInternasionalController::class, 'getDosenDetail'])
            ->name('internationallecture.detail');

        //ranking
        Route::resource('/ranking', RankingController::class)
            ->except(['show']);
        Route::get('/ranking/{ranking}/edit', [RankingController::class, 'edit'])->name('ranking.edit'); // Explicit edit route
        Route::get('/ranking/{id}/detail', [RankingController::class, 'getRankingDetail'])
            ->name('ranking.detail'); // This can be kept if used elsewhere, or removed if only for the old modal
        Route::post('/ranking/upload', [RankingController::class, 'upload'])
            ->name('ranking.upload');


        Route::prefix('global')->name('global.')->middleware(['checked', 'role:admin_direktorat'])->group(function () {
            Route::get('engagement', [GlobalEngagementController::class, 'dashboard'])->name('engagement.dashboard');

            // "Tentang" Section
            Route::post('engagement/about', [GlobalEngagementController::class, 'updateAbout'])->name('engagement.about.update');

            // "Program" Section
            Route::post('engagement/programs', [GlobalEngagementController::class, 'storeProgram'])->name('engagement.program.store');
            Route::get('engagement/programs/{id}/edit', [GlobalEngagementController::class, 'editProgram'])->name('engagement.program.edit');
            Route::put('engagement/programs/{id}', [GlobalEngagementController::class, 'updateProgram'])->name('engagement.program.update');
            Route::delete('engagement/programs/{id}', [GlobalEngagementController::class, 'destroyProgram'])->name('engagement.program.destroy');

            // "Partner" Section
            Route::post('engagement/partners', [GlobalEngagementController::class, 'storePartner'])->name('engagement.partner.store');
            Route::get('engagement/partners/{id}/edit', [GlobalEngagementController::class, 'editPartner'])->name('engagement.partner.edit');
            Route::put('engagement/partners/{id}', [GlobalEngagementController::class, 'updatePartner'])->name('engagement.partner.update');
            Route::delete('engagement/partners/{id}', [GlobalEngagementController::class, 'destroyPartner'])->name('engagement.partner.destroy');
        });

        //international
        Route::resource('/international_faculty_staff', InternationalFacultyStaffController::class);
        Route::get('/international_faculty_staff/{id}/detail', [InternationalFacultyStaffController::class, 'getStaffDetail'])
            ->name('international_faculty_staff.detail');

        //activitas dosen asing
        Route::resource('/international-activities', InternationalFacultyStaffActivitiesController::class);
        Route::get('/international-activities/{id}/detail', [InternationalFacultyStaffActivitiesController::class, 'detail']);



        //indicator
        Route::resource('/indikator', IndikatorController::class)
            ->except(['show', 'edit']);
        Route::get('/indikator/{id}/detail', [IndikatorController::class, 'getIndikatorDetail'])
            ->name('indikator.detail');



        //inovasi
        Route::get('/produk_inovasi', [ProdukInovasiController::class, 'index'])->name('produk_inovasi');
        Route::post('/produk_inovasi', [ProdukInovasiController::class, 'store'])->name('produk_inovasi.store');
        Route::get('/produk_inovasi/{id}/detail', [ProdukInovasiController::class, 'getProdukDetail'])->name('produk_inovasi.detail');
        Route::put('/produk_inovasi/{id}', [ProdukInovasiController::class, 'update'])->name('produk_inovasi.update');
        Route::delete('/produk_inovasi/{id}', [ProdukInovasiController::class, 'destroy'])->name('produk_inovasi.destroy');
        Route::post('/produk_inovasi/upload', [ProdukInovasiController::class, 'upload'])->name('produk_inovasi.upload');


        Route::prefix('katsinov')->name('katsinov.')
            ->group(function () {
                Route::get('/TableKatsinov', [KatsinovController::class, 'index'])->name('TableKatsinov');
                Route::post('/update-user', [KatsinovController::class, 'updateUser'])->name('update-user');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::get('/show/{id}', [KatsinovController::class, 'show'])->name('show');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');
                Route::get('/katsinov/latest', [KatsinovController::class, 'latest']);
                Route::get('/documents/{id}', [KatsinovController::class, 'viewDocument'])
                    ->name('document.view');
                Route::delete('/document/{id}', [KatsinovController::class, 'destroyDocument'])->name('document.delete');

                // Route::get('/print_katsinov/{id}', [KatsinovController::class, 'downloadDetailPDF'])->name('print_katsinov');
                Route::get('/print/{id}', [KatsinovController::class, 'printForm'])->name('print');

                // Route::get('/print_katsinov/{id}', [KatsinovController::class, 'downloadDetailPDF'])->name('print_katsinov');

                Route::get('/signature/{id}/{type}', [KatsinovController::class, 'viewSignature'])
                    ->name('signature.view');


                Route::get('/download-pengukuran-report/{katsinov_id}', [KatsinovController::class, 'downloadPengukuranHasilReport'])->name('download-pengukuran-report'); // New Route
                //summary
                Route::get('{katsinov_id}/record/summary', [KatsinovController::class, 'recordShow'])->name('record.show');
                Route::get('{katsinov_id}/summary-indicator-one', [KatsinovController::class, 'summaryIndicatorOne'])->name('summary-indicator-one');
                Route::get('{katsinov_id}/summary-indicator-two', [KatsinovController::class, 'summaryIndicatortwo'])->name('summary-indicator-two');
                Route::get('{katsinov_id}/summary-indicator-three', [KatsinovController::class, 'summaryIndicatorthree'])->name('summary-indicator-three');
                Route::get('{katsinov_id}/summary-indicator-four', [KatsinovController::class, 'summaryIndicatorfour'])->name('summary-indicator-four');
                Route::get('{katsinov_id}/summary-indicator-five', [KatsinovController::class, 'summaryIndicatorfive'])->name('summary-indicator-five');
                Route::get('{katsinov_id}/summary-indicator-six', [KatsinovController::class, 'summaryIndicatorsix'])->name('summary-indicator-six');
                Route::get('summary-all/{katsinov_id}', [KatsinovController::class, 'summaryAll'])->name('summary-all');


                Route::get('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiIndex'])->name('inovasi.index');
                Route::post('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiStore'])->name('inovasi.store');
                // Form Berita Acara with katsinov_id parameter
                Route::get('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaIndex'])->name('berita.index');
                Route::post('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaStore'])->name('berita.store');

                Route::get('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationIndex'])->name('informasi.index');
                Route::post('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationStore'])->name('informasi.store');


                // Lampiran with katsinov_id parameter
                Route::get('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranIndex'])->name('lampiran.index');
                Route::post('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranStore'])->name('lampiran.store');

                //Form record hasil pengukuran
                Route::get('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordIndex'])->name('record.index');
                Route::post('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordStore'])->name('record.store');
            });

        Route::prefix('SDGs')->name('SDGs.')
            ->group(function () {

                // Program Kegiatan

                Route::resource('/program-kegiatan', ProgramKegiatanController::class)->except(['show']);
                Route::get('/program-kegiatan/{id}/detail', [ProgramKegiatanController::class, 'detail'])
                    ->name('program-kegiatan.detail');

                // Publikasi Riset
                Route::resource('/publikasi-riset', PublikasiRisetController::class)->except(['show']);
                Route::get('/publikasi-riset/download/{id}', [PublikasiRisetController::class, 'download'])
                    ->name('publikasi-riset.download');

                Route::get('/publikasi-riset/{id}/detail', [App\Http\Controllers\PublikasiRisetController::class, 'detail'])
                    ->name('admin.SDGs.publikasi-riset.detail');
            });
    });

Route::prefix('prodi')->name('prodi.')
    ->middleware(['checked', 'role:prodi'])
    ->group(function () {
        Route::get('/', function () {
            return redirect(route('prodi.dashboard'));
        });
        Route::get('/dashboard', function () {
            return view('prodi.dashboard');
        })->name('dashboard');

        // News
        Route::resource('/news', BeritaController::class)
            ->except(['show', 'edit', 'update']);
        Route::get('/berita/{id}/detail', [BeritaController::class, 'getBeritaDetail'])
            ->name('news.detail');
        Route::put('/berita/{id}', [BeritaController::class, 'update'])
            ->name('news.update');
        Route::post('/berita/upload', [BeritaController::class, 'upload'])->name('news.upload');

        // Sustainability routes for prodi
        Route::resource('/sustainability', AdminSustainabilityController::class);
        Route::get('/sustainability/{id}/detail', [AdminSustainabilityController::class, 'getSustainabilityDetail'])
            ->name('sustainability.detail');

        Route::resource('/responden', AdminRespondenController::class)->except(['update']);
        Route::put('/responden/{responden}', [AdminRespondenController::class, 'update'])
            ->name('responden.update');
        Route::post('/responden/update-status/{id}', [AdminRespondenController::class, 'updateStatus'])
            ->name('responden.updateStatus');
        Route::post('/responden/import', [AdminRespondenController::class, 'import'])->name('responden.import');
        Route::get('/responden/filter', [AdminRespondenController::class, 'filter'])->name('responden.filter');
        Route::get('/responden/export/excel', [AdminRespondenController::class, 'export'])
            ->name('responden.export');
        Route::get('/responden/export/csv', [AdminRespondenController::class, 'exportCSV'])
            ->name('responden.exportCSV');
        Route::resource('/matakuliah', AdminMataKuliahController::class);
        Route::get('/matakuliah', [AdminMataKuliahController::class, 'index'])->name('matakuliah.index');
        Route::post('/matakuliah', [AdminMataKuliahController::class, 'store'])->name('matakuliah.store');
        Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
        Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');
        Route::resource('/qsresponden', RespondenAnswerController::class)->except(['create', 'store']);


                // NEW: Manage Account Routes for Fakultas
        Route::get('/account', function () {
            return view('prodi.manage_account');
        })->name('manage.account');
        // Route::put('/account', [UserController::class, 'updateAccount'])->name('manage.account.update');
    });

Route::prefix('fakultas')->name('fakultas.')
    ->middleware(['checked', 'role:fakultas'])
    ->group(function () {
        Route::get('/', function () {
            return redirect(route('fakultas.dashboard'));
        });
        Route::get('/dashboard', function () {
            return view('fakultas.dashboard');
        })->name('dashboard');


        // News
        Route::resource('/news', BeritaController::class)
            ->except(['show', 'edit', 'update']);
        Route::get('/berita/{id}/detail', [BeritaController::class, 'getBeritaDetail'])
            ->name('news.detail');
        Route::put('/berita/{id}', [BeritaController::class, 'update'])
            ->name('news.update');
        Route::post('/berita/upload', [BeritaController::class, 'upload'])->name('news.upload');

        // Sustainability routes for fakultas
        Route::resource('/sustainability', AdminSustainabilityController::class);
        Route::get('/sustainability/{id}/detail', [AdminSustainabilityController::class, 'getSustainabilityDetail'])
            ->name('sustainability.detail');


        Route::resource('/responden', AdminRespondenController::class)->except(['update']);
        Route::put('/responden/{responden}', [AdminRespondenController::class, 'update'])
            ->name('responden.update');
        Route::post('/responden/update-status/{id}', [AdminRespondenController::class, 'updateStatus'])
            ->name('responden.updateStatus');
        Route::post('/responden/import', [AdminRespondenController::class, 'import'])->name('responden.import');
        Route::get('/responden/filter', [AdminRespondenController::class, 'filter'])->name('responden.filter');
        Route::get('/responden/export/excel', [AdminRespondenController::class, 'export'])
            ->name('responden.export');
        Route::get('/responden/export/csv', [AdminRespondenController::class, 'exportCSV'])
            ->name('responden.exportCSV');

        Route::resource('/matakuliah', AdminMataKuliahController::class);
        Route::get('/matakuliah', [AdminMataKuliahController::class, 'index'])->name('matakuliah.index');
        Route::post('/matakuliah', [AdminMataKuliahController::class, 'store'])->name('matakuliah.store');
        Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
        Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');
        Route::resource('/qsresponden', RespondenAnswerController::class)->except(['create', 'store']);

        // NEW: Manage Account Routes for Fakultas
        Route::get('/account', function () {
            return view('fakultas.manage_account');
        })->name('manage.account');
        // Route::put('/account', [UserController::class, 'updateAccount'])->name('manage.account.update');
    });


Route::prefix('admin_pemeringkatan')->name('admin_pemeringkatan.')
    ->middleware(['checked', 'role:admin_pemeringkatan'])
    ->group(function () {
        Route::get('/', function () {
            return redirect(route('admin_pemeringkatan.dashboard'));
        });
        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin_pemeringkatan.dashboard');
        })->name('dashboard');

        // News
        Route::resource('/news', BeritaController::class)
            ->except(['show', 'edit', 'update']);
        Route::get('/berita/{id}/detail', [BeritaController::class, 'getBeritaDetail'])
            ->name('news.detail');
        Route::put('/berita/{id}', [BeritaController::class, 'update'])
            ->name('news.update');
        Route::post('/berita/upload', [BeritaController::class, 'upload'])->name('news.upload');

        Route::resource('/news-scroll', PengumumanController::class);
        Route::get('/pengumuman/{id}/detail', [PengumumanController::class, 'getPengumumanDetail'])
            ->name('news-scroll.detail');

        Route::resource('/program-layanan', ProgramLayananController::class);
        Route::get('/program-layanan/{id}/detail', [ProgramLayananController::class, 'getProgramDetail'])
            ->name('program-layanan.detail');
        Route::put('program-layanan/{programLayanan}', [ProgramLayananController::class, 'update'])->name('program-layanan.update');
        //Youtube
        Route::resource('/youtube', YoutubeController::class)
            ->except(['show', 'edit']);
        Route::get('/youtube/{id}/detail', [YoutubeController::class, 'getVideoDetail'])
            ->name('youtube.detail');
        Route::get('/youtube/{id}/preview', [YoutubeController::class, 'preview'])
            ->name('youtube.preview');

        // Instagram
        Route::resource('/instagram', InstagramController::class)
            ->except(['show', 'edit', 'update']);

        Route::get('/instagram/{id}/preview', [InstagramController::class, 'preview'])
            ->name('instagram.preview');

        Route::resource('/document', DokumenController::class);
        Route::get('document/{dokumen}/download', [DokumenController::class, 'download'])
            ->name('document.download');

        //sejarah
        Route::resource('/sejarah', SejarahContentController::class);

        Route::resource('/sustainability', AdminSustainabilityController::class);

        //Mata Kuliah
        Route::get('/matakuliah', [AdminMataKuliahController::class, 'index'])->name('matakuliah.index');
        Route::post('/matakuliah', [AdminMataKuliahController::class, 'store'])->name('matakuliah.store');

        //Alumni
        Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
        Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');

        //responden
        Route::resource('/qsresponden', RespondenAnswerController::class)->except(['create', 'store']);
    });

Route::prefix('subdirektorat-inovasi')->name('subdirektorat-inovasi.')
    ->group(function () {
        Route::prefix('dosen')->name('dosen.')
            ->middleware(['checked', 'role:dosen'])
            ->group(function () {
                // Dashboard
                Route::get('/dashboard', function () {
                    return view('subdirektorat-inovasi.dosen.dashboard');
                })->name('dashboard');


                // Tabel Katsinov
                Route::get('/tablekatsinov', [KatsinovController::class, 'index'])->name('tablekatsinov');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::get('/show/{id}', [KatsinovController::class, 'show'])->name('show');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');
                Route::get('/katsinov/latest', [KatsinovController::class, 'latest']);
                Route::get('/documents/{id}', [KatsinovController::class, 'viewDocument'])
                    ->name('document.view');
                Route::delete('/document/{id}', [KatsinovController::class, 'destroyDocument'])->name('document.delete');
                Route::get('/signature/{id}/{type}', [KatsinovController::class, 'viewSignature'])
                    ->name('signature.view');


                Route::get('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiIndex'])->name('inovasi.index');
                Route::post('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiStore'])->name('inovasi.store');
                // Form Berita Acara with katsinov_id parameter
                Route::get('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaIndex'])->name('berita.index');
                Route::post('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaStore'])->name('berita.store');

                Route::get('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationIndex'])->name('informasi.index');
                Route::post('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationStore'])->name('informasi.store');


                // Lampiran with katsinov_id parameter
                Route::get('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranIndex'])->name('lampiran.index');
                Route::post('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranStore'])->name('lampiran.store');

                //Form record hasil pengukuran
                Route::get('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordIndex'])->name('record.index');
                Route::post('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordStore'])->name('record.store');
            });


        // Admin Hilirisasi routes
        Route::prefix('admin_hilirisasi')->name('admin_hilirisasi.')
            ->middleware(['checked', 'role:admin_hilirisasi'])
            ->group(function () {
                // Dashboard
                Route::get('/dashboard', function () {
                    return view('subdirektorat-inovasi.admin_hilirisasi.dashboard');
                })->name('dashboard');

                Route::resource('/news', BeritaController::class)
                    ->except(['show', 'edit', 'update']);
                Route::get('/berita/{id}/detail', [BeritaController::class, 'getBeritaDetail'])
                    ->name('news.detail');
                Route::put('/berita/{id}', [BeritaController::class, 'update'])
                    ->name('news.update');
                Route::post('/berita/upload', [BeritaController::class, 'upload'])->name('news.upload');

                Route::resource('/news-scroll', PengumumanController::class);
                Route::get('/pengumuman/{id}/detail', [PengumumanController::class, 'getPengumumanDetail'])
                    ->name('news-scroll.detail');

                Route::resource('/program-layanan', ProgramLayananController::class);
                Route::get('/program-layanan/{id}/detail', [ProgramLayananController::class, 'getProgramDetail'])
                    ->name('program-layanan.detail');
                Route::put('program-layanan/{programLayanan}', [ProgramLayananController::class, 'update'])->name('program-layanan.update');
                //Youtube
                Route::resource('/youtube', YoutubeController::class)
                    ->except(['show', 'edit']);
                Route::get('/youtube/{id}/detail', [YoutubeController::class, 'getVideoDetail'])
                    ->name('youtube.detail');
                Route::get('/youtube/{id}/preview', [YoutubeController::class, 'preview'])
                    ->name('youtube.preview');

                // Instagram
                Route::resource('/instagram', InstagramController::class)
                    ->except(['show', 'edit', 'update']);

                Route::get('/instagram/{id}/preview', [InstagramController::class, 'preview'])
                    ->name('instagram.preview');

                Route::resource('/document', DokumenController::class);
                Route::get('document/{dokumen}/download', [DokumenController::class, 'download'])
                    ->name('document.download');


                //sejarah
                Route::resource('/sejarah', SejarahContentController::class);

                //galery
                // In admin.php, inside the admin route group
                Route::resource('/gallery', GalleryController::class);
                Route::get('/gallery/{id}/detail', [GalleryController::class, 'getGalleryDetail'])->name('gallery.detail');


                // Tabel Katsinov
                Route::get('/tablekatsinov', [KatsinovController::class, 'index'])->name('tablekatsinov');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');
                Route::get('/show/{id}', [KatsinovController::class, 'show'])->name('show');

                Route::get('/katsinov/latest', [KatsinovController::class, 'latest']);

                // Lampiran route
                Route::get('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranIndex'])->name('lampiran');
                Route::post('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranStore'])->name('lampiran.store');
                Route::delete('/document/{id}', [KatsinovController::class, 'destroyDocument'])->name('document.delete');

                // Form routes
                Route::get('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiIndex'])->name('inovasi.index');
                Route::post('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiStore'])->name('inovasi.store');

                Route::get('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaIndex'])->name('berita.index');
                Route::post('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaStore'])->name('berita.store');

                Route::get('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationIndex'])->name('informasi.index');
                Route::post('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationStore'])->name('informasi.store');

                Route::get('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordIndex'])->name('record.index');
                Route::post('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordStore'])->name('record.store');


                // Produk Inovasi routes for admin_hilirisasi
                Route::get('/produk_inovasi', [ProdukInovasiController::class, 'index'])->name('produk_inovasi');
                Route::post('/produk_inovasi', [ProdukInovasiController::class, 'store'])->name('produk_inovasi.store');
                Route::get('/produk_inovasi/{id}/detail', [ProdukInovasiController::class, 'getProdukDetail'])->name('produk_inovasi.detail');
                Route::put('/produk_inovasi/{id}', [ProdukInovasiController::class, 'update'])->name('produk_inovasi.update');
                Route::delete('/produk_inovasi/{id}', [ProdukInovasiController::class, 'destroy'])->name('produk_inovasi.destroy');
                Route::post('/produk_inovasi/upload', [ProdukInovasiController::class, 'upload'])->name('produk_inovasi.upload');
                // SDGs routes
                Route::prefix('SDGs')->name('SDGs.')
                    ->group(function () {
                        // Program Kegiatan
                        Route::get('/program_kegiatan', function () {
                            return view('subdirektorat-inovasi.admin_hilirisasi.SDGs.program_kegiatan');
                        })->name('program_kegiatan');

                        // Publikasi Riset
                        Route::get('/publikasi_riset', function () {
                            return view('subdirektorat-inovasi.admin_hilirisasi.SDGs.publikasi_riset');
                        })->name('publikasi_riset');
                    });
            });



        // Validator
        Route::prefix('validator')->name('validator.')
            ->middleware(['checked', 'role:validator'])
            ->group(function () {
                Route::get('/dashboard', function () {
                    return view('subdirektorat-inovasi.validator.dashboard');
                })->name('dashboard');

                // Tabel Katsinov
                Route::get('/tablekatsinov', [KatsinovController::class, 'index'])->name('tablekatsinov');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::get('/show/{id}', [KatsinovController::class, 'show'])->name('show');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');
                Route::get('/katsinov/latest', [KatsinovController::class, 'latest']);
                Route::get('/documents/{id}', [KatsinovController::class, 'viewDocument'])
                    ->name('document.view');
                Route::delete('/document/{id}', [KatsinovController::class, 'destroyDocument'])->name('document.delete');
                Route::get('/signature/{id}/{type}', [KatsinovController::class, 'viewSignature'])
                    ->name('signature.view');
                Route::get('/print/{id}', [KatsinovController::class, 'printForm'])->name('print');

                //summary
                Route::get('{katsinov_id}/record/summary', [KatsinovController::class, 'recordShow'])->name('record.show');
                Route::get('{katsinov_id}/summary-indicator-one', [KatsinovController::class, 'summaryIndicatorOne'])->name('summary-indicator-one');
                Route::get('{katsinov_id}/summary-indicator-two', [KatsinovController::class, 'summaryIndicatortwo'])->name('summary-indicator-two');
                Route::get('{katsinov_id}/summary-indicator-three', [KatsinovController::class, 'summaryIndicatorthree'])->name('summary-indicator-three');
                Route::get('{katsinov_id}/summary-indicator-four', [KatsinovController::class, 'summaryIndicatorfour'])->name('summary-indicator-four');
                Route::get('{katsinov_id}/summary-indicator-five', [KatsinovController::class, 'summaryIndicatorfive'])->name('summary-indicator-five');
                Route::get('{katsinov_id}/summary-indicator-six', [KatsinovController::class, 'summaryIndicatorsix'])->name('summary-indicator-six');
                Route::get('summary-all/{katsinov_id}', [KatsinovController::class, 'summaryAll'])->name('summary-all');


                Route::get('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiIndex'])->name('inovasi.index');
                Route::post('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiStore'])->name('inovasi.store');
                // Form Berita Acara with katsinov_id parameter
                Route::get('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaIndex'])->name('berita.index');
                Route::post('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaStore'])->name('berita.store');

                Route::get('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationIndex'])->name('informasi.index');
                Route::post('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationStore'])->name('informasi.store');


                // Lampiran with katsinov_id parameter
                Route::get('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranIndex'])->name('lampiran.index');
                Route::post('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranStore'])->name('lampiran.store');

                //Form record hasil pengukuran
                Route::get('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordIndex'])->name('record.index');
                Route::post('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordStore'])->name('record.store');


                Route::prefix('SDGs')->name('SDGs.')
                    ->group(function () {
                        // Program Kegiatan
                        Route::get('/program_kegiatan', function () {
                            return view('Inovasi.validator.SDGs.program_kegiatan');
                        })->name('program_kegiatan');

                        // Publikasi Riset
                        Route::get('/publikasi_riset', function () {
                            return view('Inovasi.validator.SDGs.publikasi_riset');
                        })->name('publikasi_riset');
                    });
            });

        // registered user
        Route::prefix('registered_user')->name('registered_user.')
            ->middleware(['checked', 'role:registered_user'])
            ->group(function () {
                // Dashboard
                Route::get('/dashboard', function () {
                    return view('subdirektorat-inovasi.registered_user.dashboard');
                })->name('dashboard');

                // You can add more routes for registered users here as needed
                Route::get('/profile', function () {
                    return view('subdirektorat-inovasi.registered_user.profile');
                })->name('profile');

                // Tabel Katsinov
                Route::get('/tablekatsinov', [KatsinovController::class, 'index'])->name('tablekatsinov');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::get('/show/{id}', [KatsinovController::class, 'show'])->name('show');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');
                Route::get('/katsinov/latest', [KatsinovController::class, 'latest']);
                Route::get('/documents/{id}', [KatsinovController::class, 'viewDocument'])
                    ->name('document.view');
                Route::delete('/document/{id}', [KatsinovController::class, 'destroyDocument'])->name('document.delete');
                Route::get('/signature/{id}/{type}', [KatsinovController::class, 'viewSignature'])
                    ->name('signature.view');

                Route::get('/print/{id}', [KatsinovController::class, 'printForm'])->name('print');

                //summary
                Route::get('{katsinov_id}/record/summary', [KatsinovController::class, 'recordShow'])->name('record.show');
                Route::get('{katsinov_id}/summary-indicator-one', [KatsinovController::class, 'summaryIndicatorOne'])->name('summary-indicator-one');
                Route::get('{katsinov_id}/summary-indicator-two', [KatsinovController::class, 'summaryIndicatortwo'])->name('summary-indicator-two');
                Route::get('{katsinov_id}/summary-indicator-three', [KatsinovController::class, 'summaryIndicatorthree'])->name('summary-indicator-three');
                Route::get('{katsinov_id}/summary-indicator-four', [KatsinovController::class, 'summaryIndicatorfour'])->name('summary-indicator-four');
                Route::get('{katsinov_id}/summary-indicator-five', [KatsinovController::class, 'summaryIndicatorfive'])->name('summary-indicator-five');
                Route::get('{katsinov_id}/summary-indicator-six', [KatsinovController::class, 'summaryIndicatorsix'])->name('summary-indicator-six');
                Route::get('summary-all/{katsinov_id}', [KatsinovController::class, 'summaryAll'])->name('summary-all');


                Route::get('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiIndex'])->name('inovasi.index');
                Route::post('/form-inovasi/{katsinov_id?}', [KatsinovController::class, 'inovasiStore'])->name('inovasi.store');
                // Form Berita Acara with katsinov_id parameter
                Route::get('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaIndex'])->name('berita.index');
                Route::post('/berita-acara/{katsinov_id?}', [KatsinovController::class, 'beritaStore'])->name('berita.store');

                Route::get('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationIndex'])->name('informasi.index');
                Route::post('/informasi-dasar/{katsinov_id?}', [KatsinovController::class, 'informationStore'])->name('informasi.store');


                // Lampiran with katsinov_id parameter
                Route::get('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranIndex'])->name('lampiran.index');
                Route::post('/lampiran/{katsinov_id?}', [KatsinovController::class, 'lampiranStore'])->name('lampiran.store');

                //Form record hasil pengukuran
                Route::get('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordIndex'])->name('record.index');
                Route::post('/record-hasil/{katsinov_id?}', [KatsinovController::class, 'recordStore'])->name('record.store');
            });
    });
