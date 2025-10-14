<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RisalahController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\RuangRapatController;

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

Route::get('/', [IndexController::class, 'index']);
Route::get('/anggota', [AnggotaController::class, 'index']);
Route::get('/createAnggota', [AnggotaController::class, 'createAnggota']);
Route::post('/storeAnggota', [AnggotaController::class, 'store']);
Route::post('/storeAnggota/{id}', [AnggotaController::class, 'store']);
Route::get('/viewAnggota/{id}', [AnggotaController::class, 'showAnggota']);
Route::get('/editAnggota/{id}', [AnggotaController::class, 'editAnggota']);
Route::post('deleteAnggota/{id}', [AnggotaController::class, 'destroyAnggota']);

Route::get('/risalah', [RisalahController::class, 'index']);
Route::post('/risalah/changeStatus/{id}', [RisalahController::class, 'changeStatus']);
Route::get('/createRisalah', [RisalahController::class, 'createRisalah']);
Route::post('/storeRisalah', [RisalahController::class, 'store']);
Route::post('/storeRisalah/{id}', [RisalahController::class, 'store']);
Route::get('/viewRisalah/{id}', [RisalahController::class, 'showRisalah']);
Route::get('/editRisalah/{id}', [RisalahController::class, 'editRisalah']);
Route::post('/deleteRisalah/{id}', [RisalahController::class, 'destroyRisalah']);

Route::get('/ruang-rapat', [RuangRapatController::class, 'index']);
Route::get('/create-ruang-rapat', [RuangRapatController::class, 'createRuangRapat']);
Route::post('/store-ruang-rapat', [RuangRapatController::class, 'storeRuangRapat']);
// Route::post('/store-ruang-rapat/{id}', [RuangRapatController::class, 'storeRuangRapat']);
Route::get('/edit-ruang-rapat/{id}', [RuangRapatController::class, 'editRuangRapat']);
Route::post('/delete-ruang-rapat/{id}', [RuangRapatController::class, 'destroyRuangRapat']);