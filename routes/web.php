<?php

// illuminate lib
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\LacakPaketController;

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

// update
Route::prefix('update')->group(function() {
    Route::get('provinsi', [UpdateController::class, 'provinsi']);
    Route::get('kota', [UpdateController::class, 'kota']);
    Route::get('kecamatan', [UpdateController::class, 'kecamatan']);
    Route::get('internasional-origin', [UpdateController::class, 'internasional-origin']);
    Route::get('internasional-tujuan', [UpdateController::class, 'internasional-tujuan']);
});