<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\DaftarServiceController;
use App\Http\Controllers\DataServiceController;
use App\Http\Controllers\PembayaranServiceController;

Route::apiResource('pelanggan', PelangganController::class);
Route::apiResource('kendaraan', KendaraanController::class);

Route::apiResource('daftar-service', DaftarServiceController::class);
Route::get('daftar-service-pilihan', [DaftarServiceController::class, 'pilihan']);

Route::apiResource('data-service', DataServiceController::class);
Route::get('data-service-pilihan', [DataServiceController::class, 'pilihan']);

Route::apiResource('pembayaran-service', PembayaranServiceController::class);
Route::get('pembayaran-service-pilihan', [PembayaranServiceController::class, 'pilihan']);