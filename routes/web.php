<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\PersonelController;
use App\Http\Controllers\PosisiController;
use App\Http\Controllers\PosisippeController;
use App\Http\Controllers\SatuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('kategori', KategoriController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('satuan', SatuanController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('barang', BarangController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('personel', PersonelController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('posisi', PosisiController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('posisippe', PosisippeController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('gudang', GudangController::class)->only(['index', 'store', 'update', 'destroy']);
});
