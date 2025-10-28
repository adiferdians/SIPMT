<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RisalahController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RuangRapatController;
use App\Http\Controllers\UnitKerjaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/{path?}', [AuthController::class, 'index'])
    ->where('path', 'l051n|')
    ->name('login');
Route::post('/auth', [AuthController::class, 'auth']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [IndexController::class, 'index'])->name('dashboard');

    Route::get('/anggota', [AnggotaController::class, 'index']);
    Route::get('/createAnggota', [AnggotaController::class, 'createAnggota']);
    Route::post('/storeAnggota', [AnggotaController::class, 'store']);
    Route::post('/storeAnggota/{id}', [AnggotaController::class, 'store']);
    Route::post('/ubahStatustoreAnggota/{id}', [AnggotaController::class, 'ubahStatus']);
    Route::get('/viewAnggota/{id}', [AnggotaController::class, 'showAnggota']);
    Route::get('/editAnggota/{id}', [AnggotaController::class, 'editAnggota']);
    Route::post('deleteAnggota/{id}', [AnggotaController::class, 'destroyAnggota']);

    Route::get('/ubahPassword', [AnggotaController::class, 'ubahPassword']);
    Route::post('/kirimPassword', [AnggotaController::class, 'kirimPassword']);

    Route::get('/risalah', [RisalahController::class, 'index']);
    Route::post('/risalah/changeStatus/{id}', [RisalahController::class, 'changeStatus']);
    Route::get('/createRisalah', [RisalahController::class, 'createRisalah']);
    Route::post('/storeRisalah', [RisalahController::class, 'store']);
    Route::post('/storeRisalah/{id}', [RisalahController::class, 'store']);
    Route::get('/viewRisalah/{id}', [RisalahController::class, 'showRisalah']);
    Route::get('/editRisalah/{id}', [RisalahController::class, 'editRisalah']);
    Route::post('/deleteRisalah/{id}', [RisalahController::class, 'destroyRisalah']);
    Route::get('/exportRisalah', [RisalahController::class, 'export']);
    Route::post('/getExport', [RisalahController::class, 'exportExcel'])->name('risalah.export');

    Route::get('/ruang-rapat', [RuangRapatController::class, 'index']);
    Route::get('/create-ruang-rapat', [RuangRapatController::class, 'createRuangRapat']);
    Route::post('/store-ruang-rapat', [RuangRapatController::class, 'storeRuangRapat']);
    Route::get('/edit-ruang-rapat/{id}', [RuangRapatController::class, 'editRuangRapat']);
    Route::post('/delete-ruang-rapat/{id}', [RuangRapatController::class, 'destroyRuangRapat']);

    Route::get('/unit-kerja', [UnitKerjaController::class, 'index']);
    Route::get('/create-unit-kerja', [UnitKerjaController::class, 'createUnitKerja']);
    Route::post('/store-unit-kerja', [UnitKerjaController::class, 'storeUnitKerja']);
    Route::get('/edit-unit-kerja/{id}', [UnitKerjaController::class, 'editUnitKerja']);
    Route::post('/delete-unit-kerja/{id}', [UnitKerjaController::class, 'destroyUnitKerja']);
});
