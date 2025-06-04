{{-- resources/views/public/galeri_index.blade.php --}}
@extends('layouts.user')

@section('title', 'Galeri Kegiatan - Panti Asuhan Rumah Harapan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/public_galeri.css') }}"> 
<style>
    :root {
        --primary-color: #667eea;
        --secondary-color: #764ba2;
        --text-light: #ffffff;
        --text-dark: #333333;
        --text-muted: #666666;
        --bg-light: #f8f9fa;
        --bg-white: #ffffff;
        --border-color: #eeeeee;
        --shadow-color: rgba(0, 0, 0, 0.08);
        --font-sans: 'Poppins', sans-serif; 
    }

    body {
        font-family: var(--font-sans);
        color: var(--text-dark);
        line-height: 1.6;
    }

    .galeri-hero-full {
        height: 100vh;
        background-image: url('https://images.unsplash.com/photo-1505236858219-8359eb29e329?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1500&q=80'); /* Ganti dengan URL gambar Anda */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        color: var(--text-light);
        padding: 20px;
        box-sizing: border-box;
    }

    .galeri-hero-full::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .galeri-hero-full-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
    }

    .galeri-hero-full-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.2;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .galeri-hero-full-slogan {
        font-size: 1.3rem;
        font-weight: 400;
        opacity: 0.9;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
    }

    .galeri-hero-cta-button {
        display: inline-block;
        padding: 12px 30px;
        background-color: var(--primary-color);
        color: var(--text-light);
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .galeri-hero-cta-button:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        color: var(--text-light);
    }

    .scroll-down-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        color: var(--text-light);
        font-size: 2rem;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateX(-50%) translateY(0);
        }
        40% {
            transform: translateX(-50%) translateY(-10px);
        }
        60% {
            transform: translateX(-50%) translateY(-5px);
        }
    }

    .galeri-grid-section {
        padding: 80px 0;
        background: var(--bg-white);
    }

    .galeri-hero-full + .galeri-grid-section {
    }

    .galeri-grid-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .galeri-section-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }
    .galeri-section-subtitle {
        text-align: center;
        font-size: 1.1rem;
        color: var(--text-muted);
        margin-bottom: 50px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }


    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 30px;
    }

    .galeri-card {
        background: var(--bg-white);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 25px var(--shadow-color);
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .galeri-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
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
        transition: transform 0.4s ease;
    }
    .galeri-card:hover .galeri-card-img {
        transform: scale(1.05);
    }

    .galeri-card-date {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        padding: 8px 12px;
        border-radius: 8px;
        text-align: center;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.1;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .galeri-card-date .day {
        display: block;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    .galeri-card-date .month-year{
        text-transform: uppercase;
        font-size: 0.7rem;
        color: var(--text-muted);
    }


    .galeri-card-body {
        padding: 20px 25px 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .galeri-card-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .galeri-card-title a {
        color: var(--text-dark);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .galeri-card-title a:hover {
        color: var(--primary-color);
    }

    .galeri-card-text {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.7;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .galeri-card-readmore {
        align-self: flex-start;
        padding: 10px 22px;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        text-decoration: none;
        border-radius: 25px;
        font-weight: 500;
        background: transparent;
        transition: background-color 0.3s ease, color 0.3s ease;
        font-size: 0.9rem;
    }
    .galeri-card-readmore:hover {
        background: var(--primary-color);
        color: var(--text-light);
    }

    .galeri-card-footer {
        padding: 0 25px 20px;
        color: #999;
        font-size: 0.85rem;
        border-top: 1px solid var(--border-color);
        margin-top: 15px;
        padding-top: 15px;
    }
    .galeri-card-footer small {
        display: inline-block;
        margin-right: 10px;
    }

    .empty-state-container {
        padding: 60px 20px;
        text-align: center;
        background-color: var(--bg-light);
        border-radius: 12px;
        margin-top: 40px;
    }
    .empty-state-container i {
        font-size: 4rem;
        color: #cccccc;
        margin-bottom: 20px;
    }
    .empty-state-container h3 {
        color: var(--text-muted);
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    .empty-state-container p {
        color: #aaaaaa;
        font-size: 1rem;
    }

    .pagination-wrapper {
        margin-top: 60px;
        text-align: center;
    }
    .pagination .page-item .page-link {
        color: var(--primary-color);
    }
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--text-light);
    }
    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
    }
    .pagination .page-item .page-link:hover {
        background-color: #e9ecef;
    }

    @media (max-width: 992px) {
        .galeri-hero-full-title {
            font-size: 3rem;
        }
        .galeri-hero-full-slogan {
            font-size: 1.2rem;
        }
        .galeri-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }


    @media (max-width: 768px) {
        .galeri-hero-full {
            height: auto; 
            min-height: 70vh;
            padding: 80px 20px;
        }
        .galeri-hero-full-title {
            font-size: 2.5rem;
        }
        .galeri-hero-full-slogan {
            font-size: 1.1rem;
        }
        .scroll-down-indicator {
            display: none;
        }
        .galeri-section-title {
            font-size: 2rem;
        }
        .galeri-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
         .galeri-card-img-wrapper {
            height: 220px;
        }
    }

    /* Mobile */
    @media (max-width: 480px) {
        .galeri-hero-full {
            min-height: 60vh;
            padding: 60px 15px;
        }
        .galeri-hero-full-title {
            font-size: 2rem;
        }
        .galeri-hero-full-slogan {
            font-size: 1rem;
        }
        .galeri-hero-cta-button {
            padding: 10px 25px;
            font-size: 0.9rem;
        }
        .galeri-grid {
            grid-template-columns: 1fr; /* Satu kolom di mobile */
            gap: 25px;
        }
        .galeri-card-title {
            font-size: 1.2rem;
        }
        .galeri-card-text {
            font-size: 0.9rem;
        }
         .galeri-card-img-wrapper {
            height: 200px;
        }
    }

    .animate-fade-in-hero { 
        animation: fadeInHero 1s ease-out 0.5s forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    @keyframes fadeInHero {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-section { 
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .animate-section.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
    <section class="galeri-hero-full">
        <div class="galeri-hero-full-content animate-fade-in-hero">
            <h1 class="galeri-hero-full-title">Jejak Kisah, Goresan Harapan</h1>
            <p class="galeri-hero-full-slogan">
                Setiap gambar adalah cerita, setiap momen adalah inspirasi. Lihatlah dunia kami melalui lensa kebersamaan dan keceriaan di Panti Asuhan Rumah Harapan.
            </p>
            <a href="#galeri-items-section" class="galeri-hero-cta-button">
                <i class="fas fa-camera-retro me-2"></i> Lihat Semua Momen
            </a>
        </div>
        <a href="#galeri-items-section" class="scroll-down-indicator" aria-label="Scroll ke galeri">
            <i class="fas fa-chevron-down"></i>
        </a>
    </section>

    {{-- GALERI GRID SECTION --}}
    <section class="galeri-grid-section" id="galeri-items-section"> {{-- Tambahkan ID di sini --}}
        <div class="galeri-grid-container">

            {{-- Judul Section Opsional --}}
            <h2 class="galeri-section-title">Momen Berharga Kami</h2>
            <p class="galeri-section-subtitle">
                Telusuri berbagai kegiatan, acara, dan keseharian anak-anak di panti kami.
                Setiap senyuman adalah bukti cinta dan dukungan Anda.
            </p>

            @if($galeriItems->isNotEmpty())
                <div class="galeri-grid">
                    @foreach($galeriItems as $item)
                    <div class="galeri-card animate-section">
                        <div class="galeri-card-img-wrapper">
                            <a href="{{ route('public.galeri.show', ['identifier' => $item->slug ?: $item->id]) }}">
                                <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('images/placeholder_galeri.jpg') }}"
                                    alt="{{ $item->judul }}"
                                    class="galeri-card-img" loading="lazy"> {{-- Tambah loading lazy --}}
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
                                    {{ Str::limit($item->judul, 55) }} {{-- Sedikit dipendekkan agar pas --}}
                                </a>
                            </h5>
                            <p class="galeri-card-text">
                                {{ Str::limit(strip_tags($item->deskripsi), 110, '...') }} {{-- Disesuaikan --}}
                            </p>
                            <a href="{{ route('public.galeri.show', ['identifier' => $item->slug ?: $item->id]) }}"
                            class="galeri-card-readmore">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>

                        <div class="galeri-card-footer">
                            <small><i class="fas fa-clock me-1"></i> {{ $item->created_at->diffForHumans() }}</small>
                            @if($item->lokasi)
                            <small><i class="fas fa-map-marker-alt me-1"></i> {{ Str::limit($item->lokasi, 20) }}</small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination jika ada --}}
                @if(method_exists($galeriItems, 'links') && $galeriItems->hasPages()) {{-- Cek jika ada halaman --}}
                <div class="pagination-wrapper d-flex justify-content-center">
                    {{ $galeriItems->links() }}
                </div>
                @endif

            @else
                <div class="empty-state-container animate-section is-visible"> {{-- Beri animasi juga --}}
                    <i class="fas fa-images"></i>
                    <h3>Belum Ada Galeri Kegiatan</h3>
                    <p>Kami akan segera membagikan momen-momen indah di sini. Nantikan ya!</p>
                </div>
            @endif

        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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

    const ctaButton = document.querySelector('.galeri-hero-cta-button');
    const scrollIndicator = document.querySelector('.scroll-down-indicator');
    const targetSection = document.getElementById('galeri-items-section');

    function scrollToTarget(event) {
        event.preventDefault();
        if (targetSection) {
            targetSection.scrollIntoView({ behavior: 'smooth' });
        }
    }

    if (ctaButton) {
        ctaButton.addEventListener('click', scrollToTarget);
    }
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', scrollToTarget);
    }

});
</script>
@endpush