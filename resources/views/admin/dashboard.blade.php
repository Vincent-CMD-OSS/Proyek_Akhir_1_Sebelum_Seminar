@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
{{-- Judul Halaman dan Deskripsi --}}
<div class="page-header mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <p class="text-sm text-secondary">Check the sales, value and bounce rate by country.</p>
</div>

<!-- Baris 1: Stat Cards -->
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="stat-card">
            <div class="card-content">
                <div class="text-content">
                    <p class="stat-title">Today's Money</p>
                    <h4 class="stat-value mb-0">$53k</h4>
                </div>
                <div class="stat-icon-container" style="background-image: linear-gradient(310deg, #7928CA 0%, #FF0080 100%);">
                    <i class="fas fa-landmark"></i>
                </div>
            </div>
            <hr class="dark horizontal my-1">
            <p class="stat-change mb-0">
                <span class="percent positive">+55%</span>
                <span class="period">than last week</span>
            </p>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="stat-card">
            <div class="card-content">
                <div class="text-content">
                    <p class="stat-title">Today's Users</p>
                    <h4 class="stat-value mb-0">2,300</h4>
                </div>
                <div class="stat-icon-container" style="background-image: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%);">
                    <i class="fas fa-globe"></i>
                </div>
            </div>
            <hr class="dark horizontal my-1">
            <p class="stat-change mb-0">
                <span class="percent positive">+3%</span>
                <span class="period">than last month</span>
            </p>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="stat-card">
            <div class="card-content">
                <div class="text-content">
                    <p class="stat-title">Ads Views</p>
                    <h4 class="stat-value mb-0">3,462</h4>
                </div>
                <div class="stat-icon-container" style="background-image: linear-gradient(310deg, #17ad37 0%, #98ec2d 100%);">
                    <i class="fas fa-user"></i> {{-- Ikon di gambar berbeda, sesuaikan jika perlu --}}
                </div>
            </div>
            <hr class="dark horizontal my-1">
            <p class="stat-change mb-0">
                <span class="percent negative">-2%</span>
                <span class="period">than yesterday</span>
            </p>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="card-content">
                <div class="text-content">
                    <p class="stat-title">Sales</p>
                    <h4 class="stat-value mb-0">$103,430</h4>
                </div>
                <div class="stat-icon-container" style="background-image: linear-gradient(310deg, #f53939 0%, #fbcf33 100%);">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <hr class="dark horizontal my-1">
            <p class="stat-change mb-0">
                <span class="percent positive">+5%</span>
                <span class="period">than yesterday</span>
            </p>
        </div>
    </div>
</div>

<!-- Baris 2: Chart Cards -->
<div class="row mt-4">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="chart-card">
            <div class="card-header-text">
                <h6 class="chart-title">Website Views</h6>
                <p class="chart-subtitle">Last Campaign Performance</p>
            </div>
            <div class="chart-placeholder d-flex align-items-center justify-content-center" style="min-height: 250px;">
                <span>Bar Chart Placeholder</span>
                {{-- Implementasikan chart library di sini (misal: Chart.js) --}}
            </div>
            <div class="card-footer-text pt-3 mt-auto">
                <i class="fas fa-clock me-1"></i> campaign sent 2 days ago
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="chart-card">
            <div class="card-header-text">
                <h6 class="chart-title">Daily Sales</h6>
                <p class="chart-subtitle">(<span class="text-success fw-bold">+15%</span>) increase in today sales.</p>
            </div>
            <div class="chart-placeholder d-flex align-items-center justify-content-center" style="min-height: 250px;">
                <span>Line Chart Placeholder</span>
            </div>
            <div class="card-footer-text pt-3 mt-auto">
                <i class="fas fa-clock me-1"></i> updated 4 min ago
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 mb-4"> {{-- Lebar penuh di md jika hanya 1 --}}
        <div class="chart-card">
            <div class="card-header-text">
                <h6 class="chart-title">Completed Tasks</h6>
                <p class="chart-subtitle">Last Campaign Performance</p>
            </div>
            <div class="chart-placeholder d-flex align-items-center justify-content-center" style="min-height: 250px;">
                <span>Line Chart Placeholder</span>
            </div>
            <div class="card-footer-text pt-3 mt-auto">
                <i class="fas fa-clock me-1"></i> just updated
            </div>
        </div>
    </div>
</div>

<!-- Baris 3: Info Cards -->
<div class="row mt-0 mt-md-4"> {{-- Kurangi margin top di mobile --}}
    <div class="col-lg-7 mb-lg-0 mb-4">
        <div class="info-card">
            <div class="card-header-flex">
                <h6 class="info-title mb-0">Projects</h6>
                <button class="btn btn-link text-dark p-0 mb-0"><i class="fas fa-ellipsis-v"></i></button>
            </div>
            <div class="card-body px-0 pb-2 pt-0"> {{-- Hapus padding default card-body jika item punya padding sendiri --}}
                 <div class="info-item px-3 py-2">
                     <i class="fas fa-check-circle text-info me-2"></i> {{-- Warna ikon dari gambar 'blueish' --}}
                     <span><strong>30 done</strong> this month</span>
                 </div>
                {{-- Tambahkan lebih banyak info-item jika ada --}}
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="info-card">
             <div class="card-header-flex">
                <h6 class="info-title mb-0">Orders overview</h6>
                <button class="btn btn-link text-dark p-0 mb-0"><i class="fas fa-cog"></i></button>
            </div>
             <div class="card-body px-0 pb-2 pt-0">
                 <div class="info-item order-overview px-3 py-2">
                     <i class="fas fa-arrow-up text-success me-2"></i>
                     <span><strong>24%</strong> this month</span>
                 </div>
                 {{-- Tambahkan lebih banyak info-item jika ada --}}
             </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
@endpush

@push('scripts')
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
{{-- <script>
    // Example: Initialize charts here
</script> --}}
@endpush