<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RisalahController;
use App\Http\Controllers\AnggotaController;

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
    Route::get('/risalah', [RisalahController::class, 'index']);
    Route::get('/anggota', [AnggotaController::class, 'index']);
    Route::get('/createAnggota', [AnggotaController::class, 'createAnggota']);
    Route::post('/storeAnggota', [AnggotaController::class, 'store']);
    Route::get('/viewAnggota/{id}', [AnggotaController::class, 'showAnggota']);
    Route::get('/editAnggota/{id}', [AnggotaController::class, 'editAnggota']);
    Route::post('deleteAnggota/{id}', [AnggotaController::class, 'destroyAnggota']);
