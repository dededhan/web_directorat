<?php

use App\Http\Controllers\AdminSustainabilityController;
use App\Http\Controllers\AdminRespondenController;
use App\Http\Controllers\QuesionerGeneralController;
use App\Http\Controllers\AdminAlumniBerdampakController;
use App\Http\Controllers\AdminMataKuliahController;
use App\Http\Controllers\RespondenAnswerController;
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

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboardadmin');
    })->name('dashboard');
    
    // News
    Route::get('/news', function () {
        return view('admin.newsadmin');
    })->name('news');

    
    Route::resource('/responden', AdminRespondenController::class);
    Route::put('/responden/{responden}', [AdminRespondenController::class, 'update'])
    ->name('responden.update');

// Untuk update status khusus (POST)
    Route::post('/responden/update-status/{id}', [AdminRespondenController::class, 'updateStatus'])
        ->name('responden.updateStatus');

    // Route::post('/responden/{responden}', AdminMailSendController::class)->name('mail.responden');
    
    Route::get('/manage-user', function () {
        return view('admin.manageuser');
    })->name('manageuser');

    
    
    Route::resource('/sustainability', AdminSustainabilityController::class);
    
    
    // Route::get('/sustainability', function () {
    //     return view('admin.sustainability');
    // })->name('sustainability');

    Route::get('/matakuliah', [AdminMataKuliahController::class, 'index'])->name('matakuliah.index');
    Route::post('/matakuliah', [AdminMataKuliahController::class, 'store'])->name('matakuliah.store');
    // Route::get('/matakuliah-sustainability', function () {
    //     return view('admin.matakuliahsustainability');
    // })->name('matakuliah-sustainability');

    Route::get('/alumniberdampak', [AdminAlumniBerdampakController::class, 'index'])->name('alumniberdampak.index');
    Route::post('/alumniberdampak', [AdminAlumniBerdampakController::class, 'store'])->name('alumniberdampak.store');

    // Route::get('/alumniberdampak', function () {
    //     return view('admin.alumniberdampak');
    // })->name('alumniberdampak');

    // Route::resource('/qstable', QuesionerGeneralController::class)->except(['create', 'store']);
    Route::get('/qstable', function () {
        return view('admin.qstable');
    })->name('qstable');

    
    Route::get('/qsgeneraltable', [QuesionerGeneralController::class, 'index'])->name('qsgeneraltable');

    Route::resource('/qsresponden', RespondenAnswerController::class)->except(['create', 'store']);
});

// Route::resource('/qsranking/qs-general', QuesionerGeneralController::class)->only(['create', 'store']);
// Route::put('/responden/{id}', [AdminRespondenController::class, 'update']);

Route::prefix('qsranking')->group(function(){
    Route::get('/qs-general', [QuesionerGeneralController::class, 'create'])->name('qs_general.index');
    Route::post('/qs-general', [QuesionerGeneralController::class, 'store'])->name('qs_general.store');

    // controller hijack :v
    Route::get('/qs-employee', [RespondenAnswerController::class, 'create'])->name('qs-employee.index')->middleware(HandleRespondenForm::class);
    Route::post('/qs-employee', [RespondenAnswerController::class, 'store'])->name('qs-employee.store')->middleware(HandleRespondenForm::class);
    Route::get('/qs-academic', [RespondenAnswerController::class, 'create'])->name('qs-academic.index')->middleware(HandleRespondenForm::class);
    Route::post('/qs-academic', [RespondenAnswerController::class, 'store'])->name('qs-academic.store')->middleware(HandleRespondenForm::class);
});
// Route::get('/qsrangking/qs_general', [QuesionerGeneralController::class, 'create'])->name('qs_general');
// Route::post('/qsrangking/qs_general', [QuesionerGeneralController::class, 'store'])->name('qs_general.store');


// Route::get('/qsrangking/qs_academic', function () {
//     return view('qsrangking.qs_academic');
// })->name('qs_academic');

// Route::get('/qsrangking/qs_employee', function () {
//     return view('qsrangking.qs_employee');
// })->name('qs_employee');


// Route::get('/qsrangking/qs_general', function () {
//     return view('qsrangking.qs_general');
// })->name('qs_general');

Route::get('/tupoksi', function () {
    return view('tupoksi.tupoksi');
})->name('tupoksi.tupoksi');


Route::get('/galeri/sustainability', function () {
    return view('galeri.sustainability');
})->name('galeri.sustainability'); 

Route::get('/galeri/alumni', function () {
    return view('galeri.alumni');
})->name('alumni');

Route::get('/Kasinov/form', function () {
    return view('Inovasi.Kasinov.form');
})->name('form');

Route::get('/pemeringkatan/landingpage', function () {
    return view('pemeringkatan.landingpagepemeringkatan');
})->name('pemeringkatan.landingpage');

Route::get('/inovasi/landingpage', function () {
    return view('inovasi.landingpagehilirisasi');
})->name('inovasi.landingpage');

