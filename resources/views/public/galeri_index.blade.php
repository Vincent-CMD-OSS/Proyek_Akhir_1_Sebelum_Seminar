{{-- resources/views/public/galeri_index.blade.php --}}
@extends('layouts.user')

@section('title', 'Galeri Kegiatan - Panti Asuhan Rumah Harapan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/public_galeri.css') }}">
<style>
    /* ========================================
   GALERI INDEX STYLES
   ======================================== */

/* Hero Section */
.galeri-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 100px 0 80px;
    text-align: center;
}

.page-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.page-slogan {
    font-size: 1.2rem;
    opacity: 0.9;
    margin: 0;
}

/* Galeri Grid Section */
.galeri-grid-section {
    padding: 80px 0;
    background: #ffffff;
}

.galeri-grid-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.galeri-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

/* Galeri Card - Menggunakan desain card yang sudah ada sebelumnya */
.galeri-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.galeri-card-img-wrapper {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.galeri-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.galeri-card-date {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.95);
    padding: 8px 12px;
    border-radius: 8px;
    text-align: center;
    font-size: 0.85rem;
    font-weight: 600;
    color: #333;
}

.galeri-card-date .day {
    display: block;
    font-size: 1.2rem;
    line-height: 1;
}

.galeri-card-body {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.galeri-card-title {
    font-size: 1.4rem;
    font-weight: 600;
    margin-bottom: 15px;
    line-height: 1.3;
}

.galeri-card-title a {
    color: #333;
    text-decoration: none;
}

.galeri-card-text {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
    flex-grow: 1;
}

.galeri-card-readmore {
    align-self: flex-start;
    padding: 8px 20px;
    border: 2px solid #667eea;
    color: #667eea;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    background: transparent;
}

.galeri-card-footer {
    padding: 0 25px 20px;
    color: #999;
    font-size: 0.9rem;
}

/* Empty State */
.empty-state {
    padding: 60px 20px;
}

.empty-state i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #999;
    margin-bottom: 10px;
}

.empty-state p {
    color: #bbb;
}

/* ========================================
   GALERI DETAIL STYLES
   ======================================== */

/* Hero untuk detail - tetap ada */
.galeri-detail-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 100px 0 80px;
    text-align: center;
    margin: 0;
}

/* Detail Container - Full width tanpa gap */
.galeri-detail-wrapper {
    margin: 0;
    padding: 0;
    width: 100%;
}

.galeri-detail-content {
    background: white;
    margin: 0;
    padding: 0;
    width: 100%;
}

/* Detail Header - Full width */
.galeri-detail-header {
    padding: 40px;
    border-bottom: 1px solid #eee;
    margin: 0;
}

.galeri-detail-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
    line-height: 1.2;
}

.galeri-detail-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    color: #666;
    font-size: 1rem;
}

.galeri-detail-meta span {
    display: flex;
    align-items: center;
    gap: 8px;
}

.galeri-detail-meta i {
    color: #667eea;
    width: 16px;
}

/* Content Layout - Full width dengan grid */
.galeri-detail-main-content {
    padding: 40px;
    margin: 0;
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 40px;
    align-items: start;
    width: 100%;
    box-sizing: border-box;
}

.galeri-detail-image-wrapper {
    position: sticky;
    top: 20px;
}

.galeri-detail-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.galeri-detail-description {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #444;
}

.galeri-detail-description h1,
.galeri-detail-description h2,
.galeri-detail-description h3 {
    color: #333;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.galeri-detail-description p {
    margin-bottom: 1.5rem;
}

.galeri-detail-description ul,
.galeri-detail-description ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

/* Back Button - Full width */
.galeri-detail-footer {
    padding: 30px 40px 40px;
    border-top: 1px solid #eee;
    margin: 0;
}

.back-to-galeri-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 25px;
    background: transparent;
    border: 2px solid #667eea;
    color: #667eea;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
}

/* Galeri Lainnya Section - Full width */
.galeri-lainnya-section {
    padding: 80px 0;
    background: #f8f9fa;
    margin: 0;
    width: 100%;
}

.galeri-lainnya-title {
    text-align: center;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 50px;
    color: #333;
}

/* Horizontal Scroll Container */
.galeri-lainnya-scroll {
    overflow-x: auto;
    padding-bottom: 20px;
    margin: 0 -20px;
}

.galeri-lainnya-scroll::-webkit-scrollbar {
    height: 8px;
}

.galeri-lainnya-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.galeri-lainnya-scroll::-webkit-scrollbar-thumb {
    background: #667eea;
    border-radius: 4px;
}

.galeri-lainnya-items {
    display: flex;
    gap: 30px;
    padding: 0 20px;
    min-width: max-content;
}

.galeri-lainnya-card {
    flex: 0 0 320px;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.galeri-lainnya-card .galeri-card-img-wrapper {
    height: 200px;
}

.galeri-lainnya-card .galeri-card-body {
    padding: 20px;
}

.galeri-lainnya-card .galeri-card-title {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.galeri-lainnya-card .galeri-card-text {
    font-size: 0.95rem;
    margin-bottom: 15px;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 40px;
    text-align: center;
}

/* ========================================
   RESPONSIVE DESIGN
   ======================================== */

/* Container untuk mengatur full width di semua ukuran */
.container-fluid {
    padding: 0;
    margin: 0;
    width: 100%;
    max-width: 100%;
}

/* Tablet */
@media (max-width: 768px) {
    .page-title {
        font-size: 2.5rem;
    }
    
    .galeri-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .galeri-detail-title {
        font-size: 2rem;
    }
    
    .galeri-detail-main-content {
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 30px;
    }
    
    .galeri-detail-image-wrapper {
        position: relative;
        top: auto;
    }
    
    .galeri-detail-header {
        padding: 30px 30px 15px;
    }
    
    .galeri-detail-footer {
        padding: 20px 30px 30px;
    }
    
    .galeri-lainnya-title {
        font-size: 2rem;
    }
}

/* Mobile */
@media (max-width: 480px) {
    .galeri-hero, .galeri-detail-hero {
        padding: 80px 0 60px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .page-slogan {
        font-size: 1rem;
    }
    
    .galeri-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .galeri-card-body {
        padding: 20px;
    }
    
    .galeri-detail-title {
        font-size: 1.8rem;
    }
    
    .galeri-detail-main-content {
        padding: 20px;
        gap: 20px;
    }
    
    .galeri-detail-header {
        padding: 20px 20px 15px;
    }
    
    .galeri-detail-footer {
        padding: 15px 20px 20px;
    }
    
    .galeri-detail-meta {
        flex-direction: column;
        gap: 10px;
    }
    
    .galeri-lainnya-card {
        flex: 0 0 280px;
    }
}

/* Animation - simpel tanpa hover effects */
.animate-fade-in {
    animation: fadeIn 0.8s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-section {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out;
}

.animate-section.is-visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
@endpush

@section('content')

{{-- HERO SECTION --}}
<section class="galeri-hero animate-fade-in">
    <div class="container text-center">
        <h1 class="page-title">Galeri Kegiatan</h1>
        <p class="page-slogan">Momen Inspiratif di Rumah Harapan</p>
    </div>
</section>

{{-- GALERI GRID SECTION --}}
<section class="galeri-grid-section">
    <div class="galeri-grid-container">
        
        @if($galeriItems->isNotEmpty())
            <div class="galeri-grid">
                @foreach($galeriItems as $item)
                <div class="galeri-card animate-section">
                    <div class="galeri-card-img-wrapper">
                        <a href="{{ route('public.galeri.show', ['identifier' => $item->slug ?: $item->id]) }}">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('images/placeholder_galeri.jpg') }}"
                                 alt="{{ $item->judul }}" 
                                 class="galeri-card-img">
                        </a>
                        @if($item->tanggal_kegiatan)
                        <div class="galeri-card-date">
                            <span class="day">{{ $item->tanggal_kegiatan->format('d') }}</span>
                            <span class="month-year">{{ $item->tanggal_kegiatan->format('M Y') }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="galeri-card-body">
                        <h5 class="galeri-card-title">
                            <a href="{{ route('public.galeri.show', ['identifier' => $item->slug ?: $item->id]) }}">
                                {{ Str::limit($item->judul, 60) }}
                            </a>
                        </h5>
                        <p class="galeri-card-text">
                            {{ Str::limit(strip_tags($item->deskripsi), 120, '...') }}
                        </p>
                        <a href="{{ route('public.galeri.show', ['identifier' => $item->slug ?: $item->id]) }}" 
                           class="galeri-card-readmore">
                            Lihat Detail
                        </a>
                    </div>
                    
                    <div class="galeri-card-footer">
                        <small>Diposting: {{ $item->created_at->diffForHumans() }}</small>
                        @if($item->lokasi)
                        <small> • {{ $item->lokasi }}</small>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Pagination jika ada --}}
            @if(method_exists($galeriItems, 'links'))
            <div class="pagination-wrapper mt-5 d-flex justify-content-center">
                {{ $galeriItems->links() }}
            </div>
            @endif
            
        @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h3 class="text-muted">Belum Ada Galeri</h3>
                    <p class="text-muted">Galeri kegiatan akan segera ditambahkan.</p>
                </div>
            </div>
        @endif
        
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Animation on scroll
    const sections = document.querySelectorAll('.animate-section');
    
    if (sections.length > 0) {
        const observerOptions = { 
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const sectionObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, observerOptions);
        
        sections.forEach(section => {
            sectionObserver.observe(section);
        });
    }
});
</script>
@endpush