@extends('layouts.user')

@section('title', isset($profilPanti) ? 'Profil - ' . ($identitasPanti->nama_panti ?? 'Panti Asuhan') : 'Profil Panti Asuhan')

@push('styles')
<style>
        html, body {
            scroll-behavior: smooth;
        }
        body {
            background-color: #ffffff;
            overflow-x: hidden; /* Mencegah scroll horizontal yang tidak diinginkan */
        }

        /* STYLING UTAMA UNTUK SECTION */
        .page-hero-section,
        .profil-content-section {
            /* Mengganti height dengan min-height */
            min-height: 100vh; /* Atau 110vh jika Anda benar-benar ingin defaultnya lebih tinggi */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Menengahkan konten secara vertikal */
            align-items: center;
            padding-top: 60px; /* Jarak dari navbar jika fixed */
            padding-bottom: 60px; /* Padding bawah agar konten tidak terlalu mepet */
            width: 100%;
            box-sizing: border-box;
            position: relative;
            overflow: hidden; /* Mencegah konten gambar besar keluar dari bounds */
        }

        .page-hero-section {
            text-align: center;
            background-size: cover;
            background-position: center;
            background-color: #343a40; /* Fallback jika gambar tidak ada */
            color: #fff;
            background-attachment: fixed; /* Efek parallax sederhana */
        }
        /* .profil-content-section tidak perlu padding spesifik lagi jika sudah diatur di atas */

        .page-hero-section .container,
        .profil-content-section .container {
            width: 100%;
            max-width: 1140px; /* Standar Bootstrap .container-lg */
            margin-left: auto;
            margin-right: auto;
            z-index: 1; /* Konten di atas overlay */
            padding-left: 15px; /* Padding standar container Bootstrap */
            padding-right: 15px;
        }

        .page-hero-section::before { /* Overlay untuk hero */
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.6), rgba(0,0,0,0.4)); /* Overlay lebih gelap sedikit */
            z-index: 0;
        }

        .page-hero-section .page-title {
            font-size: clamp(2rem, 5vw, 3rem); /* Ukuran font responsif */
            font-weight: 700;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }
        .page-hero-section .page-slogan {
            font-size: clamp(1rem, 3vw, 1.25rem); /* Ukuran font responsif */
            font-style: italic;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
            opacity: 0.95;
        }

        /* Header untuk setiap section konten */
        .section-header {
            margin-bottom: 2rem; /* Jarak lebih besar */
            text-align: left;
            width: 100%; /* Pastikan header mengambil lebar penuh container */
        }
        .section-header .text-muted.small {
            font-size: 0.9rem; /* Sedikit lebih besar */
            color: #FFCA28 !important; /* Warna kuning aksen */
            margin-bottom: 0.3rem;
            display: block;
            font-weight: 600; /* Lebih tebal */
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .section-header .section-heading {
            font-size: clamp(1.8rem, 4vw, 2.2rem); /* Ukuran font responsif */
            font-weight: 700;
            color: #001f3f; /* Biru Navy Tua */
            margin-bottom: 0;
            line-height: 1.3;
        }

        /* Konten di dalam .row */
        .profil-content-section .row {
            width: 100%; /* Pastikan row mengisi container */
        }

        .image-box-placeholder {
            background: #f0f0f0; /* Warna placeholder lebih netral */
            border-radius: 12px;
            height: auto; /* Biarkan tinggi menyesuaikan aspect ratio gambar */
            min-height: 250px; /* Tinggi minimum jika tidak ada gambar */
            width: 100%;
            overflow: hidden;
            position: relative;
            display: flex; /* Untuk menengahkan teks placeholder */
            align-items: center;
            justify-content: center;
        }

        .image-box-placeholder img.content-image {
            width: 100%;
            height: auto; /* Tinggi gambar menyesuaikan lebar */
            max-height: 450px; /* Batas tinggi maksimum untuk gambar */
            object-fit: cover;
            display: block;
            border-radius: 12px; /* Radius pada gambar juga jika gambar lebih kecil */
        }
        /* Placeholder text jika tidak ada gambar */
        .image-box-placeholder:not(:has(img.content-image))::after {
            content: "Gambar tidak tersedia";
            color: #999;
            font-style: italic;
        }


        .content-box {
            background: transparent; /* Tidak perlu background jika section sudah putih */
            padding: 1rem 0; /* Padding vertikal untuk konten teks */
            /* height: 100%; dihapus, biarkan konten menentukan tinggi */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Menengahkan konten di dalam content-box */
        }

        .content-box .text-content,
        .vision-mission-box .text-content {
            font-size: 1.05rem; /* Sedikit lebih besar untuk keterbacaan */
            line-height: 1.85;
            color: #333; /* Warna teks lebih gelap */
            text-align: justify;
            /* flex-grow: 1; dihapus agar tidak memaksa stretch */
        }

        .anggota-list {
            width: 100%;
            margin-top: 1.5rem; /* Jarak dari header section */
            max-height: 300px; /* Tinggi maksimum list anggota */
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 10px; /* Ruang untuk scrollbar */
            scrollbar-width: thin;
            scrollbar-color: #a0aec0 #e9ecef; /* Warna scrollbar */
        }

        .anggota-list::-webkit-scrollbar { width: 8px; }
        .anggota-list::-webkit-scrollbar-track { background: #e9ecef; border-radius: 8px; }
        .anggota-list::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #a0aec0, #718096); border-radius: 8px; }
        .anggota-list::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #718096, #4a5568); }

        .anggota-list-item {
            display: flex;
            align-items: center;
            padding: 1rem 0.5rem; /* Padding di dalam item */
            margin-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0; /* Garis pemisah halus antar anggota */
            transition: background-color 0.2s ease;
        }
        .anggota-list-item:hover {
            background-color: #f8f9fa; /* Efek hover halus */
        }
        .anggota-list-item:last-child {
            margin-bottom: 0;
            border-bottom: none;
        }

        .anggota-avatar {
            width: 60px; /* Ukuran avatar disesuaikan */
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
            background-color: #e9ecef;
            flex-shrink: 0;
        }

        .anggota-avatar.placeholder-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.4rem; /* Ukuran teks placeholder avatar */
            background: linear-gradient(135deg, #87CEEB 0%, #5F9EA0 100%); /* Gradasi biru lembut */
            color: white;
        }

        .anggota-info .anggota-nama {
            font-weight: 600;
            margin-bottom: 0.2rem;
            font-size: 1.1rem; /* Ukuran nama */
            color: #2c3e50; /* Warna nama lebih gelap */
        }

        .anggota-info .anggota-jabatan {
            font-size: 0.9rem;
            color: #7f8c8d; /* Warna jabatan muted */
        }

        .vision-mission-box {
            margin-bottom: 2rem;
            padding: 0; /* Padding dari .content-box */
        }

        .vision-mission-box:last-child {
            margin-bottom: 0;
        }

        .vision-mission-box .sub-section-heading {
            font-size: 1.5rem; /* Ukuran sub-judul Visi/Misi */
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #1c313a; /* Warna sub-judul */
        }

        /* Memastikan gambar tidak keluar dari kolomnya */
        .image-column-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%; /* Agar gambar bisa mengisi tinggi kolom jika memungkinkan */
        }


        /* ANIMATION SYSTEM - Sama seperti sebelumnya, sudah baik */
        .profil-animated-section {
            opacity: 0;
            transition: opacity 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: opacity;
        }
        .profil-animated-section.is-visible { opacity: 1; }

        .profil-animated-section .image-box-placeholder,
        .profil-animated-section .content-box,
        .profil-animated-section .anggota-list-item,
        .profil-animated-section .vision-mission-box {
            opacity: 0;
            transform: translateY(20px); /* Animasi slide-up kecil */
            transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .profil-animated-section.is-visible .image-box-placeholder { opacity: 1; transform: translateY(0); transition-delay: 0.2s; }
        .profil-animated-section.is-visible .content-box { opacity: 1; transform: translateY(0); transition-delay: 0.3s; } /* Konten teks muncul setelah gambar */
        .profil-animated-section.is-visible .vision-mission-box { opacity: 1; transform: translateY(0); }
        .profil-animated-section.is-visible .anggota-list-item { opacity: 1; transform: translateY(0); }
        /* Staggering untuk list anggota */
        .profil-animated-section.is-visible .anggota-list-item:nth-child(1) { transition-delay: 0.1s; }
        .profil-animated-section.is-visible .anggota-list-item:nth-child(2) { transition-delay: 0.2s; }
        .profil-animated-section.is-visible .anggota-list-item:nth-child(3) { transition-delay: 0.3s; }
        .profil-animated-section.is-visible .anggota-list-item:nth-child(n+4) { transition-delay: 0.4s; }


        .profil-animated-section,
        .image-box-placeholder,
        .content-box,
        .anggota-list-item,
        .anggota-avatar {
            transform: translateZ(0); /* Memicu hardware acceleration */
        }

        /* Mobile optimizations */
        @media (max-width: 992px) { /* Tablet */
            .image-box-placeholder img.content-image {
                max-height: 350px;
            }
        }

        @media (max-width: 768px) {
            .page-hero-section {
                background-attachment: scroll; /* Hapus fixed attachment di mobile untuk performa */
                min-height: 60vh; /* Hero lebih pendek di mobile */
                height: auto; /* Biarkan konten menentukan jika lebih dari 60vh */
                padding-top: 80px; /* Lebih banyak padding atas */
            }
            .profil-content-section {
                min-height: 0; /* Hapus min-height, biarkan konten menentukan */
                height: auto;
                padding: 3rem 15px; /* Padding standar untuk mobile */
            }
            .section-header { text-align: center; /* Judul section rata tengah di mobile */ }
            .profil-content-section .row > [class*="col-md-"]:first-child .image-column-wrapper {
                margin-bottom: 2rem; /* Jarak gambar ke teks jika gambar di atas */
            }
             .image-box-placeholder img.content-image {
                max-height: 300px;
            }
            .content-box .text-content { text-align: left; /* Teks rata kiri di mobile agar lebih natural */ }
        }

        @media (prefers-reduced-motion: reduce) {
            .profil-animated-section,
            .image-box-placeholder,
            .content-box,
            .anggota-list-item,
            .anggota-avatar,
            .vision-mission-box {
                transition: none !important; /* Hapus semua transisi */
                opacity: 1 !important; /* Pastikan terlihat */
                transform: none !important; /* Reset transform */
            }
        }

        .empty-state { /* Styling untuk empty state */
            min-height: 80vh; /* Tinggi minimal */
            height: auto; /* Biarkan konten menentukan */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 15px;
            box-sizing: border-box;
            text-align: center;
        }

        .anggota-list-item {
            display: flex;
            flex-direction: column; /* << KUNCI PERUBAHAN: Mengatur item menjadi kolom */
            /* align-items: center; Dihapus, karena sekarang kolom */
            padding: 1rem 0.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }
        .anggota-list-item:hover {
            background-color: #f8f9fa;
        }
        .anggota-list-item:last-child {
            margin-bottom: 0;
            border-bottom: none;
        }

        /* Wrapper BARU untuk info utama dan tombol */
        .anggota-main-info {
            display: flex;
            align-items: center; /* Avatar, info, tombol tetap sejajar horizontal */
            width: 100%;
            margin-bottom: 0; /* Hapus margin bawah jika deskripsi akan muncul tepat di bawahnya */
        }

        .anggota-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
            background-color: #e9ecef;
            flex-shrink: 0;
        }

        .anggota-avatar.placeholder-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.4rem;
            background: linear-gradient(135deg, #87CEEB 0%, #5F9EA0 100%);
            color: white;
        }

        .anggota-info {
            flex-grow: 1; /* Info mengambil sisa ruang */
        }
        .anggota-info .anggota-nama {
            font-weight: 600;
            margin-bottom: 0.2rem;
            font-size: 1.1rem;
            color: #2c3e50;
        }
        .anggota-info .anggota-jabatan {
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .btn-toggle-deskripsi {
            background-color: transparent;
            border: 1px solid #a0aec0;
            color: #4a5568;
            padding: 0.25rem 0.6rem;
            font-size: 0.75rem;
            border-radius: 1rem;
            cursor: pointer;
            margin-left: auto; /* Mendorong tombol ke kanan (ms-auto dari Bootstrap) */
            transition: background-color 0.2s ease, color 0.2s ease;
            display: inline-flex;
            align-items: center;
            flex-shrink: 0; /* Agar tombol tidak mengecil */
        }
        .btn-toggle-deskripsi:hover {
            background-color: #e9ecef;
            border-color: #718096;
        }
        .btn-toggle-deskripsi .arrow-icon {
            margin-left: 0.3rem;
            transition: transform 0.3s ease;
        }
        .btn-toggle-deskripsi.active .arrow-icon {
            transform: rotate(180deg);
        }

        .anggota-deskripsi-kontribusi {
            display: none;
            width: 100%;
            padding: 0.75rem 0.5rem 0.25rem 0.5rem;
            margin-top: 0.75rem;
            font-size: 0.9rem;
            color: #555;
            line-height: 1.6;
            background-color: #f8f9fa;
            border-radius: 6px;
            border-left: 3px solid #87CEEB;
            text-align: justify;
            /* Untuk memastikan deskripsi dimulai dari bawah avatar jika ada */
            /* padding-left: calc(60px + 1rem + 0.5rem); (lebar avatar + margin kanan avatar + padding kiri deskripsi) */
            /* Atau lebih baik, biarkan dia full width dan beri padding kiri yang sama dengan info utama jika mau */
        }
        .anggota-deskripsi-kontribusi p:last-child {
            margin-bottom: 0;
        }

    </style>
@endpush

@section('content')

@if(isset($profilPanti))
    {{-- HERO SECTION --}}
    @if($profilPanti->tentang_kami_img_hero || $profilPanti->tentang_kami_img || $profilPanti->slogan) {{-- Cek salah satu gambar atau slogan ada --}}
    <section class="page-hero-section profil-animated-section"
             style="{{ $profilPanti->tentang_kami_img_hero ? 'background-image: url(' . asset('storage/' . $profilPanti->tentang_kami_img_hero) . ');' : ($profilPanti->tentang_kami_img ? 'background-image: url(' . asset('storage/' . $profilPanti->tentang_kami_img) . ');' : '') }}">
        <div class="container">
            <h1 class="page-title">{{ $identitasPanti->nama_panti ?? 'Profil Panti Asuhan' }}</h1>
            @if($profilPanti->slogan)
            <p class="page-slogan">"{{ $profilPanti->slogan }}"</p>
            @endif
        </div>
    </section>
    @endif

    {{-- TENTANG KAMI --}}
    @if($profilPanti->tentang_kami_deskripsi)
    <section id="tentang-kami-detail" class="profil-content-section profil-animated-section">
        <div class="container">
            <div class="row align-items-center gy-4 gx-lg-5"> {{-- gy-4 untuk gutter vertikal, gx-lg-5 untuk gutter horizontal di lg ke atas --}}
                @if($profilPanti->tentang_kami_img)
                <div class="col-lg-5 image-column-wrapper">
                    <div class="image-box-placeholder">
                        <img src="{{ asset('storage/' . $profilPanti->tentang_kami_img) }}" alt="Tentang {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                    </div>
                </div>
                <div class="col-lg-7"> {{-- Konten teks di kanan jika ada gambar --}}
                @else
                <div class="col-lg-12"> {{-- Konten teks full width jika tidak ada gambar --}}
                @endif
                    <div class="content-box">
                        <div class="section-header">
                            <p class="text-muted small">Mengenal Lebih Dekat</p>
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
    @endif

    {{-- SEJARAH SINGKAT --}}
    @if($profilPanti->sejarah_singkat_deskripsi)
    <section id="sejarah-detail" class="profil-content-section profil-animated-section">
        <div class="container">
            <div class="row align-items-center gy-4 gx-lg-5 flex-lg-row-reverse"> {{-- Tukar posisi gambar dan teks di layar besar --}}
                @if($profilPanti->sejarah_singkat_img)
                <div class="col-lg-5 image-column-wrapper">
                     <div class="image-box-placeholder">
                        <img src="{{ asset('storage/' . $profilPanti->sejarah_singkat_img) }}" alt="Sejarah {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                    </div>
                </div>
                <div class="col-lg-7">
                @else
                <div class="col-lg-12">
                @endif
                    <div class="content-box">
                        <div class="section-header">
                            <p class="text-muted small">Jejak Langkah</p>
                            <h2 class="section-heading">Sejarah Singkat</h2>
                        </div>
                        <div class="text-content">
                            {!! nl2br(e($profilPanti->sejarah_singkat_deskripsi)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- VISI & MISI --}}
    @if($profilPanti->visi_deskripsi || $profilPanti->misi_deskripsi)
    <section id="visi-misi-detail" class="profil-content-section profil-animated-section">
        <div class="container">
            <div class="row align-items-center gy-4 gx-lg-5">
                @if($profilPanti->visi_misi_img)
                <div class="col-lg-5 image-column-wrapper">
                     <div class="image-box-placeholder">
                        <img src="{{ asset('storage/' . $profilPanti->visi_misi_img) }}" alt="Visi Misi {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                    </div>
                </div>
                <div class="col-lg-7">
                @else
                <div class="col-lg-12">
                @endif
                    <div class="content-box">
                        <div class="section-header">
                            <p class="text-muted small">Arah dan Tujuan</p>
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
            </div>
        </div>
    </section>
    @endif

{{-- TIM PENDIRI --}}
    @if(isset($profilPanti) && ($profilPanti->tim_pendiri_img_utama || (isset($timPendiri) && $timPendiri->isNotEmpty())))
    <section id="tim-pendiri-detail" class="profil-content-section profil-animated-section">
        <div class="container">
            <div class="row align-items-center gy-4 gx-lg-5 flex-lg-row-reverse">
                @if($profilPanti->tim_pendiri_img_utama)
                <div class="col-lg-5 image-column-wrapper">
                    <div class="image-box-placeholder">
                        <img src="{{ asset('storage/' . $profilPanti->tim_pendiri_img_utama) }}" alt="Tim Pendiri {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                    </div>
                </div>
                @endif
                @if(isset($timPendiri) && $timPendiri->isNotEmpty())
                <div class="{{ $profilPanti->tim_pendiri_img_utama ? 'col-lg-7' : 'col-lg-12' }}">
                    <div class="content-box">
                        <div class="section-header">
                            <p class="text-muted small">Para Perintis</p>
                            <h2 class="section-heading">Tim Pendiri</h2>
                        </div>
                        <div class="anggota-list">
                            @foreach($timPendiri as $pendiri)
                                <div class="anggota-list-item"> {{-- Wrapper untuk setiap anggota agar deskripsi bisa di bawahnya --}}
                                    <div class="d-flex align-items-center w-100"> {{-- Wrapper untuk avatar dan info dasar --}}
                                        @if($pendiri->foto_pendiri)
                                            <img src="{{ asset('storage/' . $pendiri->foto_pendiri) }}" alt="{{ $pendiri->nama_pendiri }}" class="anggota-avatar">
                                        @else
                                            <div class="anggota-avatar placeholder-avatar">
                                                <span>{{ strtoupper(substr($pendiri->nama_pendiri, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <div class="anggota-info">
                                            <h5 class="anggota-nama">{{ $pendiri->nama_pendiri }}</h5>
                                            <p class="anggota-jabatan mb-0">{{ $pendiri->peran_atau_jabatan }}</p>
                                        </div>
                                        {{-- Tombol Toggle Detail hanya jika ada deskripsi --}}
                                        @if(!empty(trim($pendiri->deskripsi_kontribusi)))
                                            <button type="button" class="btn-toggle-deskripsi ms-auto" data-target-deskripsi="deskripsi-pendiri-{{ $loop->index }}">
                                                Detail <i class="fas fa-chevron-down arrow-icon"></i>
                                            </button>
                                        @endif
                                    </div>
                                    {{-- Area Deskripsi Kontribusi (awalnya tersembunyi) --}}
                                    @if(!empty(trim($pendiri->deskripsi_kontribusi)))
                                    <div id="deskripsi-pendiri-{{ $loop->index }}" class="anggota-deskripsi-kontribusi">
                                        <p>{!! nl2br(e($pendiri->deskripsi_kontribusi)) !!}</p>
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @elseif (!$profilPanti->tim_pendiri_img_utama)
                    <div class="col-12">
                        <div class="content-box text-center">
                             <p class="text-muted">Informasi tim pendiri belum tersedia.</p>
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

        <div class="row align-items-center gy-4 gx-lg-5">
            @if($profilPanti->struktur_organisasi_img_utama)
            <div class="col-lg-5 image-column-wrapper">
                <div class="image-box-placeholder">
                        <img src="{{ asset('storage/' . $profilPanti->struktur_organisasi_img_utama) }}" alt="Struktur Organisasi {{ $identitasPanti->nama_panti ?? 'Panti Asuhan' }}" class="content-image">
                    </div>
            </div>
            @endif
            @if(isset($strukturAnggota) && $strukturAnggota->isNotEmpty())
            <div class="{{ $profilPanti->struktur_organisasi_img_utama ? 'col-lg-7' : 'col-lg-12' }}">
                <div class="content-box">
                    <div class="section-header">
                        <p class="text-muted small">Kerangka Kerja</p>
                        <h2 class="section-heading">Struktur Organisasi</h2>
                    </div>
                    <div class="anggota-list">
                        @foreach($strukturAnggota as $anggota)
                            {{-- MODIFIKASI DIMULAI DI SINI untuk setiap item --}}
                            <div class="anggota-list-item">
                                <div class="anggota-main-info"> {{-- Wrapper BARU --}}
                                    @if($anggota->foto_anggota)
                                        <img src="{{ asset('storage/' . $anggota->foto_anggota) }}" alt="{{ $anggota->nama_anggota }}" class="anggota-avatar">
                                    @else
                                        <div class="anggota-avatar placeholder-avatar">
                                           <span>{{ strtoupper(substr($anggota->nama_anggota, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                    <div class="anggota-info">
                                        <h5 class="anggota-nama">{{ $anggota->nama_anggota }}</h5>
                                        <p class="anggota-jabatan mb-0">{{ $anggota->jabatan }}</p>
                                    </div>
                                    @if(!empty(trim($anggota->deskripsi_singkat)))
                                        <button type="button" class="btn-toggle-deskripsi ms-auto" data-target-deskripsi="deskripsi-struktur-{{ $loop->index }}">
                                            Detail <i class="fas fa-chevron-down arrow-icon"></i>
                                        </button>
                                    @endif
                                </div>
                                @if(!empty(trim($anggota->deskripsi_singkat)))
                                <div id="deskripsi-struktur-{{ $loop->index }}" class="anggota-deskripsi-kontribusi">
                                    <p>{!! nl2br(e($anggota->deskripsi_singkat)) !!}</p>
                                </div>
                                @endif
                            </div>
                             {{-- MODIFIKASI SELESAI DI SINI --}}
                        @endforeach
                    </div>
                </div>
            </div>
            @elseif (!$profilPanti->struktur_organisasi_img_utama)
                <div class="col-12">
                        <div class="content-box text-center">
                             <p class="text-muted">Informasi struktur organisasi belum tersedia.</p>
                        </div>
                    </div>
            @endif
        </div>
    </div>
</section>
@endif

@else
    <div class="empty-state">
        <div class="container">
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
                rootMargin: '-15% 0px -15% 0px', // Lebih cepat trigger saat mendekati viewport
                threshold: 0.2 // Trigger saat 20% elemen terlihat
            };

            const observer = new IntersectionObserver(function (entries, observerInstance) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                         // observerInstance.unobserve(entry.target); // Opsional: Hentikan observasi setelah animasi pertama
                    } else {
                        // Jika ingin animasi berulang saat scroll keluar-masuk viewport (opsional)
                        // entry.target.classList.remove('is-visible');
                    }
                });
            }, options);

            if (sections.length) {
                sections.forEach(section => {
                    observer.observe(section);
                });
            }

            const toggleButtons = document.querySelectorAll('.btn-toggle-deskripsi');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.dataset.targetDeskripsi;
                    const deskripsiElement = document.getElementById(targetId);
                    const arrowIcon = this.querySelector('.arrow-icon');

                    if (deskripsiElement) {
                        if (deskripsiElement.style.display === 'block') {
                            deskripsiElement.style.display = 'none';
                            this.classList.remove('active');
                            if(arrowIcon) arrowIcon.style.transform = 'rotate(0deg)';
                        } else {
                            deskripsiElement.style.display = 'block';
                            this.classList.add('active');
                            if(arrowIcon) arrowIcon.style.transform = 'rotate(180deg)';
                        }
                    }
                });
            });

            // Fungsi untuk scroll-to-hash jika ada di URL
            if (window.location.hash) {
                const hash = window.location.hash;
                const targetElement = document.querySelector(hash);
                if (targetElement) {
                    // Beri sedikit delay agar layout stabil sebelum scroll
                    setTimeout(() => {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start' // Atau 'center' jika prefer
                        });
                    }, 200);
                }
            }
        });
    </script>
@endpush