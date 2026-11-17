<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganDetailController;

// Halaman utama
Route::get('/', function () {
    return redirect('/pelanggan');
});

// Menu Data Pelanggan
Route::view('/pelanggan', 'pelanggan.index');

// Halaman Detail Pelanggan
Route::get('/pelanggan/{id}/detail', [PelangganDetailController::class, 'show']);

// Menu Data Kendaraan
Route::view('/kendaraan', 'kendaraan.index');

// Menu Daftar Service
Route::view('/daftar-service', 'daftar_service.index');

// Menu Data Service
Route::view('/data-service', 'data_service.index');

// Menu Pembayaran Service
Route::view('/pembayaran-service', 'pembayaran_service.index');
