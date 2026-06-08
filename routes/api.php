<?php

use App\Http\Controllers\Api\BarangApiController;
use App\Http\Controllers\Api\GudangApiController;
use App\Http\Controllers\Api\KategoriApiController;
use App\Http\Controllers\Api\PersonelApiController;
use App\Http\Controllers\Api\PosisiApiController;
use App\Http\Controllers\Api\SatuanApiController;
use Illuminate\Support\Facades\Route;

Route::get('/kategori', [KategoriApiController::class, 'index']);
Route::get('/satuan', [SatuanApiController::class, 'index']);
Route::get('/gudang', [GudangApiController::class, 'index']);
Route::get('/posisi', [PosisiApiController::class, 'index']);
Route::get('/barang-with-varian', [BarangApiController::class, 'withVarian']);
Route::get('/barang', [BarangApiController::class, 'index']);
Route::get('/posisi/{posisi}/ppe', [PosisiApiController::class, 'ppe']);
Route::apiResource('/personel', PersonelApiController::class);
