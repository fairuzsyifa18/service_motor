<?php

namespace App\Http\Controllers;

use App\Models\DataService;
use App\Models\DaftarService;
use Illuminate\Http\Request;

class DataServiceController extends Controller
{
    public function index()
    {
        $data = DataService::with('daftarService')->get();

        return response()->json([
            'message' => 'Data service berhasil ditampilkan',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_daftar_service' => 'required|exists:daftar_services,id_daftar_service',
            'estimasi_service' => 'required|string',
            'nama_mekanik' => 'required|string',
            'sparepart_pengganti' => 'required|string',
        ]);

        $data = DataService::create($validated);

        return response()->json([
            'message' => 'Data service berhasil disimpan',
            'data' => $data
        ], 201);
    }

    public function show($id)
    {
        $data = DataService::with('daftarService')->findOrFail($id);

        return response()->json([
            'message' => 'Detail data service berhasil ditampilkan',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = DataService::findOrFail($id);

        $validated = $request->validate([
            'id_daftar_service' => 'required|exists:daftar_services,id_daftar_service',
            'estimasi_service' => 'required|string',
            'nama_mekanik' => 'required|string',
            'sparepart_pengganti' => 'required|string',
        ]);

        $data->update($validated);

        return response()->json([
            'message' => 'Data service berhasil diperbarui',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = DataService::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Data service berhasil dihapus'
        ]);
    }

    public function pilihan()
    {
        return response()->json([
            'message' => 'Pilihan daftar service berhasil ditampilkan',
            'data' => DaftarService::with([
                'pelanggan',
                'kendaraan'
            ])->get()
        ]);
    }
}