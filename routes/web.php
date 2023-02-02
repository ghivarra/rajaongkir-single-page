<?php

// illuminate lib
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\CekOngkirController;
use App\Http\Controllers\LacakPaketController;
use App\Http\Controllers\Get\KurirController;
use App\Http\Controllers\Get\LokasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

// lacak paket xhr
Route::post('lacak-paket', [LacakPaketController::class, 'index']);

// cek ongkir xhr
Route::prefix('cek-ongkir')->group(function() {
    Route::post('lokal', [CekOngkirController::class, 'lokal']);
    Route::post('internasional', [CekOngkirController::class, 'internasional']);
});

// update
Route::prefix('update')->group(function() {
    Route::get('provinsi', [UpdateController::class, 'provinsi']);
    Route::get('kota', [UpdateController::class, 'kota']);
    Route::get('kecamatan', [UpdateController::class, 'kecamatan']);
    Route::get('internasional-asal', [UpdateController::class, 'internasionalOrigin']);
    Route::get('internasional-tujuan', [UpdateController::class, 'internasionalDestination']);
});

// get xhr
Route::prefix('get')->group(function() {

    Route::prefix('kurir')->group(function() {
        Route::get('lokal', [KurirController::class, 'lokal']);
        Route::get('internasional', [KurirController::class, 'internasional']);
    });

    Route::prefix('lokasi')->group(function() {
        Route::get('asal', [LokasiController::class, 'origin']);
        Route::get('tujuan', [LokasiController::class, 'destination']);
    });

});