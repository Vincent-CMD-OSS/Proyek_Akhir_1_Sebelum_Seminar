@extends('layouts.app')

@section('content')

{{-- Hero Section Fullscreen Background --}}
<section class="vh-100 d-flex align-items-center justify-content-center text-white position-relative" 
         style="background: url('https://hopevillage.org.au/images/cache/content/hope-village-children-doing-chores-1.96825700.jpg') center center / cover no-repeat;">
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.5); z-index: 1;"></div>

    <div class="text-center px-4" style="z-index: 2;" data-aos="zoom-in" data-aos-duration="1000">
        <h1 class="display-4 fw-bold">Kegiatan di Panti Asuhan Rumah Harapan</h1>
        <p class="fs-5">Berbagai aktivitas positif yang dilakukan oleh anak-anak kami setiap hari</p>
    </div>
</section>

{{-- Section Daftar Kegiatan --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Aktivitas Harian</h2>

        <div class="row g-4">

            {{-- Kegiatan 1 --}}
            <div class="col-md-6" data-aos="fade-right">
                <div class="card h-100 shadow-sm">
                    <img src="https://source.unsplash.com/600x400/?study,children" class="card-img-top" alt="Belajar">
                    <div class="card-body">
                        <h5 class="card-title">Belajar Sore Hari</h5>
                        <p class="card-text text-justify">Setiap sore anak-anak berkumpul untuk belajar bersama, didampingi oleh para relawan dan pengasuh.</p>
                    </div>
                </div>
            </div>

            {{-- Kegiatan 2 --}}
            <div class="col-md-6" data-aos="fade-left">
                <div class="card h-100 shadow-sm">
                    <img src="https://source.unsplash.com/600x400/?children,helping" class="card-img-top" alt="Sosial">
                    <div class="card-body">
                        <h5 class="card-title">Kegiatan Sosial</h5>
                        <p class="card-text text-justify">Anak-anak diajarkan nilai empati melalui kegiatan sosial bersama warga sekitar dan kunjungan ke panti lain.</p>
                    </div>
                </div>
            </div>

            {{-- Kegiatan 3 --}}
            <div class="col-md-6" data-aos="fade-up">
                <div class="card h-100 shadow-sm">
                    <img src="https://source.unsplash.com/600x400/?kids,chores" class="card-img-top" alt="Kegiatan Rumah">
                    <div class="card-body">
                        <h5 class="card-title">Tugas Harian</h5>
                        <p class="card-text text-justify">Sejak dini, anak-anak dilatih mandiri lewat tugas sederhana seperti membersihkan ruangan dan merapikan tempat tidur.</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Link kembali --}}
        <div class="text-center mt-5">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">← Kembali ke Beranda</a>
        </div>
    </div>
</section>

@endsection
