<?php

namespace App\Http\Controllers;

use App\Models\PembayaranService;
use App\Models\DataService;
use Illuminate\Http\Request;

class PembayaranServiceController extends Controller
{
    // Menampilkan semua data pembayaran
    public function index()
    {
        $pembayaran = PembayaranService::with(
            'dataService.daftarService.pelanggan'
        )->get();

        return response()->json([
            'message' => 'Data pembayaran berhasil ditampilkan',
            'data' => $pembayaran
        ], 200);
    }

    // Menambahkan pembayaran service
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_data_service' => 'required|exists:data_services,id_data_service',
            'jumlah_biaya_servis' => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash/Tunai,Non Tunai',
            'keterangan' => 'nullable|string',
        ]);

        $pembayaran = PembayaranService::create($validated);

        return response()->json([
            'message' => 'Pembayaran service berhasil ditambahkan',
            'data' => $pembayaran->load(
                'dataService.daftarService.pelanggan'
            )
        ], 201);
    }

    // Menampilkan satu data pembayaran
    public function show(string $id)
    {
        $pembayaran = PembayaranService::with(
            'dataService.daftarService.pelanggan'
        )->findOrFail($id);

        return response()->json([
            'message' => 'Data pembayaran berhasil ditemukan',
            'data' => $pembayaran
        ], 200);
    }

    // Memperbarui pembayaran service
    public function update(Request $request, string $id)
    {
        $pembayaran = PembayaranService::findOrFail($id);

        $validated = $request->validate([
            'id_data_service' => 'required|exists:data_services,id_data_service',
            'jumlah_biaya_servis' => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash/Tunai,Non Tunai',
            'keterangan' => 'nullable|string',
        ]);

        $pembayaran->update($validated);

        return response()->json([
            'message' => 'Pembayaran service berhasil diperbarui',
            'data' => $pembayaran->load(
                'dataService.daftarService.pelanggan'
            )
        ], 200);
    }

    // Menghapus pembayaran service
    public function destroy(string $id)
    {
        $pembayaran = PembayaranService::findOrFail($id);

        $pembayaran->delete();

        return response()->json([
            'message' => 'Pembayaran service berhasil dihapus'
        ], 200);
    }

    // Menampilkan pilihan data service untuk dropdown
    public function pilihan()
    {
        $dataService = DataService::with(
            'daftarService.pelanggan'
        )->get();

        return response()->json([
            'data' => $dataService
        ], 200);
    }
}