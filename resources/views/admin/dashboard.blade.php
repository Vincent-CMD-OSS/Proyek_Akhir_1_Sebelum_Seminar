{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* Variabel warna (sesuaikan dengan tema admin Anda, misal SB Admin 2) */
    :root {
        --admin-primary-color: #4e73df;
        --admin-success-color: #1cc88a;
        --admin-info-color: #36b9cc;
        --admin-warning-color: #f6c23e;
        --admin-danger-color: #e74a3b;
        --admin-text-dark: #5a5c69;
        --admin-text-muted: #858796;
        --admin-border-color: #e3e6f0;
        --admin-card-bg: #fff;
        --admin-card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        --admin-card-border-radius: 0.35rem;
    }

    .page-header .text-sm { font-size: 0.9rem; }

    /* Stat Card Styling */
    .stat-card-admin {
        background-color: var(--admin-card-bg);
        border-radius: var(--admin-card-border-radius);
        box-shadow: var(--admin-card-shadow);
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--admin-primary-color);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .stat-card-admin:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.3rem 2rem 0 rgba(58, 59, 69, 0.2);
    }
    .stat-card-admin.border-left-success { border-left-color: var(--admin-success-color); }
    .stat-card-admin.border-left-info { border-left-color: var(--admin-info-color); }
    .stat-card-admin.border-left-warning { border-left-color: var(--admin-warning-color); }
    .stat-card-admin.border-left-danger { border-left-color: var(--admin-danger-color); }

    .stat-card-admin .card-body {
        padding: 1.25rem;
    }
    .stat-card-admin .stat-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-card-admin .text-content .stat-title {
        color: var(--admin-text-muted);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
    }
    .stat-card-admin .text-content .stat-value {
        color: var(--admin-text-dark);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .stat-card-admin .stat-icon-container {
        font-size: 2rem;
        opacity: 0.6;
    }
    .stat-card-admin .stat-icon-container.text-primary { color: var(--admin-primary-color); }
    .stat-card-admin .stat-icon-container.text-success { color: var(--admin-success-color); }
    .stat-card-admin .stat-icon-container.text-info { color: var(--admin-info-color); }
    .stat-card-admin .stat-icon-container.text-warning { color: var(--admin-warning-color); }
    .stat-card-admin .stat-icon-container.text-danger { color: var(--admin-danger-color); }

    /* Card untuk Chart dan Info List */
    .dashboard-info-card {
        background-color: var(--admin-card-bg);
        border-radius: var(--admin-card-border-radius);
        box-shadow: var(--admin-card-shadow);
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .dashboard-info-card .card-header {
        padding: 0.75rem 1.25rem;
        background-color: #f8f9fc;
        border-bottom: 1px solid var(--admin-border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dashboard-info-card .card-header .card-title {
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 600;
        color: var(--admin-primary-color);
    }
    .dashboard-info-card .card-body {
        padding: 1.25rem;
        flex-grow: 1;
    }
    .dashboard-info-card .card-footer {
        padding: 0.75rem 1.25rem;
        background-color: #f8f9fc;
        border-top: 1px solid var(--admin-border-color);
        font-size: 0.8rem;
        color: var(--admin-text-muted);
    }

    /* Styling untuk daftar ringkasan */
    .summary-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    .summary-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f0f2f5;
        font-size: 0.9rem;
    }
    .summary-list-item:last-child {
        border-bottom: none;
    }
    .summary-list-item .item-title a {
        color: var(--admin-text-dark);
        text-decoration: none;
        font-weight: 500;
    }
    .summary-list-item .item-title a:hover {
        color: var(--admin-primary-color);
    }
    .summary-list-item .item-meta {
        font-size: 0.8rem;
        color: var(--admin-text-muted);
    }
    .summary-list-item .item-status .badge {
        font-size: 0.7rem;
        padding: 0.3em 0.6em;
    }

    /* Wrapper untuk Canvas Chart */
    .chart-canvas-wrapper {
        position: relative;
        height: 320px; /* Tinggi chart yang diinginkan, sesuaikan */
        width: 100%;
    }
    /* Placeholder jika tidak ada data chart */
    .chart-placeholder-message {
        min-height: 280px;
        display: flex;
        flex-direction: column; /* Agar ikon dan teks vertikal */
        align-items: center;
        justify-content: center;
        color: var(--admin-text-muted);
        border: 1px dashed var(--admin-border-color);
        border-radius: var(--admin-card-border-radius);
        background-color: #fdfdfd;
        padding: 1rem;
        text-align: center;
    }
    .chart-placeholder-message i {
        font-size: 2.5rem; /* Ukuran ikon placeholder */
        margin-bottom: 0.75rem;
        opacity: 0.7;
    }
</style>
@endpush

@section('content')
{{-- Judul Halaman --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    {{-- Tombol Report Opsional --}}
    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
</div>

<!-- Baris 1: Stat Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-admin border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="stat-content">
                    <div class="text-content">
                        <p class="stat-title text-primary">Total Item Galeri</p>
                        <h4 class="stat-value mb-0">{{ $jumlahGaleri ?? 0 }}</h4>
                    </div>
                    <div class="stat-icon-container text-primary">
                        <i class="fas fa-images fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-admin border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="stat-content">
                    <div class="text-content">
                        <p class="stat-title text-success">Kebutuhan Aktif</p>
                        <h4 class="stat-value mb-0">{{ $kebutuhanAktif ?? 0 }}</h4>
                    </div>
                    <div class="stat-icon-container text-success">
                        <i class="fas fa-hands-helping fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-admin border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="stat-content">
                    <div class="text-content">
                        <p class="stat-title text-info">Kunjungan Pending</p>
                        <h4 class="stat-value mb-0">{{ $permintaanKunjunganPending ?? 0 }}</h4>
                    </div>
                    <div class="stat-icon-container text-info">
                        <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-admin border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="stat-content">
                    <div class="text-content">
                        <p class="stat-title text-warning">Donasi Bulan Ini</p>
                        <h4 class="stat-value mb-0">Rp {{ number_format($totalDonasiBulanIni ?? 0, 0, ',', '.') }}</h4>
                    </div>
                    <div class="stat-icon-container text-warning">
                        <i class="fas fa-donate fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Baris 2: Chart dan Jadwal Khusus -->
<div class="row">
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="dashboard-info-card shadow">
            <div class="card-header">
                <h6 class="card-title"><i class="fas fa-chart-line me-1"></i>Tren Donasi (6 Bulan Terakhir)</h6>
            </div>
            <div class="card-body">
                @if(!empty($dataChartDonasi['labels']) && count($dataChartDonasi['labels']) > 0 && count($dataChartDonasi['data']) > 0)
                    <div class="chart-canvas-wrapper">
                        <canvas id="donasiChart"></canvas>
                    </div>
                @else
                    <div class="chart-placeholder-message">
                        <i class="fas fa-chart-bar"></i>
                        <p>Tidak ada data donasi yang cukup untuk ditampilkan pada chart saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="dashboard-info-card shadow">
            <div class="card-header">
                <h6 class="card-title"><i class="fas fa-calendar-alt me-1"></i>Jadwal Khusus Mendatang</h6>
            </div>
            <div class="card-body">
                @if(isset($jadwalKhususBerikutnya) && $jadwalKhususBerikutnya->isNotEmpty())
                    <ul class="summary-list">
                        @foreach($jadwalKhususBerikutnya as $jadwal)
                        <li class="summary-list-item">
                            <div class="item-title">
                                <a href="{{ route('admin.operasional.index') }}#khusus-tab-pane" title="{{$jadwal->nama_acara_libur}}">
                                    {{ Str::limit($jadwal->nama_acara_libur, 25) }}
                                </a>
                                <small class="d-block text-muted">{{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('dddd, D MMM YYYY') }}</small>
                            </div>
                            <div class="item-status">
                                <span class="badge bg-{{ $jadwal->status_operasional == 'Tutup' ? 'danger' : ($jadwal->status_operasional == 'Buka' ? 'success' : 'info') }} text-white">
                                    {{ $jadwal->status_operasional }}
                                </span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center my-3">Tidak ada jadwal khusus mendatang.</p>
                @endif
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.operasional.index') }}" class="small"><i class="fas fa-external-link-alt me-1"></i>Lihat Semua Jadwal</a>
            </div>
        </div>
    </div>
</div>

<!-- Baris 3: Ringkasan Aktivitas Lainnya -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="dashboard-info-card shadow">
            <div class="card-header">
                <h6 class="card-title"><i class="fas fa-photo-video me-1"></i>Galeri Terbaru</h6>
            </div>
            <div class="card-body">
                @if(isset($galeriTerbaru) && $galeriTerbaru->isNotEmpty())
                    <ul class="summary-list">
                        @foreach($galeriTerbaru as $item)
                        <li class="summary-list-item">
                            <div class="item-title">
                                <a href="{{ route('admin.galeri.edit', $item->id) }}" title="{{ $item->judul }}">{{ Str::limit($item->judul, 30) }}</a>
                                <small class="d-block text-muted">
                                    {{ $item->tanggal_kegiatan ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->isoFormat('D MMM YYYY') : $item->created_at->isoFormat('D MMM YYYY') }}
                                    @if($item->lokasi) - {{ Str::limit($item->lokasi, 15) }} @endif
                                </small>
                            </div>
                            <div class="item-status">
                                <span class="badge bg-{{ $item->status_publikasi == 'published' ? 'success' : 'secondary' }} text-white">{{ ucfirst($item->status_publikasi) }}</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center my-3">Belum ada item galeri.</p>
                @endif
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.galeri.index') }}" class="small"><i class="fas fa-external-link-alt me-1"></i>Lihat Semua Galeri</a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="dashboard-info-card shadow">
            <div class="card-header">
                <h6 class="card-title"><i class="fas fa-box-open me-1"></i>Kebutuhan Terbaru</h6>
            </div>
            <div class="card-body">
                @if(isset($kebutuhanTerbaru) && $kebutuhanTerbaru->isNotEmpty())
                     <ul class="summary-list">
                        @foreach($kebutuhanTerbaru as $item)
                        <li class="summary-list-item">
                            <div class="item-title">
                                <a href="{{ route('admin.kebutuhan.show', $item->id) }}" title="{{ $item->nama_kebutuhan }}">{{ Str::limit($item->nama_kebutuhan, 30) }}</a>
                                <small class="d-block text-muted">Target: Rp {{ number_format($item->target_dana, 0, ',', '.') }}</small>
                            </div>
                             <div class="item-status">
                                <span class="badge
                                    @if($item->status_kebutuhan == 'Aktif') bg-success
                                    @elseif($item->status_kebutuhan == 'Tercapai') bg-primary text-white {{-- Ganti ke primary agar beda --}}
                                    @elseif($item->status_kebutuhan == 'Draft') bg-secondary
                                    @else bg-danger @endif text-white">
                                    {{ $item->status_kebutuhan }}
                                </span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center my-3">Belum ada data kebutuhan.</p>
                @endif
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.kebutuhan.index') }}" class="small"><i class="fas fa-external-link-alt me-1"></i>Lihat Semua Kebutuhan</a>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Permintaan Kunjungan Terbaru (Jika ada) --}}
@if(class_exists(App\Models\PermintaanKunjungan::class) && isset($permintaanKunjunganTerbaru) && $permintaanKunjunganTerbaru->isNotEmpty())
<div class="row">
    <div class="col-12 mb-4">
        <div class="dashboard-info-card shadow">
            <div class="card-header">
                <h6 class="card-title"><i class="fas fa-clipboard-list me-1"></i>Permintaan Kunjungan Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle"> {{-- table-sm dan align-middle --}}
                        <thead class="table-light"> {{-- Thead dengan background --}}
                            <tr>
                                <th>Nama Pengunjung</th>
                                <th>Tanggal Rencana</th>
                                <th>Kontak</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permintaanKunjunganTerbaru as $kunjungan)
                            <tr>
                                <td>{{ $kunjungan->nama_pengunjung }}</td>
                                <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_rencana_kunjungan)->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                <td>
                                    @if($kunjungan->kontak_whatsapp)
                                        <i class="fab fa-whatsapp text-success me-1"></i>{{ $kunjungan->kontak_whatsapp }}
                                    @elseif($kunjungan->email_pengunjung)
                                        <i class="fas fa-envelope text-muted me-1"></i>{{ $kunjungan->email_pengunjung }}
                                    @else - @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{-- rounded-pill untuk badge --}}
                                        @if($kunjungan->status == 'pending') bg-warning text-dark
                                        @elseif($kunjungan->status == 'disetujui') bg-success text-white
                                        @elseif($kunjungan->status == 'ditolak') bg-danger text-white
                                        @else bg-secondary text-white @endif">
                                        {{ ucfirst($kunjungan->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
             <div class="card-footer text-center">
                <a href="{{ route('admin.kunjungan.index') }}" class="small"><i class="fas fa-external-link-alt me-1"></i>Lihat Semua Permintaan</a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dataChartDonasi = @json($dataChartDonasi ?? ['labels' => [], 'data' => []]);
    const donasiChartCanvas = document.getElementById('donasiChart');

    if (donasiChartCanvas && dataChartDonasi.labels && dataChartDonasi.labels.length > 0 && dataChartDonasi.data && dataChartDonasi.data.length > 0) {
        const ctxDonasi = donasiChartCanvas.getContext('2d');
        new Chart(ctxDonasi, {
            type: 'line',
            data: {
                labels: dataChartDonasi.labels,
                datasets: [{
                    label: 'Total Donasi Diterima',
                    data: dataChartDonasi.data,
                    borderColor: 'rgba(78, 115, 223, 1)', // var(--admin-primary-color)
                    backgroundColor: 'rgba(78, 115, 223, 0.1)', // Area fill lebih transparan
                    fill: true,
                    tension: 0.4, // Kurva lebih halus
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2, // Garis sedikit lebih tebal
                    pointRadius: 4, // Titik data lebih terlihat
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            color: '#858796', // var(--admin-text-muted)
                            font: { size: 10 }
                        },
                        grid: {
                            color: '#e3e6f0', // var(--admin-border-color)
                            borderDash: [2, 2] // Garis grid putus-putus
                        }
                    },
                    x: {
                         ticks: {
                            color: '#858796',
                            font: { size: 10 }
                        },
                        grid: {
                            display: false // Sembunyikan grid vertikal
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true, // Tampilkan legenda
                        position: 'top', // Posisi legenda
                         labels: {
                            color: '#5a5c69', // var(--admin-text-dark)
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#5a5c69',
                        bodyColor: '#858796',
                        borderColor: '#e3e6f0',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                },
                interaction: { // Interaksi hover lebih baik
                    mode: 'index',
                    intersect: false,
                },
            }
        });
    }
});
</script>
@endpush