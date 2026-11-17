@extends('layouts.app')

@section('title', 'Pembayaran Service')
@section('heading', 'Pembayaran Service')

@section('content')

<div class="content-card">
    <h3 style="margin-bottom: 8px;">Tambah Pembayaran</h3>
    <p style="font-size: 13px; color: #8491A1; margin-bottom: 25px;">
        Masukkan informasi pembayaran service kendaraan.
    </p>

    <form id="formPembayaran">

        <label>ID Service Pelanggan</label>
        <select id="id_data_service" required>
            <option value="">Pilih ID Service</option>
        </select>

        <label>Jumlah Biaya Servis</label>
        <input type="number" id="jumlah_biaya_servis"
            placeholder="Masukkan jumlah biaya" min="0" step="0.01" required>

        <label>Jenis Pembayaran</label>
        <div style="display:flex; gap:25px; margin:12px 0 20px;">
            <label style="font-weight:400;">
                <input type="radio" name="jenis_pembayaran"
                    value="Cash/Tunai" required
                    style="width:auto; margin-right:6px;">
                Cash / Tunai
            </label>

            <label style="font-weight:400;">
                <input type="radio" name="jenis_pembayaran"
                    value="Non Tunai" style="width:auto; margin-right:6px;">
                Non Tunai
            </label>
        </div>

        <label>Keterangan</label>
        <textarea id="keterangan" rows="3"
            placeholder="Masukkan keterangan pembayaran"></textarea>

        <button type="submit">Simpan Pembayaran</button>

    </form>
</div>

<div class="content-card" style="margin-top:25px;">
    <h3>Daftar Pembayaran Service</h3>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>ID Pembayaran</th>
                    <th>ID Data Service</th>
                    <th>Jumlah Biaya</th>
                    <th>Jenis Pembayaran</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody id="daftarPembayaran">
                <tr>
                    <td colspan="5" style="text-align:center; color:#8491A1;">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    const API_PEMBAYARAN = '/api/pembayaran-service';
    const API_PILIHAN_PEMBAYARAN = '/api/pembayaran-service-pilihan';

    async function muatPilihanPembayaran() {
        try {
            const response = await fetch(API_PILIHAN_PEMBAYARAN, {
                headers: { 'Accept': 'application/json' }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error('Gagal mengambil pilihan pembayaran');
            }

            const select = document.getElementById('id_data_service');

            hasil.data.forEach(item => {
                select.innerHTML += `
                    <option value="${item.id_data_service}">
                        ${item.id_data_service} - ${item.daftar_service?.pelanggan?.nama_lengkap ?? 'Pelanggan'}
                    </option>
                `;
            });

        } catch (error) {
            console.error(error);
            alert('Gagal memuat pilihan ID service.');
        }
    }

    async function tampilkanPembayaran() {
        const tabel = document.getElementById('daftarPembayaran');

        try {
            const response = await fetch(API_PEMBAYARAN, {
                headers: { 'Accept': 'application/json' }
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error('Gagal mengambil data pembayaran');
            }

            tabel.innerHTML = '';

            if (hasil.data.length === 0) {
                tabel.innerHTML = `
                    <tr>
                        <td colspan="5" style="text-align:center; color:#8491A1;">
                            Belum ada pembayaran service.
                        </td>
                    </tr>
                `;
                return;
            }

            hasil.data.forEach(item => {
                tabel.innerHTML += `
                    <tr>
                        <td>${item.id_pembayaran}</td>
                        <td>${item.id_data_service}</td>
                        <td>Rp ${Number(item.jumlah_biaya_servis).toLocaleString('id-ID')}</td>
                        <td>${item.jenis_pembayaran}</td>
                        <td>${item.keterangan ?? '-'}</td>
                    </tr>
                `;
            });

        } catch (error) {
            tabel.innerHTML = `
                <tr>
                    <td colspan="5" style="text-align:center; color:#B45353;">
                        Gagal memuat data pembayaran.
                    </td>
                </tr>
            `;
            console.error(error);
        }
    }

    document.getElementById('formPembayaran').addEventListener('submit', async function(event) {
        event.preventDefault();

        const jenis = document.querySelector('input[name="jenis_pembayaran"]:checked');

        const data = {
            id_data_service: document.getElementById('id_data_service').value,
            jumlah_biaya_servis: document.getElementById('jumlah_biaya_servis').value,
            jenis_pembayaran: jenis.value,
            keterangan: document.getElementById('keterangan').value
        };

        try {
            const response = await fetch(API_PEMBAYARAN, {
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

            tampilkanPembayaran();

        } catch (error) {
            alert('Tidak dapat terhubung ke server.');
            console.error(error);
        }
    });

    muatPilihanPembayaran();
    tampilkanPembayaran();
</script>

@endsection
