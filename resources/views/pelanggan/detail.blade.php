@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('heading', 'Detail Pelanggan')

@section('content')

<style>
    .detail-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 22px;
        margin-bottom: 20px;
        animation: fadeDetail .5s ease;
    }

    .detail-title {
        color: #526B89;
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .detail-item {
        background: #f5f7fa;
        padding: 13px;
        border-radius: 9px;
    }

    .detail-label {
        color: #7b8794;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .detail-value {
        color: #344253;
        font-weight: 600;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .history-card {
        border-left: 4px solid #8da6c2;
        background: #f7f9fc;
        border-radius: 10px;
        padding: 18px;
        margin-bottom: 16px;
    }

    .history-heading {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
        color: #526B89;
        font-weight: 700;
    }

    .history-section {
        margin-top: 16px;
    }

    .history-section h4 {
        color: #526B89;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .empty-history {
        background: #f5f7fa;
        padding: 18px;
        border-radius: 10px;
        color: #7b8794;
        text-align: center;
    }

    .back-button {
        display: inline-block;
        background: #526B89;
        color: white;
        padding: 10px 17px;
        border-radius: 8px;
        text-decoration: none;
        margin-bottom: 18px;
        transition: .3s;
    }

    .back-button:hover {
        background: #405671;
        color: white;
        transform: translateY(-2px);
    }

    @keyframes fadeDetail {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media(max-width: 600px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<a href="/pelanggan" class="back-button">
    ← Kembali ke Data Pelanggan
</a>

{{-- DATA PELANGGAN --}}
<div class="detail-card">
    <div class="detail-title">Informasi Pelanggan</div>

    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">ID Pelanggan</div>
            <div class="detail-value">
                {{ $pelanggan->id_pelanggan }}
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Nama Lengkap</div>
            <div class="detail-value">
                {{ $pelanggan->nama_lengkap }}
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Nomor HP</div>
            <div class="detail-value">
                {{ $pelanggan->no_hp }}
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Alamat</div>
            <div class="detail-value">
                {{ $pelanggan->alamat_pelanggan }}
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Pekerjaan</div>
            <div class="detail-value">
                {{ $pelanggan->pekerjaan }}
            </div>
        </div>
    </div>
</div>

{{-- RIWAYAT SERVICE --}}
<div class="detail-card">
    <div class="detail-title">Riwayat Service Pelanggan</div>

    @forelse ($pelanggan->daftarServices as $riwayat)

        <div class="history-card">

            <div class="history-heading">
                <span>
                    Service #{{ $riwayat->id_daftar_service }}
                </span>

                <span>
                    {{ $riwayat->tanggal_service }}
                </span>
            </div>

            {{-- DATA KENDARAAN --}}
            <div class="history-section">
                <h4>Informasi Kendaraan</h4>

                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Nomor Plat</div>
                        <div class="detail-value">
                            {{ $riwayat->kendaraan->no_plat_kendaraan ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Jenis Kendaraan</div>
                        <div class="detail-value">
                            {{ $riwayat->kendaraan->jenis_kendaraan ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Nomor STNK</div>
                        <div class="detail-value">
                            {{ $riwayat->kendaraan->no_stnk ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Tahun Pembuatan</div>
                        <div class="detail-value">
                            {{ $riwayat->kendaraan->tahun_pembuatan ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Nama Pemilik</div>
                        <div class="detail-value">
                            {{ $riwayat->kendaraan->nama_pemilik ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Warna Kendaraan</div>
                        <div class="detail-value">
                            {{ $riwayat->kendaraan->warna_kendaraan ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- KELUHAN --}}
            <div class="history-section">
                <h4>Keluhan Kendaraan</h4>

                <div class="detail-item">
                    <div class="detail-value">
                        {{ $riwayat->keluhan_kendaraan }}
                    </div>
                </div>
            </div>

            {{-- DATA PENGERJAAN SERVICE --}}
            <div class="history-section">
                <h4>Data Pengerjaan Service</h4>

                @forelse ($riwayat->dataServices as $dataService)

                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Estimasi Service</div>
                            <div class="detail-value">
                                {{ $dataService->estimasi_service }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Nama Mekanik</div>
                            <div class="detail-value">
                                {{ $dataService->nama_mekanik }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Sparepart Pengganti</div>
                            <div class="detail-value">
                                {{ $dataService->sparepart_pengganti }}
                            </div>
                        </div>
                    </div>

                    {{-- PEMBAYARAN --}}
                    <div class="history-section">
                        <h4>Informasi Pembayaran</h4>

                        @forelse ($dataService->pembayaranServices as $pembayaran)

                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Jumlah Biaya</div>
                                    <div class="detail-value">
                                        Rp {{ number_format((float) $pembayaran->jumlah_biaya_servis, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-label">Jenis Pembayaran</div>
                                    <div class="detail-value">
                                        {{ $pembayaran->jenis_pembayaran }}
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-label">Keterangan</div>
                                    <div class="detail-value">
                                        {{ $pembayaran->keterangan ?? '-' }}
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="empty-history">
                                Belum ada data pembayaran.
                            </div>
                        @endforelse
                    </div>

                @empty
                    <div class="empty-history">
                        Belum ada data pengerjaan service.
                    </div>
                @endforelse

            </div>

        </div>

    @empty

        <div class="empty-history">
            Pelanggan ini belum memiliki riwayat service.
        </div>

    @endforelse

</div>

@endsection
