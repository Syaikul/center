<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\PersonelController;
use App\Http\Controllers\PosisiController;
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
    Route::post('barang/{barang}/sub-barang', [BarangController::class, 'storeSubBarang'])->name('barang.sub.store');
    Route::put('barang/{barang}/sub-barang/{barang_sub}', [BarangController::class, 'updateSubBarang'])->name('barang.sub.update');
    Route::delete('barang/{barang}/sub-barang/{barang_sub}', [BarangController::class, 'destroySubBarang'])->name('barang.sub.destroy');
    Route::post('barang/{barang}/sub-barang/{barang_sub}/varian', [BarangController::class, 'storeVarian'])->name('barang.varian.store');
    Route::put('barang/{barang}/sub-barang/{barang_sub}/varian/{barang_varian}', [BarangController::class, 'updateVarian'])->name('barang.varian.update');
    Route::delete('barang/{barang}/sub-barang/{barang_sub}/varian/{barang_varian}', [BarangController::class, 'destroyVarian'])->name('barang.varian.destroy');

    Route::resource('personel', PersonelController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('posisi', PosisiController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::post('posisi/{posisi}/item', [PosisiController::class, 'storeItem'])->name('posisi.item.store');
    Route::put('posisi/{posisi}/item/{posisippe}', [PosisiController::class, 'updateItem'])->name('posisi.item.update');
    Route::delete('posisi/{posisi}/item/{posisippe}', [PosisiController::class, 'destroyItem'])->name('posisi.item.destroy');

    Route::redirect('/barang-varian', '/barang')->name('barang-varian.index');
    Route::redirect('/posisippe', '/posisi')->name('posisippe.index');
    Route::resource('gudang', GudangController::class)->only(['index', 'store', 'update', 'destroy']);
});
