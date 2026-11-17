<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    // Menampilkan semua data kendaraan
    public function index()
    {
        $kendaraan = Kendaraan::all();

        return response()->json([
            'message' => 'Data kendaraan berhasil ditampilkan',
            'data' => $kendaraan
        ], 200);
    }

    // Menambahkan data kendaraan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_plat_kendaraan' => 'required|string|max:255|unique:kendaraans,no_plat_kendaraan',
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk' => 'required|string|max:255',
            'tahun_pembuatan' => 'required|integer|min:1900|max:2100',
            'nama_pemilik' => 'required|string|max:255',
            'warna_kendaraan' => 'required|string|max:255',
        ]);

        $kendaraan = Kendaraan::create($validated);

        return response()->json([
            'message' => 'Data kendaraan berhasil ditambahkan',
            'data' => $kendaraan
        ], 201);
    }

    // Menampilkan satu data kendaraan
    public function show(string $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        return response()->json([
            'message' => 'Data kendaraan berhasil ditemukan',
            'data' => $kendaraan
        ], 200);
    }

    // Memperbarui data kendaraan
    public function update(Request $request, string $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $validated = $request->validate([
            'no_plat_kendaraan' => 'required|string|max:255|unique:kendaraans,no_plat_kendaraan,' . $kendaraan->id,
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk' => 'required|string|max:255',
            'tahun_pembuatan' => 'required|integer|min:1900|max:2100',
            'nama_pemilik' => 'required|string|max:255',
            'warna_kendaraan' => 'required|string|max:255',
        ]);

        $kendaraan->update($validated);

        return response()->json([
            'message' => 'Data kendaraan berhasil diperbarui',
            'data' => $kendaraan
        ], 200);
    }

    // Menghapus data kendaraan
    public function destroy(string $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $kendaraan->delete();

        return response()->json([
            'message' => 'Data kendaraan berhasil dihapus'
        ], 200);
    }
}
