@extends('layouts.user')

@section('title', isset($profilPanti) ? 'Profil - ' . ($identitasPanti->nama_panti ?? 'Panti Asuhan') : 'Profil Panti Asuhan')

@push('styles')
    <style>
        html, body {
            scroll-behavior: smooth;
        }
        body {
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* STYLING UTAMA UNTUK SECTION FULL-HEIGHT & CENTERING */
        .page-hero-section,
        .profil-content-section {
            height: 110vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-bottom: 0;
            width: 100%;
            box-sizing: border-box;
            position: relative;
        }

        .page-hero-section {
            padding: 2rem 15px;
            text-align: center;
            background-size: cover;
            background-position: center;
            background-color: #343a40;
            color: #fff;
            background-attachment: fixed;
        }
        .profil-content-section {
            padding: 3rem 15px;
        }

        .page-hero-section .container,
        .profil-content-section .container {
            width: 100%;
            max-width: 1140px;
            margin-left: auto;
            margin-right: auto;
            z-index: 1;
        }

        .page-hero-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.5), rgba(0,0,0,0.3));
            z-index: 0;
            transition: opacity 0.3s ease;
        }

        .page-hero-section .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }
        .page-hero-section .page-slogan {
            font-size: 1.25rem;
            font-style: italic;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
            opacity: 0.95;
        }

        .section-header {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .section-header .text-muted.small {
            font-size: 0.85rem;
            color: #FFCA28 !important;
            margin-bottom: 0.2rem;
            display: block;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .section-header .section-heading {
            font-size: 1.9rem;
            font-weight: 700;
            color: #001f3f;
            margin-bottom: 0;
            line-height: 1.2;
        }

        .image-box-placeholder {
            background: transparent;
            border-radius: 12px;
            height: 320px;
            width: 100%;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
        }
        
        .image-box-placeholder img.content-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: opacity 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .content-box {
            background: transparent;
            padding: 2rem 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        
        .content-box .text-content,
        .vision-mission-box .text-content {
            font-size: 1rem;
            line-height: 1.8;
            color: #4F4F4F;
            text-align: justify;
            flex-grow: 1;
        }

        .anggota-list {
            width: 100%;
            margin-top: 1rem;
            max-height: 22.5rem;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 8px;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }
        
        .anggota-list::-webkit-scrollbar {
            width: 6px;
        }
        .anggota-list::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 6px;
        }
        .anggota-list::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #cbd5e0, #a0aec0);
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        .anggota-list::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #a0aec0, #718096);
        }

        .anggota-list-item {
            display: flex;
            align-items: center;
            /* Tingkatkan padding vertikal untuk memberi ruang lebih */
            padding: 1rem 0; /* Sebelumnya 0.75rem 0 */
            /* Tingkatkan margin bawah antar item */
            margin-bottom: 1.5rem; /* Sebelumnya 1.35rem */
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
        }
        
        .anggota-list-item:last-child {
            margin-bottom: 0;
        }

        .anggota-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1.25rem;
            background-color: #e9ecef;
            flex-shrink: 0;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .anggota-avatar.placeholder-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.5rem;
            color: #495057;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .anggota-info .anggota-nama {
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 1.2rem;
            color: #212529;
            transition: color 0.3s ease;
        }
        
        .anggota-info .anggota-jabatan {
            font-size: 0.95rem;
            color: #6c757d;
            transition: color 0.3s ease;
        }

        .vision-mission-box {
            margin-bottom: 1.75rem;
            padding: 1.5rem 0;
            transition: all 0.3s ease;
        }
        
        .vision-mission-box:last-child {
            margin-bottom: 0;
        }
        
        .vision-mission-box .sub-section-heading {
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 0.6rem;
            color: #1c313a;
            position: relative;
        }

        .row.align-items-stretch > [class*="col-"] {
            display: flex;
            flex-direction: column;
        }
        .image-column-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* IMPROVED ANIMATION SYSTEM - SMOOTH FADE IN/OUT */
        .profil-animated-section {
            opacity: 0;
            transition: opacity 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: opacity;
        }
        
        .profil-animated-section.is-visible {
            opacity: 1;
        }
        
        /* Individual element animations */
        .profil-animated-section .image-box-placeholder,
        .profil-animated-section .content-box,
        .profil-animated-section .anggota-list-item,
        .profil-animated-section .vision-mission-box {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .profil-animated-section.is-visible .image-box-placeholder {
            opacity: 1;
            transition-delay: 0.2s;
        }
        
        .profil-animated-section.is-visible .content-box {
            opacity: 1;
            transition-delay: 0.4s;
        }
        
        .profil-animated-section.is-visible .vision-mission-box {
            opacity: 1;
        }
        
        .profil-animated-section.is-visible .anggota-list-item {
            opacity: 1;
        }
        
        .profil-animated-section.is-visible .anggota-list-item:nth-child(1) { transition-delay: 0.1s; }
        .profil-animated-section.is-visible .anggota-list-item:nth-child(2) { transition-delay: 0.2s; }
        .profil-animated-section.is-visible .anggota-list-item:nth-child(3) { transition-delay: 0.3s; }
        .profil-animated-section.is-visible .anggota-list-item:nth-child(4) { transition-delay: 0.4s; }
        .profil-animated-section.is-visible .anggota-list-item:nth-child(5) { transition-delay: 0.5s; }
        .profil-animated-section.is-visible .anggota-list-item:nth-child(n+6) { transition-delay: 0.6s; }

        /* Performance optimizations */
        .profil-animated-section,
        .image-box-placeholder,
        .content-box,
        .anggota-list-item,
        .anggota-avatar {
            transform: translateZ(0);
        }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .page-hero-section {
                background-attachment: scroll;
                height: 70vh;
            }
            
            .profil-content-section {
                height: auto;
                min-height: 60vh;
                padding: 2rem 15px;
            }
            
            .page-hero-section .page-title {
                font-size: 2rem;
            }
            
            .anggota-list {
                max-height: 300px;
            }
            
            .content-box {
                padding: 1.5rem 0;
            }
        }
        
        /* Reduce motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            .profil-animated-section,
            .image-box-placeholder,
            .content-box,
            .anggota-list-item,
            .anggota-avatar,
            .vision-mission-box {
                transition-duration: 0.01ms !important;
            }
            
            .profil-animated-section {
                opacity: 1;
            }
            
            .profil-animated-section .image-box-placeholder,
            .profil-animated-section .content-box,
            .profil-animated-section .anggota-list-item,
            .profil-animated-section .vision-mission-box {
                opacity: 1;
            }

            .empty-state {
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 15px;
            box-sizing: border-box;
            }
        }
    </style>
@endpush

@section('content')

@if(isset($profilPanti))
    {{-- HERO SECTION --}}
    @if($profilPanti->tentang_kami_img || $profilPanti->slogan)
    <section class="page-hero-section profil-animated-section" style="{{ $profilPanti->tentang_kami_img_hero ? 'background-image: url(' . asset('storage/' . $profilPanti->tentang_kami_img_hero) . ');' : ($profilPanti->tentang_kami_img ? 'background-image: url(' . asset('storage/' . $profilPanti->tentang_kami_img) . ');' : 'background-color: #343a40;') }}">
        <div class="container">
            <h1 class="page-title">{{ $identitasPanti->nama_panti ?? 'Profil Panti Asuhan' }}</h1>
            @if($profilPanti->slogan)
            <p class="page-slogan">"{{ $profilPanti->slogan }}"</p>
            @endif
        </div>
    </section>
    @endif

        {{-- TENTANG KAMI --}}
        <section id="tentang-kami-detail" class="profil-content-section profil-animated-section">
            <div class="container">
                <div class="row align-items-stretch gy-3 gx-4">
                    @if($profilPanti->tentang_kami_img)
                    <div class="col-md-5 image-column-wrapper">
                        <div class="image-box-placeholder">
                            <img src="{{ asset('storage/' . $profilPanti->tentang_kami_img) }}" alt="Tentang {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                        </div>
                    </div>
                    @endif
                    <div class="{{ $profilPanti->tentang_kami_img ? 'col-md-7' : 'col-md-12' }}">
                        <div class="content-box">
                            <div class="section-header">
                                <p class="text-muted small">Siapa Kami</p>
                                <h2 class="section-heading">Tentang Kami</h2>
                            </div>
                            <div class="text-content">
                                {!! nl2br(e($profilPanti->tentang_kami_deskripsi)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SEJARAH SINGKAT --}}
        @if($profilPanti->sejarah_singkat_deskripsi)
        <section id="sejarah-detail" class="profil-content-section profil-animated-section">
            <div class="container">
                <div class="row align-items-stretch gy-3 gx-4">
                    <div class="{{ $profilPanti->sejarah_singkat_img ? 'col-md-7' : 'col-md-12' }}">
                        <div class="content-box">
                            <div class="section-header">
                                <p class="text-muted small">Perjalanan Kami</p>
                                <h2 class="section-heading">Sejarah Singkat</h2>
                            </div>
                            <div class="text-content">
                                {!! nl2br(e($profilPanti->sejarah_singkat_deskripsi)) !!}
                            </div>
                        </div>
                    </div>
                    @if($profilPanti->sejarah_singkat_img)
                    <div class="col-md-5 image-column-wrapper">
                         <div class="image-box-placeholder">
                            <img src="{{ asset('storage/' . $profilPanti->sejarah_singkat_img) }}" alt="Sejarah {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif

        {{-- VISI & MISI --}}
        @if($profilPanti->visi_deskripsi || $profilPanti->misi_deskripsi)
        <section id="visi-misi-detail" class="profil-content-section profil-animated-section">
            <div class="container">
                <div class="row align-items-stretch gy-3 gx-4">
                    <div class="{{ $profilPanti->visi_misi_img ? 'col-md-7' : 'col-md-12' }}">
                        <div class="content-box">
                            <div class="section-header">
                                <p class="text-muted small">Panduan Kami</p>
                                <h2 class="section-heading">Visi & Misi</h2>
                            </div>
                            @if($profilPanti->visi_deskripsi)
                            <div class="vision-mission-box">
                                <h3 class="sub-section-heading">Visi Kami</h3>
                                <div class="text-content">
                                    {!! nl2br(e($profilPanti->visi_deskripsi)) !!}
                                </div>
                            </div>
                            @endif
                            @if($profilPanti->misi_deskripsi)
                            <div class="vision-mission-box">
                                <h3 class="sub-section-heading">Misi Kami</h3>
                                <div class="text-content">
                                    {!! nl2br(e($profilPanti->misi_deskripsi)) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if($profilPanti->visi_misi_img)
                    <div class="col-md-5 image-column-wrapper">
                         <div class="image-box-placeholder">
                            <img src="{{ asset('storage/' . $profilPanti->visi_misi_img) }}" alt="Visi Misi {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif

       {{-- TIM PENDIRI --}}
@if(isset($profilPanti) && ($profilPanti->tim_pendiri_img_utama || (isset($timPendiri) && $timPendiri->isNotEmpty())))
<section id="tim-pendiri-detail" class="profil-content-section profil-animated-section">
    <div class="container">
        <div class="row align-items-stretch gy-3 gx-4">
            {{-- GAMBAR UTAMA DI KIRI --}}
            @if($profilPanti->tim_pendiri_img_utama)
            <div class="col-md-5 image-column-wrapper">
                <div class="image-box-placeholder">
                    <img src="{{ asset('storage/' . $profilPanti->tim_pendiri_img_utama) }}" alt="Tim Pendiri {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                </div>
            </div>
            @endif

            {{-- DAFTAR TIM PENDIRI DI KANAN --}}
            @if(isset($timPendiri) && $timPendiri->isNotEmpty())
            <div class="{{ $profilPanti->tim_pendiri_img_utama ? 'col-md-7' : 'col-md-12' }}">
                <div class="content-box">
                    <div class="section-header">
                        <p class="text-muted small">Para Inisiator</p>
                        <h2 class="section-heading">Tim Pendiri</h2>
                    </div>
                    <div class="anggota-list">
                        @foreach($timPendiri as $pendiri)
                            <div class="anggota-list-item">
                                {{-- Gunakan nama kolom dari database/model --}}
                                @if($pendiri->foto_pendiri)
                                    <img src="{{ asset('storage/' . $pendiri->foto_pendiri) }}" alt="{{ $pendiri->nama_pendiri }}" class="anggota-avatar">
                                @else
                                    <div class="anggota-avatar placeholder-avatar">
                                        <span>{{ strtoupper(substr($pendiri->nama_pendiri, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <div class="anggota-info">
                                    <h5 class="anggota-nama">{{ $pendiri->nama_pendiri }}</h5>
                                    <p class="anggota-jabatan">{{ $pendiri->peran_atau_jabatan }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- STRUKTUR ORGANISASI --}}
@if(isset($profilPanti) && ($profilPanti->struktur_organisasi_img_utama || (isset($strukturAnggota) && $strukturAnggota->isNotEmpty())))
<section id="struktur-organisasi-detail" class="profil-content-section profil-animated-section">
    <div class="container">
        <div class="row align-items-stretch gy-3 gx-4">
            @if(isset($strukturAnggota) && $strukturAnggota->isNotEmpty())
            <div class="{{ $profilPanti->struktur_organisasi_img_utama ? 'col-md-7' : 'col-md-12' }}">
                <div class="content-box">
                    <div class="section-header">
                        <p class="text-muted small">Tim Kami</p>
                        <h2 class="section-heading">Struktur Organisasi</h2>
                    </div>
                    <div class="anggota-list">
                        @foreach($strukturAnggota as $anggota)
                            <div class="anggota-list-item">
                                {{-- Gunakan nama kolom dari database/model --}}
                                @if($anggota->foto_anggota)
                                    <img src="{{ asset('storage/' . $anggota->foto_anggota) }}" alt="{{ $anggota->nama_anggota }}" class="anggota-avatar">
                                @else
                                    <div class="anggota-avatar placeholder-avatar">
                                       <span>{{ strtoupper(substr($anggota->nama_anggota, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <div class="anggota-info">
                                    <h5 class="anggota-nama">{{ $anggota->nama_anggota }}</h5>
                                    <p class="anggota-jabatan">{{ $anggota->jabatan }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if($profilPanti->struktur_organisasi_img_utama)
            <div class="col-md-5 image-column-wrapper">
                <div class="image-box-placeholder">
                    <img src="{{ asset('storage/' . $profilPanti->struktur_organisasi_img_utama) }}" alt="Struktur Organisasi {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

@else
    <div class="empty-state">
        <div class="container text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle mb-3 text-warning"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <h3 class="my-3">Oops! Informasi Belum Tersedia</h3>
            <p class="text-muted">Mohon maaf, informasi profil panti asuhan saat ini belum dapat ditampilkan.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Kembali ke Beranda</a>
        </div>
    </div>
@endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sections = document.querySelectorAll('.profil-animated-section');
            const options = {
                root: null,
                rootMargin: '-10% 0px -10% 0px',
                threshold: [0.1, 0.3, 0.5, 0.7]
            };

            const observer = new IntersectionObserver(function (entries, observerInstance) {
                entries.forEach(entry => {
                    if (entry.isIntersecting && entry.intersectionRatio > 0.3) {
                        entry.target.classList.add('is-visible');
                    } else if (!entry.isIntersecting || entry.intersectionRatio < 0.1) {
                        entry.target.classList.remove('is-visible');
                    }
                });
            }, options);

            sections.forEach(section => {
                observer.observe(section);
            });

            let ticking = false;
            function updateScrollEffects() {
                ticking = false;
            }

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(updateScrollEffects);
                    ticking = true;
                }
            });
        });
    </script>
@endpush