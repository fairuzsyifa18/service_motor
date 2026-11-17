<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;

class PelangganDetailController extends Controller
{
    public function show($id)
    {
        $pelanggan = Pelanggan::with([
            'daftarServices.kendaraan',
            'daftarServices.dataServices.pembayaranServices',
        ])->findOrFail($id);

        return view('pelanggan.detail', compact('pelanggan'));
    }
}
