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
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\FormInformasiDasarController;
use App\Http\Controllers\FormRecordHasilPengukuranController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProgramLayananController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\InstagramController;
use Illuminate\Http\Request;
// Ganti route yang ada dengan:
use App\Http\Controllers\DokumenController;



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

        Route::resource('/news-scroll', PengumumanController::class);

        Route::resource('/program-layanan', ProgramLayananController::class);

        //Youtube
        Route::resource('/youtube', YoutubeController::class)
            ->except(['show', 'edit', 'update']);

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

        Route::resource('/responden', AdminRespondenController::class);
        Route::put('/responden/{responden}', [AdminRespondenController::class, 'update'])
            ->name('responden.update');

        // Untuk update status khusus (POST)
        Route::post('/responden/update-status/{id}', [AdminRespondenController::class, 'updateStatus'])
            ->name('responden.updateStatus');

        Route::put('/manageuser/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('manageuser.toggleStatus');
        Route::resource('/manageuser', UserController::class);

        Route::resource('/sustainability', AdminSustainabilityController::class);

        Route::get('/matakuliah', [AdminMataKuliahController::class, 'index'])->name('matakuliah.index');
        Route::post('/matakuliah', [AdminMataKuliahController::class, 'store'])->name('matakuliah.store');

        Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
        Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');

        Route::get('/qstable', function () {
            return view('admin.qstable');
        })->name('qstable');


        Route::get('/qsgeneraltable', [QuesionerGeneralController::class, 'index'])->name('qsgeneraltable');

        Route::resource('/qsresponden', RespondenAnswerController::class)->except(['create', 'store']);

        // mahasiswa
        Route::resource('/mahasiswainternational', InternationalStudentController::class);

        Route::resource('/dataakreditasi', AkreditasiController::class);

        Route::resource('/internationallecture', DosenInternasionalController::class);


        Route::prefix('Katsinov')->name('Katsinov.')
            ->group(function () {
                Route::get('/TableKatsinov', [KatsinovController::class, 'index'])->name('TableKatsinov');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::get('/show/{id}', [KatsinovController::class, 'show'])->name('show');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');
                Route::get('/katsinov/latest', [KatsinovController::class, 'latest']);


                // Route::resource('/forminformasidasar', FormInformasiDasarController::class);
                // Route::post('/admin/Katsinov/forminformasidasar', [FormInformasiDasarController::class, 'store'])
                //     ->name('admin.Katsinov.forminformasidasar.store');
                // Route::get('/formberitaacara', function () {
                //     return view('admin.katsinov.formberitaacara');
                // })->name('formberitaacara');

                // Route::resource('/formberitaacara', BeritaAcaraController::class);

                // Route::get('/formrecordhasilpengukuran', function () {
                //     return view('admin.katsinov.formrecordhasilpengukuran');
                // })->name('formrecordhasilpengukuran');
                // Route::resource('/formrecordhasilpengukuran', FormRecordHasilPengukuranController::class);

                // Route::get('/formjudul', function () {
                //     return view('admin.katsinov.formjudul');
                // })->name('formjudul');

                // Form Judul with katsinov_id parameter
                Route::get('/formjudul/{katsinov_id?}', function (Request $request, $katsinov_id = null) {
                    $katsinov = null;
                    if ($katsinov_id) {
                        $katsinov = \App\Models\Katsinov::find($katsinov_id);
                        if (!$katsinov) {
                            return redirect()->back()->with('error', 'Katsinov data not found');
                        }
                    }
                    return view('admin.katsinov.formjudul', compact('katsinov'));
                })->name('formjudul');

                // Form Record Hasil Pengukuran with katsinov_id parameter
                Route::get('/formrecordhasilpengukuran/{katsinov_id?}', function (Request $request, $katsinov_id = null) {
                    $katsinov = null;
                    if ($katsinov_id) {
                        $katsinov = \App\Models\Katsinov::find($katsinov_id);
                        if (!$katsinov) {
                            return redirect()->back()->with('error', 'Katsinov data not found');
                        }
                    }
                    return view('admin.katsinov.formrecordhasilpengukuran', compact('katsinov'));
                })->name('formrecordhasilpengukuran');

                // Form Berita Acara with katsinov_id parameter
                Route::get('/formberitaacara/{katsinov_id?}', function (Request $request, $katsinov_id = null) {
                    $katsinov = null;
                    if ($katsinov_id) {
                        $katsinov = \App\Models\Katsinov::find($katsinov_id);
                        if (!$katsinov) {
                            return redirect()->back()->with('error', 'Katsinov data not found');
                        }
                    }
                    return view('admin.katsinov.formberitaacara', compact('katsinov'));
                })->name('formberitaacara');

                // Form Informasi Dasar with katsinov_id parameter
                Route::get('/forminformasidasar/{katsinov_id?}', function (Request $request, $katsinov_id = null) {
                    $katsinov = null;
                    if ($katsinov_id) {
                        $katsinov = \App\Models\Katsinov::find($katsinov_id);
                        if (!$katsinov) {
                            return redirect()->back()->with('error', 'Katsinov data not found');
                        }
                    }
                    return view('admin.katsinov.forminformasidasar', compact('katsinov'));
                })->name('forminformasidasar');

                // Lampiran with katsinov_id parameter
                Route::get('/lampiran/{katsinov_id?}', function (Request $request, $katsinov_id = null) {
                    $katsinov = null;
                    if ($katsinov_id) {
                        $katsinov = \App\Models\Katsinov::find($katsinov_id);
                        if (!$katsinov) {
                            return redirect()->back()->with('error', 'Katsinov data not found');
                        }
                    }
                    return view('admin.katsinov.lampiran', compact('katsinov'));
                })->name('lampiran');
            });

        Route::prefix('SDGs')->name('SDGs.')
            ->group(function () {

                // Program Kegiatan
                Route::get('/program_kegiatan', function () {
                    return view('admin.SDGs.program_kegiatan');
                })->name('program_kegiatan');

                // Program Kegiatan
                Route::get('/publikasi_riset', function () {
                    return view('admin.SDGs.publikasi_riset');
                })->name('publikasi_riset');
            });
    });

Route::prefix('prodi')->name('prodi.')
    ->middleware(['checked', 'role:prodi'])
    ->group(function () {
        // Dashboard
        Route::get('/', function () {
            return redirect(route('prodi.dashboard'));
        });

        Route::get('/dashboard', function () {
            return view('prodi.dashboard');
        })->name('dashboard');
        Route::resource('/sustainability', AdminSustainabilityController::class);

        //Mata Kuliah
        // Route::get('/matakuliah-sustainability', function () {
        //     return view('admin.matakuliahsustainability');
        // })->name('matakuliah-sustainability');

        Route::get('/matakuliah', [AdminMataKuliahController::class, 'index'])->name('matakuliah.index');
        Route::post('/matakuliah', [AdminMataKuliahController::class, 'store'])->name('matakuliah.store');
        //Alumni
        Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
        Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');

        //responden
        Route::resource('/qsresponden', RespondenAnswerController::class)->except(['create', 'store']);
    });

Route::prefix('fakultas')->name('fakultas.')
    ->middleware(['checked', 'role:fakultas'])
    ->group(function () {
        Route::get('/', function () {
            return redirect(route('fakultas.dashboard'));
        });

        // Dashboard
        Route::get('/dashboard', function () {
            return view('fakultas.dashboard');
        })->name('dashboard');

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

Route::prefix('admin-pemeringkatan')->name('admin_pemeringkatan.')
    ->middleware(['checked', 'role:admin_pemeringkatan'])
    ->group(function () {
        Route::get('/', function () {
            return redirect(route('admin_pemeringkatan.dashboard'));
        });
        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin_pemeringkatan.dashboard');
        })->name('dashboard');


        Route::get('/manage-user', function () {
            return view('admin_pemeringkatan.manageuser');
        })->name('manageuser');

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

Route::prefix('inovasi')->name('inovasi.')
    ->group(function () {
        Route::prefix('dosen')->name('dosen.')
            ->middleware(['checked', 'role:dosen'])
            ->group(function () {
                // Dashboard
                Route::get('/dashboard', function () {
                    return view('Inovasi.dosen.dashboard');
                })->name('dashboard');

                // Tabel Katsinov
                Route::get('/tablekatsinov', [KatsinovController::class, 'index'])->name('tablekasitnov');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');

                Route::resource('/forminformasidasar', FormInformasiDasarController::class);
                Route::post('/Inovasi/dosen/forminformasidasar', [FormInformasiDasarController::class, 'store'])
                    ->name('Inovasi.dosen.forminformasidasar.store');

                Route::resource('/formberitaacara', BeritaAcaraController::class);

                Route::get('/formjudul', function () {
                    return view('Inovasi.dosen.formjudul');
                })->name('formjudul');

                Route::resource('/formrecordhasilpengukuran', FormRecordHasilPengukuranController::class);
            });


        // Admin Hilirisasi routes
        Route::prefix('admin_hilirisasi')->name('admin_hilirisasi.')
            ->middleware(['checked', 'role:admin_hilirisasi'])
            ->group(function () {
                // Dashboard
                Route::get('/dashboard', function () {
                    return view('Inovasi.admin_hilirisasi.dashboard');
                })->name('dashboard');

                // Tabel Katsinov
                Route::get('/TableKatsinov', [KatsinovController::class, 'index'])->name('TableKatsinov');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');

                // Form Informasi Dasar
                Route::resource('/forminformasidasar', FormInformasiDasarController::class);
                Route::post('/forminformasidasar/store', [FormInformasiDasarController::class, 'store'])
                    ->name('forminformasidasar.store');

                // Form Berita Acara
                Route::resource('/formberitaacara', BeritaAcaraController::class);

                // Form Judul
                Route::get('/formjudul', function () {
                    return view('Inovasi.admin_hilirisasi.formjudul');
                })->name('formjudul');

                // Form Record Hasil Pengukuran
                Route::resource('/formrecordhasilpengukuran', FormRecordHasilPengukuranController::class);

                // SDGs routes
                Route::prefix('SDGs')->name('SDGs.')
                    ->group(function () {
                        // Program Kegiatan
                        Route::get('/program_kegiatan', function () {
                            return view('Inovasi.admin_hilirisasi.SDGs.program_kegiatan');
                        })->name('program_kegiatan');

                        // Publikasi Riset
                        Route::get('/publikasi_riset', function () {
                            return view('Inovasi.admin_hilirisasi.SDGs.publikasi_riset');
                        })->name('publikasi_riset');
                    });
            });

        // Validator
        Route::prefix('validator')->name('validator.')
            ->middleware(['checked', 'role:validator'])
            ->group(function () {
                Route::get('/dashboard', function () {
                    return view('Inovasi.validator.dashboard');
                })->name('dashboard');

                // Tabel Katsinov
                Route::get('/tablekasitnov', [KatsinovController::class, 'index'])->name('tablekasitnov');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');

                Route::resource('/forminformasidasar', FormInformasiDasarController::class);
                Route::post('/Inovasi/validator/forminformasidasar', [FormInformasiDasarController::class, 'store'])
                    ->name('inovasi.validator.forminformasidasar.store');

                Route::resource('/formberitaacara', BeritaAcaraController::class);

                Route::get('/formjudul', function () {
                    return view('Inovasi.validator.formjudul');
                })->name('formjudul');

                Route::resource('/formrecordhasilpengukuran', FormRecordHasilPengukuranController::class);


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
                    return view('Inovasi.registered_user.dashboard');
                })->name('dashboard');

                // You can add more routes for registered users here as needed
                Route::get('/profile', function () {
                    return view('Inovasi.registered_user.profile');
                })->name('profile');

                // Tabel Katsinov
                Route::get('/TableKatsinov', [KatsinovController::class, 'index'])->name('TableKatsinov');
                Route::get('/form', [KatsinovController::class, 'create'])->name('form');
                Route::post('/store', [KatsinovController::class, 'store'])->name('store');
                Route::get('/download-pdf', [KatsinovController::class, 'downloadPDF'])->name('download-pdf');

                Route::resource('/forminformasidasar', FormInformasiDasarController::class);
                Route::post('/forminformasidasar', [FormInformasiDasarController::class, 'store'])
                    ->name('forminformasidasar.store');

                Route::resource('/formberitaacara', BeritaAcaraController::class);

                Route::get('/formjudul', function () {
                    return view('Inovasi.registered_user.formjudul');
                })->name('formjudul');

                Route::resource('/formrecordhasilpengukuran', FormRecordHasilPengukuranController::class);
            });



        Route::prefix('admin_hilirisasi')->name('admin_hilirisasi.')
            ->middleware(['checked', 'role:admin_hilirisasi'])
            ->group(function () {
                // Dashboard
                Route::get('/dashboard', function () {
                    return view('Inovasi.admin_hilirisasi.dashboard');
                })->name('dashboard');

                // Tabel Katsinov
                Route::get('/tablekatsinov', [KatsinovController::class, 'index'])->name('tablekasitnov');
            });
    });
