@extends('layouts.app')

@section('title', 'Daftar Service')
@section('heading', 'Daftar Service')

@section('content')

<div class="content-card">
    <h3 style="margin-bottom: 8px;">Tambah Daftar Service</h3>
    <p style="font-size: 13px; color: #8491A1; margin-bottom: 25px;">
        Masukkan informasi kendaraan yang akan melakukan service.
    </p>

    <form id="formDaftarService">

        <label>No Plat Kendaraan</label>
        <select id="id_kendaraan" required>
            <option value="">Pilih Nomor Plat Kendaraan</option>
        </select>

        <label>ID Pelanggan</label>
        <select id="id_pelanggan" required>
            <option value="">Pilih ID Pelanggan</option>
        </select>

        <label>Nama Pelanggan</label>
        <input type="text" id="nama_pelanggan"
            placeholder="Nama pelanggan otomatis terisi" readonly>

        <label>Keluhan Kendaraan</label>
        <textarea id="keluhan_kendaraan" rows="3"
            placeholder="Masukkan keluhan kendaraan" required></textarea>

        <label>Tanggal Service</label>
        <input type="date" id="tanggal_service" required>

        <button type="submit">Simpan Daftar Service</button>
    </form>
</div>

<div class="content-card" style="margin-top: 25px;">
    <h3>Daftar Kendaraan yang Akan Service</h3>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>ID Service</th>
                    <th>No Plat</th>
                    <th>ID Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>Keluhan</th>
                    <th>Tanggal Service</th>
                </tr>
            </thead>
            <tbody id="daftarService">
                <tr>
                    <td colspan="6" style="text-align:center; color:#8491A1;">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    const API_DAFTAR = '/api/daftar-service';
    const API_PILIHAN = '/api/daftar-service-pilihan';

    async function muatPilihan() {
        try {
            const response = await fetch(API_PILIHAN, {
                headers: { 'Accept': 'application/json' }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(hasil.message || 'Gagal mengambil pilihan');
            }

            const kendaraanSelect = document.getElementById('id_kendaraan');
            const pelangganSelect = document.getElementById('id_pelanggan');

            hasil.kendaraan.forEach(kendaraan => {
                kendaraanSelect.innerHTML += `
                    <option value="${kendaraan.id}">
                        ${kendaraan.no_plat_kendaraan}
                    </option>
                `;
            });

            hasil.pelanggan.forEach(pelanggan => {
                pelangganSelect.innerHTML += `
                    <option value="${pelanggan.id_pelanggan}">
                        ${pelanggan.id_pelanggan} - ${pelanggan.nama_lengkap}
                    </option>
                `;
            });

        } catch (error) {
            console.error(error);
            alert('Gagal memuat pilihan pelanggan dan kendaraan.');
        }
    }

    document.getElementById('id_pelanggan').addEventListener('change', async function() {
        const id = this.value;
        const namaInput = document.getElementById('nama_pelanggan');

        if (!id) {
            namaInput.value = '';
            return;
        }

        try {
            const response = await fetch(`/api/pelanggan/${id}`, {
                headers: { 'Accept': 'application/json' }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error('Pelanggan tidak ditemukan');
            }

            namaInput.value = hasil.data.nama_lengkap;

        } catch (error) {
            namaInput.value = '';
            alert('Gagal mengambil nama pelanggan.');
            console.error(error);
        }
    });

    async function tampilkanDaftarService() {
        const tabel = document.getElementById('daftarService');

        try {
            const response = await fetch(API_DAFTAR, {
                headers: { 'Accept': 'application/json' }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error('Gagal mengambil data service');
            }

            tabel.innerHTML = '';

            if (hasil.data.length === 0) {
                tabel.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align:center; color:#8491A1;">
                            Belum ada daftar service.
                        </td>
                    </tr>
                `;
                return;
            }

            hasil.data.forEach(item => {
                tabel.innerHTML += `
                    <tr>
                        <td>${item.id_daftar_service}</td>
                        <td>${item.kendaraan?.no_plat_kendaraan ?? '-'}</td>
                        <td>${item.id_pelanggan}</td>
                        <td>${item.pelanggan?.nama_lengkap ?? '-'}</td>
                        <td>${item.keluhan_kendaraan}</td>
                        <td>${item.tanggal_service}</td>
                    </tr>
                `;
            });

        } catch (error) {
            tabel.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align:center; color:#B45353;">
                        Gagal memuat daftar service.
                    </td>
                </tr>
            `;
            console.error(error);
        }
    }

    document.getElementById('formDaftarService').addEventListener('submit', async function(event) {
        event.preventDefault();

        const data = {
            id_kendaraan: document.getElementById('id_kendaraan').value,
            id_pelanggan: document.getElementById('id_pelanggan').value,
            keluhan_kendaraan: document.getElementById('keluhan_kendaraan').value,
            tanggal_service: document.getElementById('tanggal_service').value
        };

        try {
            const response = await fetch(API_DAFTAR, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const hasil = await response.json();

            if (!response.ok) {
                alert(hasil.message || JSON.stringify(hasil));
                return;
            }

            alert(hasil.message);
            this.reset();
            document.getElementById('nama_pelanggan').value = '';

            tampilkanDaftarService();

        } catch (error) {
            alert('Tidak dapat terhubung ke server.');
            console.error(error);
        }
    });

    muatPilihan();
    tampilkanDaftarService();
</script>

@endsection
