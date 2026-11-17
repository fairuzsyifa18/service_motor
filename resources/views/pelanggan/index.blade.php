@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('heading', 'Data Pelanggan')

@section('content')

<div class="content-card">

    <h3 style="margin-bottom: 8px;">Tambah Pelanggan</h3>
    <p style="font-size: 13px; color: #8491A1; margin-bottom: 25px;">
        Masukkan informasi pelanggan bengkel.
    </p>

    <form id="formPelanggan">

        <label>Nama Lengkap</label>
        <input type="text" id="nama_lengkap" placeholder="Masukkan nama lengkap" required>

        <label>No HP</label>
        <input type="text" id="no_hp" placeholder="Masukkan nomor HP" required>

        <label>Alamat Pelanggan</label>
        <textarea id="alamat_pelanggan" rows="3" placeholder="Masukkan alamat pelanggan" required></textarea>

        <label>Pekerjaan</label>
        <input type="text" id="pekerjaan" placeholder="Masukkan pekerjaan" required>

        <button type="submit">Simpan Pelanggan</button>

    </form>

</div>

<div class="content-card" style="margin-top: 25px;">

    <h3>Daftar Pelanggan</h3>
    <p style="font-size: 13px; color: #8491A1; margin-top: 7px;">
        Informasi pelanggan yang telah terdaftar.
    </p>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>ID Pelanggan</th>
                    <th>Nama Lengkap</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Pekerjaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="daftarPelanggan">
                <tr>
                    <td colspan="6" style="text-align: center; color: #8491A1;">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<style>
    .btn-detail {
        display: inline-block;
        background: #526B89;
        color: white;
        padding: 8px 13px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        transition: .3s;
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: #405671;
        color: white;
        transform: translateY(-2px);
    }
</style>

<script>
    const API_URL = '/api/pelanggan';

    async function tampilkanPelanggan() {
        const tabel = document.getElementById('daftarPelanggan');

        try {
            const response = await fetch(API_URL, {
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
                            Belum ada data pelanggan.
                        </td>
                    </tr>
                `;
                return;
            }

            hasil.data.forEach(pelanggan => {
                tabel.innerHTML += `
                    <tr>
                        <td>${pelanggan.id_pelanggan}</td>
                        <td>${pelanggan.nama_lengkap}</td>
                        <td>${pelanggan.no_hp}</td>
                        <td>${pelanggan.alamat_pelanggan}</td>
                        <td>${pelanggan.pekerjaan}</td>
                        <td>
                            <a href="/pelanggan/${pelanggan.id_pelanggan}/detail"
                               class="btn-detail">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                `;
            });

        } catch (error) {
            tabel.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align:center; color:#B45353;">
                        Gagal memuat data pelanggan.
                    </td>
                </tr>
            `;
            console.error(error);
        }
    }

    document.getElementById('formPelanggan').addEventListener('submit', async function(event) {
        event.preventDefault();

        const data = {
            nama_lengkap: document.getElementById('nama_lengkap').value,
            no_hp: document.getElementById('no_hp').value,
            alamat_pelanggan: document.getElementById('alamat_pelanggan').value,
            pekerjaan: document.getElementById('pekerjaan').value
        };

        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const hasil = await response.json();

            if (!response.ok) {
                alert(hasil.message || 'Data gagal disimpan');
                return;
            }

            alert(hasil.message);
            this.reset();
            tampilkanPelanggan();

        } catch (error) {
            alert('Tidak dapat terhubung ke server.');
            console.error(error);
        }
    });

    tampilkanPelanggan();
</script>

@endsection