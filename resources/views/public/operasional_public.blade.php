{{-- resources/views/public/operasional_public.blade.php --}}
@extends('layouts.user') {{-- Sesuaikan dengan nama layout utamamu --}}

@php
    // Helper untuk format jam tanpa detik
    function formatJam(string $jam = null): string {
        if (!$jam) return '-';
        try {
            return \Carbon\Carbon::createFromFormat('H:i:s', $jam)->format('H:i');
        } catch (\Exception $e) {
            try {
                return \Carbon\Carbon::createFromFormat('H:i', $jam)->format('H:i');
            } catch (\Exception $e) {
                return $jam; // Return original if parsing fails
            }
        }
    }
@endphp

@section('title', 'Jadwal Operasional - ' . ($identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan'))

@push('styles')
<style>
    body {
        background-color: #fff; /* Latar putih seperti diminta */
        font-family: 'Arial', sans-serif; /* Font standar yang rapi */
        color: #333;
        line-height: 1.6;
    }
    .operasional-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
    }
    .page-header-operasional {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .page-header-operasional h1 {
        font-size: 2.5rem;
        color: #004085; /* Warna biru tua untuk judul */
        margin-bottom: 0.5rem;
    }
    .page-header-operasional p {
        font-size: 1.1rem;
        color: #666;
    }
    .jadwal-section {
        margin-bottom: 40px;
    }
    .jadwal-section h2 {
        font-size: 1.8rem;
        color: #004085;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #0056b3; /* Garis bawah yang lebih tebal untuk subjudul */
    }
    .table-operasional {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Shadow halus */
    }
    .table-operasional th,
    .table-operasional td {
        border: 1px solid #ddd;
        padding: 12px 15px;
        text-align: left;
        vertical-align: top;
    }
    .table-operasional th {
        background-color: #f8f9fa; /* Latar header tabel */
        font-weight: 600;
        color: #333;
    }
    .table-operasional tr:nth-child(even) {
        background-color: #fdfdfd; /* Zebra striping halus */
    }
    .status-buka {
        color: #28a745; /* Hijau untuk Buka */
        font-weight: bold;
    }
    .status-tutup {
        color: #dc3545; /* Merah untuk Tutup */
        font-weight: bold;
    }
    .status-jam-khusus {
        color: #ffc107; /* Kuning untuk Jam Khusus */
        font-weight: bold;
    }
    .no-jadwal {
        font-style: italic;
        color: #777;
    }
    .keterangan-text {
        font-size: 0.9em;
        color: #555;
        display: block;
        margin-top: 4px;
    }
    .list-group-item {
        border-left: 3px solid #007bff; /* Aksen biru pada item list */
        margin-bottom: 8px;
        padding-left: 15px;
    }
    .empty-state-operasional {
        text-align: center;
        padding: 30px;
        background-color: #f8f9fa;
        border-radius: 5px;
        color: #6c757d;
    }

    /* Responsif untuk tabel */
    @media (max-width: 768px) {
        .table-operasional thead {
            display: none; /* Sembunyikan header tabel */
        }
        .table-operasional, .table-operasional tbody, .table-operasional tr, .table-operasional td {
            display: block;
            width: 100%;
        }
        .table-operasional tr {
            margin-bottom: 15px;
            border: 1px solid #ddd; /* Border per baris */
        }
        .table-operasional td {
            text-align: right; /* Label di kiri, value di kanan */
            padding-left: 50%; /* Ruang untuk label */
            position: relative;
            border: none; /* Hapus border sel */
            border-bottom: 1px solid #eee; /* Garis antar field */
        }
        .table-operasional td:last-child {
            border-bottom: none;
        }
        .table-operasional td::before {
            content: attr(data-label); /* Ambil label dari data-label attribute */
            position: absolute;
            left: 15px; /* Posisi label */
            width: calc(50% - 30px); /* Lebar label */
            padding-right: 10px;
            white-space: nowrap;
            text-align: left;
            font-weight: bold;
            color: #333;
        }
        .page-header-operasional h1 { font-size: 2rem; }
        .jadwal-section h2 { font-size: 1.5rem; }
    }
</style>
@endpush

@section('content')
<div class="operasional-container">
    <div class="page-header-operasional">
        <h1>Jadwal Operasional</h1>
        <p>Informasi jam buka dan layanan Panti Asuhan {{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }}.</p>
    </div>

    {{-- JADWAL OPERASIONAL HARIAN --}}
    <section class="jadwal-section" id="jadwal-harian">
        <h2>Jadwal Harian Reguler</h2>
        <div class="table-responsive"> {{-- Agar tabel bisa discroll horizontal jika terlalu lebar --}}
            <table class="table-operasional">
                <thead>
                    <tr>
                        <th style="width:15%;">Hari</th>
                        <th style="width:25%;">Jam Operasional</th>
                        <th style="width:15%;">Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalHarianTampilan as $hari => $slots)
                        <tr>
                            <td data-label="Hari"><strong>{{ $hari }}</strong></td>
                            @if($slots->isNotEmpty())
                                <td data-label="Jam Operasional">
                                    @foreach($slots as $slot)
                                        <div class="list-group-item">
                                            {{ formatJam($slot->jam_buka) }} - {{ formatJam($slot->jam_tutup) }}
                                            @if($slot->keterangan)
                                                <small class="keterangan-text d-block text-muted">({{ $slot->keterangan }})</small>
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                                <td data-label="Status">
                                    @foreach($slots as $slot)
                                        <div class="list-group-item">
                                            <span class="{{ $slot->status_operasional == 'Buka' ? 'status-buka' : 'status-tutup' }}">
                                                {{ $slot->status_operasional }}
                                            </span>
                                        </div>
                                    @endforeach
                                </td>
                                <td data-label="Keterangan">
                                     {{-- Keterangan utama per hari bisa ditaruh di sini jika ada --}}
                                     {{-- Atau keterangan per slot sudah ditampilkan di atas --}}
                                </td>
                            @else
                                <td colspan="3" data-label="Info" class="no-jadwal">Tidak ada jadwal operasional reguler.</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center no-jadwal">
                                Belum ada data jadwal operasional harian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- JADWAL OPERASIONAL KHUSUS --}}
    @if($jadwalKhusus->isNotEmpty())
    <section class="jadwal-section" id="jadwal-khusus">
        <h2>Jadwal Khusus & Hari Libur</h2>
        <div class="table-responsive">
            <table class="table-operasional">
                <thead>
                    <tr>
                        <th style="width:20%;">Tanggal</th>
                        <th style="width:30%;">Nama Acara/Libur</th>
                        <th style="width:15%;">Status</th>
                        <th style="width:20%;">Jam Khusus</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwalKhusus as $khusus)
                    <tr>
                        <td data-label="Tanggal">
                            {{ \Carbon\Carbon::parse($khusus->tanggal)->isoFormat('dddd, D MMMM YYYY') }}
                        </td>
                        <td data-label="Acara/Libur">{{ $khusus->nama_acara_libur }}</td>
                        <td data-label="Status">
                            @if($khusus->status_operasional == 'Buka')
                                <span class="status-buka">Buka</span>
                            @elseif($khusus->status_operasional == 'Tutup')
                                <span class="status-tutup">Tutup</span>
                            @elseif($khusus->status_operasional == 'Jam Khusus')
                                <span class="status-jam-khusus">Jam Khusus</span>
                            @else
                                {{ $khusus->status_operasional }}
                            @endif
                        </td>
                        <td data-label="Jam Khusus">
                            @if($khusus->status_operasional == 'Jam Khusus' && $khusus->jam_buka_khusus && $khusus->jam_tutup_khusus)
                                {{ formatJam($khusus->jam_buka_khusus) }} - {{ formatJam($khusus->jam_tutup_khusus) }}
                            @else
                                -
                            @endif
                        </td>
                        <td data-label="Keterangan">
                            {{ $khusus->keterangan ?: '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    @else
    <section class="jadwal-section" id="jadwal-khusus">
        <h2>Jadwal Khusus & Hari Libur</h2>
        <div class="empty-state-operasional">
            <p>Tidak ada jadwal khusus atau hari libur yang tercatat untuk periode ini.</p>
        </div>
    </section>
    @endif

</div>
@endsection

@push('scripts')
{{-- Tidak ada script khusus untuk halaman ini, kecuali jika ada interaksi tambahan --}}
@endpush