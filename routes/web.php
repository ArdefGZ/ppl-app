<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropDownController;

Route::view('/', 'login');

Route::post('/login', [WebController::class, 'login']);

Route::prefix('/dashboard')->group(function () {
    Route::get('/mahasiswa/{nim}', [WebController::class, 'masukMahasiswa']);
    Route::get('/dosen/{nip}', [WebController::class, 'masukKaryawan']);
    Route::get('/operator/{nip}', [WebController::class, 'masukKaryawan']);
    Route::get('/departemen/{ID_dep}', [WebController::class, 'masukDepartemen']);
    Route::get('/departemen/{ID_dep}/recap', [WebController::class,'recapDepartemen']);
    Route::prefix('/operator/{nip}')->group(function () {
        Route::get('/profile', [WebController::class, 'profileOperator']);
        Route::get('/manajemen', [WebController::class, 'getMahasiswa']);
        Route::get('/manajemen/addaccount', [WebController::class, 'addAccount']);
        Route::get('/manajemen/{nim}', [WebController::class, 'detailMahasiswa']);
        Route::get('/recap', [WebController::class, 'recapOperator']);
        Route::get('/recap/{angkatan}/{jenis}/{status}', [WebController::class, 'listRecap']);
        Route::get('/recap/{angkatan}/status/{status}/i', [WebController::class, 'listStatus']);
    });
});

Route::get('/register', [WebController::class, 'register']);
Route::post('api/fetch-kotakab', [DropDownController::class, 'fatchState']);
Route::post('/register/add', [WebController::class, 'addMahasiswa']);

Route::prefix('/dashboard/mahasiswa/{nim}')->group(function () {
    Route::get('/progress', [WebController::class, 'viewProgressMHS']);
    Route::get('/profile', [WebController::class, 'profile']);
    Route::post('/profile/edit', [WebController::class, 'editStudent']);
    Route::get('/academic', [WebController::class, 'akademik']);
    Route::get('/academic/addIRS', [WebController::class, 'addIRS']);
    Route::post('/academic/addIRS/confirm', [WebController::class, 'confirmAddIRS']);
    Route::get('/academic/addKHS', [WebController::class, 'addKHS']);
    Route::post('/academic/addKHS/confirm', [WebController::class, 'confirmAddKHS']);
    Route::get('/academic/addPKL', [WebController::class, 'addPKL']);
    Route::post('/academic/addPKL/confirm', [WebController::class, 'confirmAddPKL']);
    Route::get('/academic/pkl', [WebController::class, 'addPKL']);
    Route::get('/academic/skripsi', [WebController::class, 'addSkripsi']);
    Route::post('/academic/pkl/edit', [WebController::class, 'editPKL']);
    Route::post('/academic/skripsi/edit', [WebController::class, 'editSkripsi']);
    Route::get('/academic/addSkripsi', [WebController::class, 'addSkripsi']);
    Route::post('/academic/addSkripsi/confirm', [WebController::class, 'confirmAddSkripsi']);
    Route::get('/academic/khs/{id_khs}', [WebController::class, 'editKHS']);
    Route::get('/academic/irs/{id_irs}', [WebController::class, 'editIRS']);
    ROute::post('/academic/irs/{id_irs}/confirm', [WebController::class, 'confirmEditIRS']);
});

Route::prefix('/dashboard/dosen/{nip}')->group(function () {
    Route::get('/profile', [WebController::class, 'profileDos']);
    Route::get('/recap', [WebController::class, 'recapDosen']);
    Route::get('/validation', [WebController::class, 'validasi']);
    Route::post('/validation/irs/{id_irs}', [WebController::class, 'validasiIRS']);
    Route::post('/validation/khs/{id_khs}', [WebController::class, 'validasiKHS']);
    Route::post('/validation/pkl/{nim}', [WebController::class, 'validasiPKL']);
    Route::post('/validation/skripsi/{nim}', [WebController::class, 'validasiSkripsi']);
    Route::post('/validation/pkl/{nim}/tolak', [WebController::class, 'tolakPKL']);
    Route::post('/validation/skripsi/{nim}/tolak', [WebController::class, 'tolakSkripsi']);
    Route::get('/progress', [WebController::class, 'progress']);
    Route::get('/progress/search', [WebController::class, 'search'])->name('search');
    Route::get('/progress/{nim}', [WebController::class, 'progressMahasiswa']);
});

Route::prefix('/dashboard/departemen/{ID_dep}')->group(function () {
    Route::get('/profile', [WebController::class, 'profileDep']);
    Route::get('/progress', [WebController::class, 'progressDep']);
    Route::get('/progress/{nim}', [WebController::class, 'detailProgressDep']);
    Route::get('/recap/{angkatan}/{jenis}/{status}', [WebController::class, 'listRecapDepartemen']);
    Route::get('/recap/{angkatan}/{jenis}/{status}/s', [WebController::class, 'listRecapSkripsiDep']);
    Route::get('/recap/{angkatan}/status/{status}/i', [WebController::class, 'listStatus']);
});

Route::post('/addAccount', [WebController::class, 'confirmAddAccount']);
Route::get('/dashboard/mahasiswa/{nim}/updateAcc', [WebController::class, 'updatePage']);
Route::post('/dashboard/mahasiswa/{nim}/updateAcc/confirm', [WebController::class, 'updateAcc']);