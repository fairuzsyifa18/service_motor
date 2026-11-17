@extends('layouts.app')

@section('title', 'Data Kendaraan')
@section('heading', 'Data Kendaraan')

@section('content')

<div class="content-card">
    <h3 style="margin-bottom: 8px;">Tambah Kendaraan</h3>
    <p style="font-size: 13px; color: #8491A1; margin-bottom: 25px;">
        Masukkan informasi kendaraan pelanggan.
    </p>

    <form id="formKendaraan">

        <label>No Plat Kendaraan</label>
        <input type="text" id="no_plat_kendaraan"
            placeholder="Contoh: BL 1234 AB" required>

        <label>Jenis Kendaraan</label>
        <div style="display:flex; gap:25px; margin:12px 0 20px;">
            <label style="font-weight:400;">
                <input type="radio" name="jenis_kendaraan"
                    value="Matic" required style="width:auto; margin-right:6px;">
                Matic
            </label>

            <label style="font-weight:400;">
                <input type="radio" name="jenis_kendaraan"
                    value="Manual Transmisi" style="width:auto; margin-right:6px;">
                Manual Transmisi
            </label>
        </div>

        <label>No STNK</label>
        <input type="text" id="no_stnk" placeholder="Masukkan nomor STNK" required>

        <label>Tahun Pembuatan Kendaraan</label>
        <input type="number" id="tahun_pembuatan"
            placeholder="Contoh: 2022" min="1900" max="2100" required>

        <label>Nama Pemilik</label>
        <input type="text" id="nama_pemilik"
            placeholder="Masukkan nama pemilik" required>

        <label>Warna Kendaraan</label>
        <input type="text" id="warna_kendaraan"
            placeholder="Masukkan warna kendaraan" required>

        <button type="submit">Simpan Kendaraan</button>
    </form>
</div>

<div class="content-card" style="margin-top:25px;">
    <h3>Daftar Kendaraan</h3>
    <p style="font-size:13px; color:#8491A1; margin-top:7px;">
        Informasi kendaraan yang telah terdaftar.
    </p>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>No Plat</th>
                    <th>Jenis Kendaraan</th>
                    <th>No STNK</th>
                    <th>Tahun</th>
                    <th>Nama Pemilik</th>
                    <th>Warna</th>
                </tr>
            </thead>
            <tbody id="daftarKendaraan">
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
    const API_KENDARAAN = '/api/kendaraan';

    async function tampilkanKendaraan() {
        const tabel = document.getElementById('daftarKendaraan');

        try {
            const response = await fetch(API_KENDARAAN, {
                headers: { 'Accept': 'application/json' }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(hasil.message || 'Gagal mengambil data');
            }

            tabel.innerHTML = '';

            if (hasil.data.length === 0) {
                tabel.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align:center; color:#8491A1;">
                            Belum ada data kendaraan.
                        </td>
                    </tr>
                `;
                return;
            }

            hasil.data.forEach(kendaraan => {
                tabel.innerHTML += `
                    <tr>
                        <td>${kendaraan.no_plat_kendaraan}</td>
                        <td>${kendaraan.jenis_kendaraan}</td>
                        <td>${kendaraan.no_stnk}</td>
                        <td>${kendaraan.tahun_pembuatan}</td>
                        <td>${kendaraan.nama_pemilik}</td>
                        <td>${kendaraan.warna_kendaraan}</td>
                    </tr>
                `;
            });

        } catch (error) {
            tabel.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align:center; color:#B45353;">
                        Gagal memuat data kendaraan.
                    </td>
                </tr>
            `;
            console.error(error);
        }
    }

    document.getElementById('formKendaraan').addEventListener('submit', async function(event) {
        event.preventDefault();

        const jenis = document.querySelector('input[name="jenis_kendaraan"]:checked');

        const data = {
            no_plat_kendaraan: document.getElementById('no_plat_kendaraan').value,
            jenis_kendaraan: jenis.value,
            no_stnk: document.getElementById('no_stnk').value,
            tahun_pembuatan: document.getElementById('tahun_pembuatan').value,
            nama_pemilik: document.getElementById('nama_pemilik').value,
            warna_kendaraan: document.getElementById('warna_kendaraan').value
        };

        try {
            const response = await fetch(API_KENDARAAN, {
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
            tampilkanKendaraan();

        } catch (error) {
            alert('Tidak dapat terhubung ke server.');
            console.error(error);
        }
    });

    tampilkanKendaraan();
</script>

@endsection
