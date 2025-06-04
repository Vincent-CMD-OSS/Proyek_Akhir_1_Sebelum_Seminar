{{-- resources/views/public/donasi_public.blade.php --}}
@extends('layouts.user')

@section('title', 'Donasi - ' . ($identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan'))

@push('styles')
<style>
    :root {
        --color-primary-donasi: #87CEEB;
        --color-primary-donasi-darker: #5F9EA0;
        --color-secondary-donasi: #a2d2ff;
        --color-bg-page-donasi: #f8fcff;
        --color-bg-content-donasi: #ffffff;
        --color-text-header-donasi: #2c3e50;
        --color-text-body-donasi: #34495e;
        --color-text-muted-donasi: #7f8c8d;
        --color-border-soft-donasi: #e0e7ef;
        --font-family-donasi: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        --shadow-form-donasi: 0 8px 25px rgba(135, 206, 235, 0.15);
        --border-radius-card-donasi: 0.75rem;
        --border-radius-button-donasi: 0.5rem;
    }

    body {
        font-family: var(--font-family-donasi);
        background-color: var(--color-bg-page-donasi);
        color: var(--color-text-body-donasi);
        line-height: 1.7;
        margin: 0;
        overflow-x: hidden;
    }

    .donasi-page-container { }

    .donasi-hero-full-screen {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem 1.5rem;
        position: relative;
        color: var(--color-text-header-donasi);
        background-image: linear-gradient(135deg, rgba(232, 245, 255, 0.8) 0%, rgba(255, 255, 255, 0.6) 100%),
                          url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
        background-size: cover;
        background-position: center;
    }
    .donasi-hero-content-wrapper { max-width: 750px; position: relative; z-index: 2; }
    .donasi-hero-icon-main { font-size: 4.5rem; color: var(--color-primary-donasi); margin-bottom: 1.5rem; display: inline-block; text-shadow: 2px 2px 8px rgba(135, 206, 235, 0.2); }
    .donasi-hero-main-title { font-size: 3rem; font-weight: 700; color: var(--color-text-header-donasi); margin-bottom: 1rem; line-height: 1.25; }
    .donasi-hero-main-subtitle { font-size: 1.2rem; color: var(--color-text-body-donasi); max-width: 680px; margin: 0 auto 2.5rem auto; }
    .donasi-hero-cta-button { display: inline-block; padding: 0.9rem 2.5rem; background: linear-gradient(135deg, var(--color-primary-donasi), var(--color-primary-donasi-darker)); color: white; border: none; border-radius: var(--border-radius-button-donasi); font-size: 1.1rem; font-weight: 600; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(135, 206, 235, 0.3); }
    .donasi-hero-cta-button:hover { background: linear-gradient(135deg, var(--color-primary-donasi-darker), var(--color-primary-donasi)); transform: translateY(-3px) scale(1.02); box-shadow: 0 6px 20px rgba(135, 206, 235, 0.4); color: white; }
    .donasi-hero-cta-button i { margin-right: 0.75rem; }

    .donasi-content-section {
        padding: 5rem 1.5rem;
        background-color: var(--color-bg-content-donasi);
    }
    .donasi-content-section:nth-child(even) {
    }


    .donasi-section-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .donasi-info-block {
        margin-bottom: 3rem;
    }
    .donasi-info-block:last-child { margin-bottom: 0; }
    .donasi-info-block h2 { font-size: 1.9rem; font-weight: 600; color: var(--color-text-header-donasi); margin-top: 0; margin-bottom: 1.5rem; display: flex; align-items: center; border-bottom: 2px solid var(--color-primary-donasi); padding-bottom: 0.75rem; }
    .donasi-info-block h2 i { color: var(--color-primary-donasi); font-size: 1.6rem; margin-right: 1rem; }
    .donasi-info-block p { margin-bottom: 1.25rem; color: var(--color-text-body-donasi); font-size: 1.05rem; }
    .donasi-info-block ul, .donasi-info-block ol { padding-left: 0.5rem; margin-bottom: 0; list-style-type: none; }
    .donasi-info-block li { margin-bottom: 0.85rem; padding-left: 1.8rem; position: relative; font-size: 1.05rem; }
    .donasi-info-block ul li::before { content: "\f00c"; font-family: 'Font Awesome 5 Free'; font-weight: 900; color: var(--color-primary-donasi); position: absolute; left: 0; top: 2px; font-size: 1em; }
    .donasi-info-block ol { counter-reset: step-counter; }
    .donasi-info-block ol li::before { counter-increment: step-counter; content: counter(step-counter); background-color: var(--color-secondary-donasi); color: white; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 600; position: absolute; left: 0; top: 0px; }
    .donasi-info-block strong { font-weight: 600; color: var(--color-text-header-donasi); }
    .alert-custom-info-donasi { background-color: #e7f5ff; border-left: 5px solid var(--color-primary-donasi); color: #004085; padding: 1.25rem; border-radius: var(--border-radius-button-donasi); margin-top: 1.75rem; font-size: 0.95rem; }
    .alert-custom-info-donasi i { margin-right: 0.6rem; }

    .donasi-form-kontak-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2.5rem;
    }
    .donasi-form-main {
        background-color: var(--color-bg-content-donasi);
        padding: 2.5rem;
        border-radius: var(--border-radius-card-donasi);
        box-shadow: var(--shadow-form-donasi);
    }
    .donasi-form-main h2 { text-align: center; font-size: 2rem; font-weight: 600; color: var(--color-text-header-donasi); margin-bottom: 0.75rem; }
    .donasi-form-main .form-subtitle { text-align: center; color: var(--color-text-muted-donasi); margin-bottom: 2.5rem; font-size: 1.05rem; }
    .form-group { margin-bottom: 1.75rem; }
    .form-label { font-weight: 500; color: var(--color-text-header-donasi); margin-bottom: 0.6rem; display: block; font-size: 0.95rem; }
    .form-control-donasi, .form-select-donasi { width: 100%; padding: 0.9rem 1.1rem; font-size: 1rem; font-family: inherit; color: var(--color-text-body-donasi); background-color: var(--color-bg-page-donasi); border: 1px solid var(--color-border-soft-donasi); border-radius: var(--border-radius-button-donasi); transition: border-color 0.2s ease, box-shadow 0.2s ease; }
    .form-control-donasi:focus, .form-select-donasi:focus { border-color: var(--color-primary-donasi); outline: 0; box-shadow: 0 0 0 3px rgba(135, 206, 235, 0.2); background-color: var(--color-bg-content-donasi); }
    textarea.form-control-donasi { min-height: 120px; }
    .btn-submit-donasi-form { background: linear-gradient(135deg, var(--color-primary-donasi), var(--color-primary-donasi-darker)); border: none; color: white; padding: 0.9rem 1.8rem; font-size: 1.05rem; font-weight: 600; border-radius: var(--border-radius-button-donasi); cursor: pointer; transition: all 0.25s ease-in-out; width: 100%; text-align: center; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(135, 206, 235, 0.25); }
    .btn-submit-donasi-form:hover { background: linear-gradient(135deg, var(--color-primary-donasi-darker), var(--color-primary-donasi)); transform: translateY(-2px); box-shadow: 0 6px 18px rgba(135, 206, 235, 0.35); }
    .btn-submit-donasi-form i { margin-right: 0.8rem; font-size: 1.2em; }
    .alert-danger-donasi { background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 1.25rem; border-radius: var(--border-radius-button-donasi); margin-bottom: 1.75rem; border-left: 5px solid #b71c1c; }

    .donasi-kontak-sidebar {
        padding: 1rem 0 0 1rem;
        height: fit-content;
    }
    .donasi-form-kontak-grid > .donasi-kontak-sidebar { border-left: 1px solid var(--color-border-soft-donasi); }
    .donasi-kontak-sidebar h3 { font-size: 1.5rem; font-weight: 600; color: var(--color-text-header-donasi); margin-top: 0; margin-bottom: 1.5rem; display: flex; align-items: center; }
    .donasi-kontak-sidebar h3 i { color: var(--color-primary-donasi-darker); font-size: 1.4rem; margin-right: 0.75rem; }
    .donasi-kontak-sidebar p { margin-bottom: 1.5rem; font-size: 0.95rem; }
    .donasi-kontak-sidebar ul { list-style-type: none; padding-left: 0; margin-bottom: 0; }
    .donasi-kontak-sidebar li { display: flex; align-items: flex-start; margin-bottom: 1.25rem; font-size: 0.95rem; }
    .donasi-kontak-sidebar li i { color: var(--color-primary-donasi); font-size: 1.2rem; margin-right: 0.9rem; width: 22px; text-align: center; margin-top: 2px; }
    .donasi-kontak-sidebar a { color: var(--color-primary-donasi-darker); text-decoration: none; font-weight: 500; transition: color 0.2s ease; }
    .donasi-kontak-sidebar a:hover { color: var(--color-primary-donasi); text-decoration: underline; }

    .animate-on-scroll {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .animate-on-scroll.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
    .animate-on-scroll.delay-1 { transition-delay: 0.1s; }
    .animate-on-scroll.delay-2 { transition-delay: 0.2s; }
    .animate-on-scroll.delay-3 { transition-delay: 0.3s; }

    @media (max-width: 992px) {
        .donasi-form-kontak-grid { grid-template-columns: 1fr; }
        .donasi-kontak-sidebar { margin-top: 2.5rem; padding-left: 0; border-left: none; border-top: 1px solid var(--color-border-soft-donasi); padding-top: 2rem; }
    }
    @media (max-width: 768px) {
        .donasi-content-section { padding: 3rem 1rem; }
        .donasi-hero-main-title { font-size: 2.4rem; }
        .donasi-hero-main-subtitle { font-size: 1.1rem; }
        .donasi-info-block h2 { font-size: 1.6rem; }
        .donasi-form-main { padding: 2rem 1.5rem; }
        .donasi-form-main h2 { font-size: 1.7rem; }
        .donasi-kontak-sidebar h3 { font-size: 1.3rem; }
    }
     @media (max-width: 576px) {
        .donasi-hero-main-title { font-size: 2rem; }
        .donasi-hero-main-subtitle { font-size: 1rem; }
        .donasi-content-section { padding: 2.5rem 1rem; }
        .donasi-info-block h2 { font-size: 1.4rem; padding-bottom: 0.5rem;}
        .donasi-info-block p, .donasi-info-block li { font-size: 0.95rem; }
        .donasi-form-main { padding: 1.5rem 1rem; }
     }
</style>
@endpush

@section('content')
<div class="donasi-page-container">

    <section class="donasi-hero-full-screen">
        <div class="donasi-hero-content-wrapper">
            <h1 class="donasi-hero-main-title">Berbagi Kebaikan, Mengubah Kehidupan</h1>
            <p class="donasi-hero-main-subtitle">
                Setiap donasi Anda, sekecil apapun, adalah langkah besar menuju masa depan yang lebih cerah untuk anak-anak di {{ $identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan' }}.
            </p>
            <a href="#form-donasi-anchor" class="donasi-hero-cta-button" onclick="event.preventDefault(); document.getElementById('form-donasi-anchor').scrollIntoView({behavior: 'smooth'});">
                <i class="fas fa-hand-holding-heart"></i> Mulai Berdonasi Sekarang
            </a>
        </div>
    </section>

    {{-- SECTION 1: INFO PENTING & BENTUK DUKUNGAN --}}
    <section class="donasi-content-section">
        <div class="donasi-section-container">
            <div class="donasi-info-block animate-on-scroll">
                <h2><i class="fas fa-star"></i>Mengapa Donasi Anda Begitu Berarti?</h2>
                <p>Dukungan tulus Anda adalah pilar utama yang memungkinkan kami untuk secara konsisten menyediakan lingkungan yang aman, penuh kasih, dan mendukung perkembangan optimal bagi setiap anak, yang mencakup:</p>
                <ul>
                    <li>Pemenuhan kebutuhan esensial sehari-hari: nutrisi seimbang, pakaian yang layak, dan tempat tinggal yang nyaman.</li>
                    <li>Akses terhadap pendidikan formal dan informal yang berkualitas, mulai dari buku hingga dukungan biaya sekolah.</li>
                    <li>Fasilitasi pengembangan bakat dan minat melalui beragam kegiatan ekstrakurikuler serta pelatihan keterampilan.</li>
                    <li>Jaminan kesehatan melalui pemeriksaan rutin, perawatan medis, dan edukasi pola hidup sehat.</li>
                    <li>Pemeliharaan operasional panti, memastikan semua fasilitas berfungsi baik dan layanan berjalan lancar.</li>
                </ul>
            </div>

            <div class="donasi-info-block animate-on-scroll delay-1"> {{-- delay agar muncul setelah blok pertama --}}
                <h2><i class="fas fa-gifts"></i>Bentuk Dukungan yang Dapat Anda Berikan</h2>
                <p>Kami dengan senang hati menerima berbagai bentuk uluran tangan Anda untuk membantu memenuhi kebutuhan anak-anak kami:</p>
                <ul>
                    <li><strong>Donasi Dana:</strong> Memberikan fleksibilitas bagi kami untuk mengalokasikan bantuan ke pos-pos kebutuhan yang paling mendesak. (Detail rekening akan kami sampaikan melalui konfirmasi WhatsApp).</li>
                    <li><strong>Kebutuhan Pangan Pokok:</strong> Seperti beras, minyak goreng, gula pasir, mie instan, telur, susu formula/UHT, dan bahan makanan kering lainnya.</li>
                    <li><strong>Perlengkapan Pendidikan:</strong> Alat tulis lengkap, buku pelajaran sesuai kurikulum, buku bacaan anak, seragam sekolah, tas, dan sepatu.</li>
                    <li><strong>Perlengkapan Harian & Kebersihan:</strong> Pakaian layak pakai untuk berbagai usia anak, perlengkapan mandi (sabun, sampo, sikat gigi, pasta gigi), deterjen, dan popok sekali pakai (jika ada balita).</li>
                    <li><strong>Dukungan Kesehatan & Lainnya:</strong> Vitamin anak, suplemen makanan, obat-obatan ringan (P3K), mainan edukatif, atau bahkan keahlian Anda sebagai relawan (silakan diskusikan dengan kami).</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- SECTION 2: CARA BERDONASI --}}
    <section class="donasi-content-section">
        <div class="donasi-section-container">
            <div class="donasi-info-block animate-on-scroll">
                <h2><i class="fas fa-shoe-prints"></i>Langkah Mudah untuk Berbagi Kebaikan</h2>
                <p>Proses berdonasi kami rancang agar mudah dan aman bagi Anda:</p>
                <ol>
                    <li><strong>Isi Formulir Konfirmasi:</strong> Luangkan waktu sejenak untuk mengisi data diri Anda dan detail rencana donasi pada formulir yang tersedia di bawah ini.</li>
                    <li><strong>Kirim Konfirmasi via WhatsApp:</strong> Setelah formulir terisi, klik tombol konfirmasi. Anda akan otomatis diarahkan ke aplikasi WhatsApp kami, lengkap dengan pesan yang sudah tersusun.</li>
                    <li><strong>Tunggu Respons Admin Kami:</strong> Tim admin kami akan segera merespons pesan WhatsApp Anda untuk memberikan detail lebih lanjut mengenai proses penyaluran donasi (misalnya, nomor rekening resmi panti atau alamat pengiriman barang).</li>
                    <li><strong>Salurkan Donasi Anda:</strong> Silakan lakukan transfer dana ke rekening yang telah diinformasikan atau kirimkan bantuan barang Anda ke alamat panti sesuai petunjuk.</li>
                    <li><strong>Terima Kabar Baik dari Kami:</strong> Setelah donasi Anda kami terima, kami akan segera mengirimkan konfirmasi penerimaan dan ucapan terima kasih.</li>
                </ol>
                <div class="alert-custom-info-donasi">
                    <i class="fas fa-shield-alt"></i>
                    <strong>Penting untuk Keamanan Anda:</strong> Untuk menghindari hal yang tidak diinginkan, kami mengimbau Anda untuk hanya melakukan transfer dana ke nomor rekening resmi atas nama panti yang dikonfirmasikan secara langsung oleh admin kami melalui WhatsApp setelah Anda mengisi formulir.
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 3: FORM & KONTAK --}}
    <section class="donasi-content-section" id="form-donasi-anchor">
        <div class="donasi-section-container">
            <div class="donasi-form-kontak-grid animate-on-scroll"> {{-- Animasikan grid ini sebagai satu kesatuan --}}
                <div class="donasi-form-main">
                    <h2>Formulir Konfirmasi Donasi Anda</h2>
                    <p class="form-subtitle">Isi data berikut untuk memulai proses donasi.</p>

                    @if ($errors->any())
                        <div class="alert-danger-donasi">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('public.donasi.kirim') }}" method="POST" id="formDonasiWA">
                        @csrf
                        <div class="form-group">
                            <label for="nama_donatur" class="form-label">Nama Lengkap Donatur <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-donasi" id="nama_donatur" name="nama_donatur" value="{{ old('nama_donatur') }}" required placeholder="Nama Anda sesuai identitas">
                        </div>
                        <div class="form-group">
                            <label for="email_donatur" class="form-label">Alamat Email (Opsional)</label>
                            <input type="email" class="form-control-donasi" id="email_donatur" name="email_donatur" value="{{ old('email_donatur') }}" placeholder="Untuk update informasi (jika berkenan)">
                        </div>
                        <div class="form-group">
                            <label for="telepon_donatur" class="form-label">Nomor WhatsApp Aktif <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control-donasi" id="telepon_donatur" name="telepon_donatur" value="{{ old('telepon_donatur') }}" placeholder="Contoh: 081234567890" required>
                        </div>
                        <div class="form-group">
                            <label for="donasi_untuk" class="form-label">Donasi Ini Ditujukan Untuk <span class="text-danger">*</span></label>
                            <select class="form-select-donasi" id="donasi_untuk" name="donasi_untuk" required>
                                <option value="" disabled {{ old('donasi_untuk') ? '' : 'selected' }}>-- Pilih Tujuan Donasi --</option>
                                <option value="Umum" {{ old('donasi_untuk') == 'Umum' ? 'selected' : '' }}>Donasi Umum (Operasional & Kebutuhan Panti)</option>
                                @if(isset($kebutuhanAktif) && $kebutuhanAktif->isNotEmpty())
                                    <optgroup label="Dukung Program Kebutuhan Spesifik:">
                                        @foreach($kebutuhanAktif as $kebutuhan)
                                            <option value="kebutuhan_{{ $kebutuhan->id }}" {{ (old('donasi_untuk') == 'kebutuhan_'.$kebutuhan->id) || (request()->get('kebutuhan_id') == $kebutuhan->id) ? 'selected' : '' }}>
                                                {{ Str::limit($kebutuhan->nama_kebutuhan, 70) }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endif
                                <option value="Lainnya" {{ old('donasi_untuk') == 'Lainnya' ? 'selected' : '' }}>Lainnya (Jelaskan pada keterangan)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan_tambahan" class="form-label">Estimasi Nilai / Rincian Barang / Pesan (Opsional)</label>
                            <textarea class="form-control-donasi" id="keterangan_tambahan" name="keterangan_tambahan" rows="4" placeholder="Contoh: Rp 500.000,- / 10 kg beras & 5 liter minyak / Semoga berkah.">{{ old('keterangan_tambahan', request()->get('kebutuhan_id') ? 'Donasi untuk ' . ( $kebutuhanAktif->firstWhere('id', request()->get('kebutuhan_id'))->nama_kebutuhan ?? '' ) : '') }}</textarea>
                        </div>

                        <button type="submit" class="btn-submit-donasi-form">
                            <i class="fab fa-whatsapp"></i> Konfirmasi & Lanjut ke WhatsApp
                        </button>
                    </form>
                </div>

                <aside class="donasi-kontak-sidebar">
                    <h3><i class="fas fa-info-circle"></i>Butuh Bantuan atau Ada Pertanyaan?</h3>
                    <p>Tim kami siap membantu Anda. Jangan ragu untuk menghubungi kami melalui salah satu kontak di bawah ini:</p>
                    <ul>
                        @if(isset($identitasPanti) && $identitasPanti->telepon)
                        <li><i class="fas fa-phone-square-alt"></i><div><strong>Telepon/WhatsApp:</strong><br><a href="https://wa.me/{{ $nomorWaPanti ?? '' }}" target="_blank" rel="noopener noreferrer">{{ $identitasPanti->telepon }}</a></div></li>
                        @endif
                        @if(isset($identitasPanti) && $identitasPanti->email)
                        <li><i class="fas fa-envelope-open-text"></i><div><strong>Email:</strong><br><a href="mailto:{{ $identitasPanti->email }}">{{ $identitasPanti->email }}</a></div></li>
                        @endif
                        @if(isset($identitasPanti) && $identitasPanti->alamat_lengkap)
                        <li><i class="fas fa-map-marked-alt"></i><div><strong>Alamat Kunjungan Langsung:</strong><br>{{ $identitasPanti->alamat_lengkap }}</div></li>
                        @endif
                        @if( (empty($identitasPanti->telepon)) && (empty($identitasPanti->email)) && (empty($identitasPanti->alamat_lengkap)) )
                            <li><i class="fas fa-exclamation-triangle"></i><span>Informasi kontak panti saat ini belum tersedia. Mohon cek kembali nanti.</span></li>
                        @endif
                    </ul>
                </aside>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formDonasi = document.getElementById('formDonasiWA');
        if(formDonasi) {
            formDonasi.addEventListener('submit', function(event) {
                const teleponInput = document.getElementById('telepon_donatur');
                const donasiUntukSelect = document.getElementById('donasi_untuk');

                if (teleponInput) {
                    const teleponValue = teleponInput.value.replace(/[\s-()+]/g, '');
                    if (!/^(08)\d{8,12}$/.test(teleponValue)) {
                        alert('Mohon masukkan nomor WhatsApp yang valid (Contoh: 081234567890).');
                        event.preventDefault();
                        teleponInput.focus();
                        return false;
                    }
                }
                if (donasiUntukSelect && donasiUntukSelect.value === "") {
                    alert('Mohon pilih tujuan donasi Anda.');
                    event.preventDefault();
                    donasiUntukSelect.focus();
                    return false;
                }
            });
        }

        const urlParams = new URLSearchParams(window.location.search);
        const kebutuhanIdFromUrl = urlParams.get('kebutuhan_id');
        const donasiUntukSelect = document.getElementById('donasi_untuk');

        if (kebutuhanIdFromUrl && donasiUntukSelect) {
            const optionToSelect = donasiUntukSelect.querySelector(`option[value="kebutuhan_${kebutuhanIdFromUrl}"]`);
            if (optionToSelect) {
                optionToSelect.selected = true;
            }
        }

        const animatedElements = document.querySelectorAll('.animate-on-scroll');

        if (animatedElements.length > 0) {
            const observerOptions = {
                threshold: 0.15,
                rootMargin: "0px 0px -50px 0px"
            };

            const observer = new IntersectionObserver(function(entries, observerInstance) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observerInstance.unobserve(entry.target); // Ini ya
                    } else {
                        entry.target.classList.remove('is-visible'); // Ini juga ya (Entah yang mana yang mungkin)
                    }
                });
            }, observerOptions);

            animatedElements.forEach(el => {
                observer.observe(el);
            });
        }
    });
</script>
@endpush