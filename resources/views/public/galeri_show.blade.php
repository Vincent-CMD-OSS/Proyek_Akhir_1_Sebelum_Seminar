{{-- resources/views/public/galeri_show.blade.php --}}
@extends('layouts.user')

@section('title', $galeriItem->judul . ' - Galeri Kegiatan - Panti Asuhan Rumah Harapan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/public_galeri_detail.css') }}">
<style>
    /* ===============================================
   GALERI DETAIL - SIMPLE & CLEAN DESIGN
   =============================================== */

* {
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f5f5f5;
    margin: 0;
}

/* ===============================================
   HERO SECTION - SIMPLE
   =============================================== */
.page-hero-section {
    background: #fff;
    padding: 60px 0;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.page-slogan {
    font-size: 1.1rem;
    color: #666;
    margin: 0;
}

/* ===============================================
   MAIN CONTAINER
   =============================================== */
.galeri-detail-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
}

/* ===============================================
   CONTENT CARD - ALL IN ONE
   =============================================== */
.galeri-content-card {
    background: #fff;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

/* Header */
.galeri-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #f0f0f0;
}

.galeri-title {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    line-height: 1.3;
}

.galeri-meta {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    color: #666;
    font-size: 0.95rem;
}

.galeri-meta span {
    display: flex;
    align-items: center;
    gap: 8px;
}

.galeri-meta i {
    color: #999;
}

/* Main Content */
.galeri-main-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: start;
}

.galeri-image {
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.galeri-description {
    font-size: 1rem;
    line-height: 1.7;
    color: #555;
}

.galeri-description p {
    margin-bottom: 1rem;
}

.galeri-description h3, 
.galeri-description h4 {
    color: #333;
    margin: 1.5rem 0 1rem;
    font-weight: 600;
}

/* Info Section */
.galeri-info {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #f0f0f0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.info-group h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 0;
    color: #666;
    font-size: 0.95rem;
}

.info-list i {
    color: #999;
    width: 16px;
}

/* Back Button */
.back-section {
    text-align: center;
    margin-bottom: 40px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    color: #666;
    padding: 12px 24px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.2s ease;
}

.back-link:hover {
    background: #f8f8f8;
    color: #333;
    text-decoration: none;
    transform: translateY(-1px);
}

/* ===============================================
   GALERI LAINNYA - SIMPLE CARDS
   =============================================== */
.other-galeri {
    background: #fff;
    padding: 50px 0;
}

.other-galeri-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

.other-galeri-title {
    text-align: center;
    font-size: 1.8rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 40px;
}

.galeri-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.galeri-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: transform 0.2s ease;
}

.galeri-card:hover {
    transform: translateY(-3px);
}

.card-image-wrapper {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-date {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255,255,255,0.9);
    padding: 8px 10px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #333;
}

.card-body {
    padding: 20px;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.card-title a {
    color: #333;
    text-decoration: none;
}

.card-title a:hover {
    color: #666;
}

.card-text {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.card-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #666;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
}

.card-link:hover {
    color: #333;
    text-decoration: none;
}

.card-footer {
    padding: 15px 20px;
    background: #fafafa;
    border-top: 1px solid #f0f0f0;
    font-size: 0.85rem;
    color: #999;
}

/* ===============================================
   RESPONSIVE
   =============================================== */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .galeri-content-card {
        padding: 30px 20px;
    }
    
    .galeri-title {
        font-size: 1.6rem;
    }
    
    .galeri-meta {
        flex-direction: column;
        gap: 15px;
    }
    
    .galeri-main-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .galeri-info {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .galeri-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .galeri-detail-container {
        padding: 0 15px;
    }
    
    .galeri-content-card {
        padding: 20px 15px;
    }
    
    .page-hero-section {
        padding: 40px 0;
    }
    
    .page-title {
        font-size: 1.8rem;
    }
}

/* ===============================================
   UTILITY CLASSES
   =============================================== */
.text-center { text-align: center; }
.d-flex { display: flex; }
.align-items-stretch { align-items: stretch; }
.text-decoration-none { text-decoration: none; }

.row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}

.col {
    flex: 1;
    padding: 0 15px;
}

.g-4 {
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .row-cols-md-2 > .col {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (min-width: 992px) {
    .row-cols-lg-3 > .col {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
}
</style>
@endpush

@section('content')

{{-- HERO SECTION --}}
<section class="page-hero-section">
    <div class="container">
        <h1 class="page-title">Galeri Kegiatan</h1>
        <p class="page-slogan">Momen Inspiratif di Rumah Harapan</p>
    </div>
</section>

<div class="galeri-detail-container">
    
    {{-- MAIN CONTENT CARD --}}
    <div class="galeri-content-card">
        
        {{-- HEADER --}}
        <div class="galeri-header">
            <h1 class="galeri-title">{{ $galeriItem->judul }}</h1>
            <div class="galeri-meta">
                @if($galeriItem->tanggal_kegiatan)
                    <span>
                        <i class="fas fa-calendar-alt"></i> 
                        {{ $galeriItem->tanggal_kegiatan->isoFormat('D MMMM YYYY') }}
                    </span>
                @endif
                @if($galeriItem->lokasi)
                    <span>
                        <i class="fas fa-map-marker-alt"></i> 
                        {{ $galeriItem->lokasi }}
                    </span>
                @endif
                <span>
                    <i class="fas fa-clock"></i> 
                    {{ $galeriItem->created_at->diffForHumans() }}
                </span>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="galeri-main-content">
            
            {{-- GAMBAR --}}
            @if($galeriItem->gambar)
            <div class="galeri-image-section">
                <img src="{{ asset('storage/' . $galeriItem->gambar) }}" 
                     alt="{{ $galeriItem->judul }}" 
                     class="galeri-image">
            </div>
            @endif

            {{-- DESKRIPSI --}}
            <div class="galeri-description">
                {!! $deskripsiHtml !!}
            </div>

        </div>

        {{-- INFO SECTION --}}
        <div class="galeri-info">
            <div class="info-group">
                <h4>Informasi Kegiatan</h4>
                <ul class="info-list">
                    @if($galeriItem->tanggal_kegiatan)
                    <li>
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $galeriItem->tanggal_kegiatan->isoFormat('dddd, D MMMM YYYY') }}</span>
                    </li>
                    @endif
                    
                    @if($galeriItem->lokasi)
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $galeriItem->lokasi }}</span>
                    </li>
                    @endif
                    
                    <li>
                        <i class="fas fa-eye"></i>
                        <span>{{ number_format($galeriItem->views ?? 0) }} kali dilihat</span>
                    </li>
                </ul>
            </div>

            <div class="info-group">
                <h4>Detail Lainnya</h4>
                <ul class="info-list">
                    @if($galeriItem->kategori)
                    <li>
                        <i class="fas fa-tag"></i>
                        <span>{{ $galeriItem->kategori }}</span>
                    </li>
                    @endif
                    
                    <li>
                        <i class="fas fa-user"></i>
                        <span>{{ $galeriItem->created_by ?? 'Administrator' }}</span>
                    </li>
                    
                    @if($galeriItem->updated_at != $galeriItem->created_at)
                    <li>
                        <i class="fas fa-edit"></i>
                        <span>Diupdate {{ $galeriItem->updated_at->diffForHumans() }}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

    </div>

    {{-- BACK BUTTON --}}
    <div class="back-section">
        <a href="{{ route('public.galeri.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> 
            Kembali ke Galeri
        </a>
    </div>

</div>

{{-- GALERI LAINNYA --}}
@if($galeriLainnya->isNotEmpty())
<section class="other-galeri">
    <div class="other-galeri-container">
        <h2 class="other-galeri-title">Galeri Lainnya</h2>
        <div class="galeri-grid">
            @foreach($galeriLainnya as $itemLain)
            <div class="galeri-card">
                
                {{-- Image --}}
                <div class="card-image-wrapper">
                    <a href="{{ route('public.galeri.show', ['identifier' => $itemLain->slug ?: $itemLain->id]) }}">
                        <img src="{{ $itemLain->gambar ? asset('storage/' . $itemLain->gambar) : asset('images/placeholder_galeri.jpg') }}"
                             alt="{{ $itemLain->judul }}" 
                             class="card-image">
                    </a>
                    @if($itemLain->tanggal_kegiatan)
                    <div class="card-date">
                        {{ $itemLain->tanggal_kegiatan->format('d M Y') }}
                    </div>
                    @endif
                </div>

                {{-- Body --}}
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('public.galeri.show', ['identifier' => $itemLain->slug ?: $itemLain->id]) }}">
                            {{ Str::limit($itemLain->judul, 50) }}
                        </a>
                    </h5>
                    <p class="card-text">
                        {{ Str::limit(strip_tags($itemLain->deskripsi), 90, '...') }}
                    </p>
                    <a href="{{ route('public.galeri.show', ['identifier' => $itemLain->slug ?: $itemLain->id]) }}" 
                       class="card-link">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>

                {{-- Footer --}}
                <div class="card-footer">
                    <i class="fas fa-clock"></i> 
                    {{ $itemLain->created_at->diffForHumans() }}
                </div>

            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection