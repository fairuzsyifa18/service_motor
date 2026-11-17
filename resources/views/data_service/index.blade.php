@extends('layouts.app')

@section('title', 'Data Service')
@section('heading', 'Data Service')

@section('content')

<div class="content-card">
    <h3 style="margin-bottom: 8px;">Tambah Data Service</h3>
    <p style="font-size: 13px; color: #8491A1; margin-bottom: 25px;">
        Masukkan informasi pengerjaan service kendaraan.
    </p>

    <form id="formDataService">

        <label>ID Service Pelanggan</label>
        <select id="id_daftar_service" required>
            <option value="">Pilih ID Service</option>
        </select>

        <label>Keluhan Kendaraan</label>
        <textarea id="keluhan_kendaraan" rows="3"
            placeholder="Keluhan otomatis terisi" readonly></textarea>

        <label>Estimasi Service</label>
        <input type="text" id="estimasi_service"
            placeholder="Contoh: 2 jam" required>

        <label>Nama Mekanik</label>
        <input type="text" id="nama_mekanik"
            placeholder="Masukkan nama mekanik" required>

        <label>Sparepart Pengganti</label>
        <textarea id="sparepart_pengganti" rows="3"
            placeholder="Masukkan sparepart yang diganti" required></textarea>

        <button type="submit">Simpan Data Service</button>

    </form>
</div>

<div class="content-card" style="margin-top: 25px;">
    <h3>Daftar Data Service</h3>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>ID Data Service</th>
                    <th>ID Service Pelanggan</th>
                    <th>Keluhan Kendaraan</th>
                    <th>Estimasi Service</th>
                    <th>Nama Mekanik</th>
                    <th>Sparepart Pengganti</th>
                </tr>
            </thead>

            <tbody id="daftarDataService">
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
    const API_DATA_SERVICE = '/api/data-service';
    const API_PILIHAN_SERVICE = '/api/data-service-pilihan';

    async function muatPilihanService() {
        try {
            const response = await fetch(API_PILIHAN_SERVICE, {
                headers: { 'Accept': 'application/json' }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error('Gagal mengambil pilihan service');
            }

            const select = document.getElementById('id_daftar_service');

            hasil.data.forEach(item => {
                select.innerHTML += `
                    <option value="${item.id_daftar_service}">
                        ${item.id_daftar_service} - ${item.pelanggan?.nama_lengkap ?? 'Pelanggan'}
                    </option>
                `;
            });

        } catch (error) {
            console.error(error);
            alert('Gagal memuat pilihan ID service.');
        }
    }

    document.getElementById('id_daftar_service').addEventListener('change', async function() {
        const id = this.value;
        const keluhan = document.getElementById('keluhan_kendaraan');

        if (!id) {
            keluhan.value = '';
            return;
        }

        try {
            const response = await fetch(`/api/daftar-service/${id}`, {
                headers: { 'Accept': 'application/json' }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error('Data service tidak ditemukan');
            }

            keluhan.value = hasil.data.keluhan_kendaraan;

        } catch (error) {
            keluhan.value = '';
            alert('Gagal mengambil keluhan kendaraan.');
            console.error(error);
        }
    });

    async function tampilkanDataService() {
        const tabel = document.getElementById('daftarDataService');

        try {
            const response = await fetch(API_DATA_SERVICE, {
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
                            Belum ada data service.
                        </td>
                    </tr>
                `;
                return;
            }

            hasil.data.forEach(item => {
                tabel.innerHTML += `
                    <tr>
                        <td>${item.id_data_service}</td>
                        <td>${item.id_daftar_service}</td>
                        <td>${item.daftar_service?.keluhan_kendaraan ?? '-'}</td>
                        <td>${item.estimasi_service}</td>
                        <td>${item.nama_mekanik}</td>
                        <td>${item.sparepart_pengganti}</td>
                    </tr>
                `;
            });

        } catch (error) {
            tabel.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align:center; color:#B45353;">
                        Gagal memuat data service.
                    </td>
                </tr>
            `;
            console.error(error);
        }
    }

    document.getElementById('formDataService').addEventListener('submit', async function(event) {
        event.preventDefault();

        const data = {
            id_daftar_service: document.getElementById('id_daftar_service').value,
            estimasi_service: document.getElementById('estimasi_service').value,
            nama_mekanik: document.getElementById('nama_mekanik').value,
            sparepart_pengganti: document.getElementById('sparepart_pengganti').value
        };

        try {
            const response = await fetch(API_DATA_SERVICE, {
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
            document.getElementById('keluhan_kendaraan').value = '';

            tampilkanDataService();

        } catch (error) {
            alert('Tidak dapat terhubung ke server.');
            console.error(error);
        }
    });

    muatPilihanService();
    tampilkanDataService();
</script>

@endsection
