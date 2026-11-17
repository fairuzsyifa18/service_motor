<?php

namespace App\Http\Controllers;

use App\Models\DaftarService;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class DaftarServiceController extends Controller
{
    public function index()
    {
        $data = DaftarService::with([
            'pelanggan',
            'kendaraan'
        ])->get();

        return response()->json([
            'message' => 'Data daftar service berhasil ditampilkan',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kendaraan' => 'required|exists:kendaraans,id',
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'keluhan_kendaraan' => 'required|string',
            'tanggal_service' => 'required|date',
        ]);

        $data = DaftarService::create($validated);

        return response()->json([
            'message' => 'Data daftar service berhasil disimpan',
            'data' => $data
        ], 201);
    }

    public function show($id)
    {
        $data = DaftarService::with([
            'pelanggan',
            'kendaraan'
        ])->findOrFail($id);

        return response()->json([
            'message' => 'Detail daftar service berhasil ditampilkan',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = DaftarService::findOrFail($id);

        $validated = $request->validate([
            'id_kendaraan' => 'required|exists:kendaraans,id',
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'keluhan_kendaraan' => 'required|string',
            'tanggal_service' => 'required|date',
        ]);

        $data->update($validated);

        return response()->json([
            'message' => 'Data daftar service berhasil diperbarui',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = DaftarService::findOrFail($id);

        $data->delete();

        return response()->json([
            'message' => 'Data daftar service berhasil dihapus'
        ]);
    }

    public function pilihan()
    {
        return response()->json([
            'message' => 'Pilihan pelanggan dan kendaraan berhasil ditampilkan',
            'pelanggan' => Pelanggan::all(),
            'kendaraan' => Kendaraan::all()
        ]);
    }
}
