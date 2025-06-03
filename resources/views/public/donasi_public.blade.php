{{-- resources/views/public/donasi_public.blade.php --}}
@extends('layouts.user')

@section('title', 'Donasi - ' . ($identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan'))

@push('styles')
<style>
    :root {
        --color-bg-pattern: #f0f4f8; /* Latar sedikit lebih gelap untuk variasi */
        --color-bg-light: #f8fafc;
        --color-bg-white: #ffffff;
        --color-primary-blue: #87CEEB;
        --color-primary-blue-darker: #5F9EA0; /* Biru sedikit lebih tua untuk kontras */
        --color-accent-yellow: #FFDE59;
        --color-accent-yellow-darker: #FFC107;
        --color-success-green: #4CAF50; /* Hijau yang lebih cerah */
        --color-success-green-darker: #388E3C;
        --color-text-header: #2c3e50; /* Warna header lebih gelap dan netral */
        --color-text-body: #34495e;   /* Warna body sedikit lebih terang */
        --color-text-muted: #7f8c8d;
        --color-border-soft: #dfe6e9;
        --font-family-sans: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; /* Ganti ke Poppins */
        --shadow-subtle: 0 2px 8px rgba(0, 0, 0, 0.06);
        --shadow-medium: 0 6px 12px rgba(0, 0, 0, 0.08);
        --shadow-strong: 0 10px 20px rgba(0, 0, 0, 0.1);
        --border-radius-sm: 0.375rem; /* 6px */
        --border-radius-md: 0.625rem; /* 10px */
        --border-radius-lg: 0.875rem; /* 14px */
    }

    body {
        font-family: var(--font-family-sans);
        background-color: var(--color-bg-white); /* Default putih */
        color: var(--color-text-body);
        line-height: 1.75; /* Sedikit lebih lega */
        margin: 0;
        overflow-x: hidden; /* Mencegah scroll horizontal jika ada elemen keluar */
    }

    .donasi-page-container {
        padding-top: 60px; /* Jarak dari navbar jika fixed-top */
    }

    .donasi-section-wrapper { /* Pembungkus setiap section untuk background dan padding */
        padding: 4rem 1.5rem;
        position: relative; /* Untuk elemen absolut di dalamnya */
    }
    .donasi-section-wrapper:nth-child(odd) { /* Warna latar belang-seling */
        background-color: var(--color-bg-white);
    }
    .donasi-section-wrapper:nth-child(even) {
        background-color: var(--color-bg-pattern);
    }

    .donasi-content-area { /* Kontainer konten di dalam wrapper */
        max-width: 800px;
        margin: 0 auto;
        position: relative; /* Untuk z-index konten di atas elemen dekoratif */
        z-index: 2;
    }

    /* HERO DONASI */
    .donasi-hero-header .donasi-content-area {
        text-align: center;
    }
    .donasi-hero-icon {
        font-size: 4rem;
        color: var(--color-success-green);
        margin-bottom: 1rem;
        display: inline-block;
        filter: drop-shadow(0 4px 8px rgba(40, 167, 69, 0.2)); /* Shadow pada ikon */
    }
    .donasi-hero-title {
        font-size: 2.8rem;
        font-weight: 700;
        color: var(--color-text-header);
        margin-bottom: 0.75rem;
    }
    .donasi-hero-subtitle {
        font-size: 1.2rem;
        color: var(--color-text-muted);
        max-width: 650px;
        margin: 0 auto 1.5rem auto;
    }
    .donasi-hero-accent {
        width: 80px;
        height: 5px;
        background: linear-gradient(90deg, var(--color-primary-blue), var(--color-accent-yellow)); /* Gradasi untuk aksen */
        border-radius: 2.5px;
        margin: 0 auto;
    }

    /* SECTION CONTENT DONASI */
    .donasi-info-card { /* Mengganti .donasi-info-section */
        background-color: var(--color-bg-white);
        padding: 2rem 2.5rem; /* Padding lebih besar */
        border-radius: var(--border-radius-lg);
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-medium);
        border-left: 6px solid var(--color-primary-blue); /* Aksen garis kiri biru */
    }
    .donasi-info-card h2 {
        font-size: 1.8rem; /* Sedikit lebih besar */
        font-weight: 600;
        color: var(--color-text-header);
        margin-top: 0;
        margin-bottom: 1.5rem;
        display: flex; /* Untuk ikon dan teks */
        align-items: center;
    }
    .donasi-info-card h2 i { /* Ikon di judul section */
        color: var(--color-primary-blue);
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    .donasi-info-card p {
        margin-bottom: 1.25rem;
        color: var(--color-text-body);
    }
    .donasi-info-card ul,
    .donasi-info-card ol {
        padding-left: 1.25rem;
        margin-bottom: 0;
    }
    .donasi-info-card li {
        margin-bottom: 0.75rem;
        padding-left: 0.5rem; /* Jarak dari bullet/number */
        position: relative;
    }
    .donasi-info-card ul li::before { /* Custom bullet */
        content: "•";
        color: var(--color-primary-blue);
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1.25em; /* Posisi bullet */
        font-size: 1.2em;
    }
    .donasi-info-card ol { list-style-type: none; counter-reset: step-counter; }
    .donasi-info-card ol li::before {
        counter-increment: step-counter;
        content: counter(step-counter);
        background-color: var(--color-primary-blue);
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        font-weight: 600;
        margin-right: 0.75rem;
        position: absolute;
        left: -1.25em; /* Sesuaikan agar tidak overlap */
        top: 0;
    }
     .donasi-info-card ol li {
        padding-left: 2.5rem; /* Ruang lebih untuk nomor custom */
        min-height: 28px; /* Agar sejajar dengan nomor */
        display: flex;
        align-items: center;
    }

    .donasi-info-card strong {
        font-weight: 600;
        color: var(--color-text-header);
    }
    .alert-custom-info {
        background-color: #eef7ff; /* Biru sangat muda */
        border-left: 4px solid var(--color-primary-blue-darker);
        color: var(--color-text-body);
        padding: 1.25rem;
        border-radius: var(--border-radius-sm);
        margin-top: 1.5rem;
    }

    /* FORM DONASI */
    .donasi-form-card { /* Mengganti .donasi-form-wrapper */
        background-color: var(--color-bg-white); /* Form tetap putih bersih */
        padding: 2.5rem;
        border-radius: var(--border-radius-lg);
        margin-top: 1rem; /* Jarak dari section info sebelumnya */
        box-shadow: var(--shadow-strong); /* Shadow lebih kuat untuk form */
    }
    .donasi-form-card h2 {
        text-align: center;
        font-size: 2.1rem;
        font-weight: 600;
        color: var(--color-text-header);
        margin-bottom: 1rem;
    }
    .donasi-form-card .form-subtitle {
        text-align: center;
        color: var(--color-text-muted);
        margin-bottom: 2.5rem;
        font-size: 1.05rem;
    }

    .form-group {
        margin-bottom: 1.75rem; /* Jarak antar grup form lebih besar */
    }
    .form-label {
        font-weight: 500;
        color: var(--color-text-header);
        margin-bottom: 0.6rem;
        display: block;
        font-size: 0.95rem;
    }
    .form-control-custom,
    .form-select-custom {
        width: 100%;
        padding: 0.9rem 1.1rem; /* Padding input lebih besar */
        font-size: 1rem;
        font-family: inherit;
        color: var(--color-text-body);
        background-color: #fdfdfd; /* Background input sedikit off-white */
        border: 1px solid var(--color-border-soft);
        border-radius: var(--border-radius-md);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control-custom:focus,
    .form-select-custom:focus {
        border-color: var(--color-primary-blue);
        outline: 0;
        box-shadow: 0 0 0 3px rgba(135, 206, 235, 0.25);
        background-color: var(--color-bg-white);
    }
    textarea.form-control-custom {
        min-height: 130px;
    }
    .btn-submit-donasi {
        background: linear-gradient(135deg, var(--color-success-green), var(--color-success-green-darker));
        border: none;
        color: white;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600; /* Font lebih tebal */
        border-radius: var(--border-radius-md);
        cursor: pointer;
        transition: all 0.25s ease-in-out;
        width: 100%;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(40, 167, 101, 0.3); /* Shadow hijau */
    }
    .btn-submit-donasi:hover {
        background: linear-gradient(135deg, var(--color-success-green-darker), var(--color-success-green));
        transform: translateY(-2px) scale(1.01);
        box-shadow: 0 6px 15px rgba(40, 167, 101, 0.4);
    }
    .btn-submit-donasi:active {
        transform: translateY(0px) scale(1);
    }
    .btn-submit-donasi i {
        margin-right: 0.8rem;
        font-size: 1.25em;
    }
    .alert-danger-custom {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        padding: 1.25rem;
        border-radius: var(--border-radius-md);
        margin-bottom: 1.75rem;
        border-left: 5px solid #b71c1c;
    }

    /* KONTAK SECTION */
    .donasi-kontak-card { /* Mengganti .donasi-kontak-section */
        /* Mirip dengan .donasi-info-card */
        border-left-color: var(--color-accent-yellow); /* Aksen kuning untuk kontak */
    }
    .donasi-kontak-card h2 i {
        color: var(--color-accent-yellow-darker);
    }
    .donasi-kontak-card ul {
        list-style-type: none;
        padding-left: 0;
    }
    .donasi-kontak-card li {
        display: flex;
        align-items: center;
        margin-bottom: 1rem; /* Jarak lebih */
        position: static; /* Reset position agar tidak konflik dengan ::before dari info card */
        padding-left: 0;
    }
     .donasi-kontak-card li::before { /* Hapus ::before dari info card */
        content: none;
    }
    .donasi-kontak-card li i {
        color: var(--color-primary-blue-darker); /* Ikon biru lebih tua */
        font-size: 1.3rem; /* Ikon lebih besar */
        margin-right: 1rem;
        width: 24px;
        text-align: center;
    }
    .donasi-kontak-card a {
        color: var(--color-success-green-darker);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .donasi-kontak-card a:hover {
        color: var(--color-success-green);
        text-decoration: underline;
    }

    /* Decorative Elements (Opsional) */
    .decorative-shape {
        position: absolute;
        z-index: 1;
        opacity: 0.05; /* Sangat transparan */
        pointer-events: none; /* Agar tidak mengganggu interaksi */
    }
    .shape-circle {
        width: 300px; height: 300px;
        background-color: var(--color-primary-blue);
        border-radius: 50%;
        top: 10%; left: -100px;
    }
    .shape-dots { /* Anda perlu gambar SVG atau PNG untuk ini */
        /* background-image: url('path/to/dots-pattern.svg');
        width: 200px; height: 200px;
        bottom: 5%; right: -80px; */
    }


    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .donasi-section-wrapper { padding: 2.5rem 1rem; }
        .donasi-content-area { padding: 0 0.5rem; } /* Kurangi padding horizontal pada konten area */
        .donasi-hero-title { font-size: 2.2rem; }
        .donasi-hero-subtitle { font-size: 1.05rem; }
        .donasi-info-card { padding: 1.5rem; }
        .donasi-info-card h2 { font-size: 1.5rem; }
        .donasi-info-card h2 i { font-size: 1.3rem; }
        .donasi-form-card { padding: 2rem 1.5rem; }
        .donasi-form-card h2 { font-size: 1.75rem; }
        .btn-submit-donasi { padding: 0.85rem 1.5rem; font-size: 1rem; }
        .shape-circle, .shape-dots { display: none; } /* Sembunyikan bentuk dekoratif di mobile */
    }
</style>
@endpush

@section('content')
<div class="donasi-page-container">

    <section class="donasi-section-wrapper donasi-hero-header">
        {{-- <div class="decorative-shape shape-circle"></div> --}} {{-- Contoh elemen dekoratif --}}
        <div class="donasi-content-area">
            <span class="donasi-hero-icon">💝</span>
            <h1 class="donasi-hero-title">Bantu Mereka Tersenyum Hari Ini</h1>
            <p class="donasi-hero-subtitle">
                Satu tindakan kebaikan Anda adalah sejuta harapan bagi anak-anak di {{ $identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan' }}. Mari bersama wujudkan mimpi mereka.
            </p>
            <div class="donasi-hero-accent"></div>
        </div>
    </section>

    <section class="donasi-section-wrapper">
        <div class="donasi-content-area">
            <div class="donasi-info-card">
                <h2><i class="fas fa-lightbulb"></i>Mengapa Donasi Anda Penting?</h2>
                <p>Dukungan tulus Anda menjadi bahan bakar semangat kami untuk terus menyediakan yang terbaik bagi anak-anak, mencakup:</p>
                <ul>
                    <li>Kebutuhan dasar: gizi, pakaian layak, dan lingkungan tinggal yang aman.</li>
                    <li>Pendidikan berkualitas: dari buku hingga biaya sekolah.</li>
                    <li>Pengembangan diri: kegiatan ekstrakurikuler dan pelatihan keterampilan.</li>
                    <li>Kesehatan optimal: pemeriksaan rutin dan perawatan medis jika diperlukan.</li>
                    <li>Operasional panti: agar semua fasilitas terjaga dan layanan berjalan lancar.</li>
                </ul>
            </div>

            <div class="donasi-info-card">
                <h2><i class="fas fa-hand-holding-heart"></i>Bentuk Dukungan yang Kami Hargai</h2>
                <p>Kami menerima uluran tangan Anda dalam berbagai bentuk:</p>
                <ul>
                    <li><strong>Dana Tunai:</strong> Fleksibel untuk kebutuhan mendesak. (Detail rekening via WhatsApp)</li>
                    <li><strong>Kebutuhan Pokok:</strong> Sembako (beras, minyak, gula, dll.), susu, makanan instan.</li>
                    <li><strong>Perlengkapan Belajar:</strong> Alat tulis, buku pelajaran, seragam, tas sekolah.</li>
                    <li><strong>Pakaian & Perlengkapan Harian:</strong> Pakaian layak pakai (anak-anak), perlengkapan mandi.</li>
                    <li><strong>Dukungan Lain:</strong> Mainan edukatif, vitamin, obat-obatan ringan (silakan konfirmasi).</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="donasi-section-wrapper">
        <div class="donasi-content-area">
            <div class="donasi-info-card">
                <h2><i class="fas fa-list-ol"></i>Cara Mudah Berdonasi</h2>
                <ol>
                    <li><strong>Isi Formulir:</strong> Lengkapi data Anda dan detail donasi pada formulir di bawah ini.</li>
                    <li><strong>Konfirmasi via WhatsApp:</strong> Klik tombol konfirmasi, Anda akan diarahkan ke WhatsApp kami dengan pesan otomatis.</li>
                    <li><strong>Tunggu Arahan Admin:</strong> Tim kami akan segera merespons untuk detail penyaluran (No. Rekening/Alamat).</li>
                    <li><strong>Salurkan Donasi:</strong> Lakukan transfer dana atau kirimkan barang sesuai petunjuk.</li>
                    <li><strong>Terima Ucapan Terima Kasih:</strong> Kami akan mengkonfirmasi penerimaan donasi Anda.</li>
                </ol>
                <div class="alert-custom-info">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 8px; color: #004085;"></i>
                    <strong>Perhatian:</strong> Demi keamanan, mohon pastikan Anda hanya melakukan transfer ke nomor rekening resmi yang dikonfirmasi oleh admin kami melalui WhatsApp.
                </div>
            </div>
        </div>
    </section>

    <section class="donasi-section-wrapper" id="form-donasi-anchor">
        <div class="donasi-content-area">
            <div class="donasi-form-card">
                <h2>Formulir Konfirmasi Donasi</h2>
                <p class="form-subtitle">Langkah awal Anda untuk berbagi kebahagiaan.</p>

                @if ($errors->any())
                    <div class="alert-danger-custom">
                        <ul class="mb-0">
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
                        <input type="text" class="form-control-custom" id="nama_donatur" name="nama_donatur" value="{{ old('nama_donatur') }}" required placeholder="Nama sesuai identitas">
                    </div>
                    <div class="form-group">
                        <label for="email_donatur" class="form-label">Alamat Email (Opsional)</label>
                        <input type="email" class="form-control-custom" id="email_donatur" name="email_donatur" value="{{ old('email_donatur') }}" placeholder="Untuk update informasi (jika berkenan)">
                    </div>
                    <div class="form-group">
                        <label for="telepon_donatur" class="form-label">Nomor WhatsApp Aktif <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control-custom" id="telepon_donatur" name="telepon_donatur" value="{{ old('telepon_donatur') }}" placeholder="Format: 08xxxxxxxxxx" required>
                    </div>
                    <div class="form-group">
                        <label for="donasi_untuk" class="form-label">Tujuan Donasi <span class="text-danger">*</span></label>
                        <select class="form-select-custom" id="donasi_untuk" name="donasi_untuk" required>
                            <option value="" disabled {{ old('donasi_untuk') ? '' : 'selected' }}>-- Pilih peruntukan donasi --</option>
                            <option value="Umum" {{ old('donasi_untuk') == 'Umum' ? 'selected' : '' }}>Donasi Umum (Operasional & Kebutuhan Panti)</option>
                            @if(isset($kebutuhanAktif) && $kebutuhanAktif->isNotEmpty())
                                <optgroup label="Program Kebutuhan Mendesak:">
                                    @foreach($kebutuhanAktif as $kebutuhan)
                                        <option value="kebutuhan_{{ $kebutuhan->id }}" {{ old('donasi_untuk') == 'kebutuhan_'.$kebutuhan->id ? 'selected' : '' }}>
                                            {{ Str::limit($kebutuhan->nama_kebutuhan, 70) }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                            <option value="Lainnya" {{ old('donasi_untuk') == 'Lainnya' ? 'selected' : '' }}>Lainnya (Mohon jelaskan di keterangan)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_tambahan" class="form-label">Keterangan / Detail Barang (Opsional)</label>
                        <textarea class="form-control-custom" id="keterangan_tambahan" name="keterangan_tambahan" rows="4" placeholder="Contoh: 5 kg beras, 10 buku tulis, atau 'semoga bermanfaat untuk pendidikan anak-anak'.">{{ old('keterangan_tambahan') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit-donasi">
                        <i class="fab fa-whatsapp"></i> Konfirmasi & Kirim via WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section class="donasi-section-wrapper">
        <div class="donasi-content-area">
            <div class="donasi-info-card donasi-kontak-card">
                <h2><i class="fas fa-headset"></i>Butuh Bantuan atau Informasi?</h2>
                <p>Jangan ragu untuk menghubungi kami jika ada pertanyaan atau Anda ingin berdiskusi lebih lanjut mengenai program donasi:</p>
                <ul>
                    @if(isset($identitasPanti) && $identitasPanti->telepon)
                    <li><i class="fas fa-phone-alt"></i><span>Telepon/WhatsApp: <a href="https://wa.me/{{ $nomorWaPanti ?? '' }}" target="_blank" rel="noopener noreferrer">{{ $identitasPanti->telepon }}</a></span></li>
                    @endif
                    @if(isset($identitasPanti) && $identitasPanti->email)
                    <li><i class="fas fa-envelope"></i><span>Email: <a href="mailto:{{ $identitasPanti->email }}">{{ $identitasPanti->email }}</a></span></li>
                    @endif
                    @if(isset($identitasPanti) && $identitasPanti->alamat_lengkap)
                    <li><i class="fas fa-map-marker-alt"></i><span>Alamat: {{ $identitasPanti->alamat_lengkap }}</span></li>
                    @endif
                    @if( (empty($identitasPanti->telepon)) && (empty($identitasPanti->email)) && (empty($identitasPanti->alamat_lengkap)) )
                        <li><i class="fas fa-info-circle"></i><span>Informasi kontak panti saat ini belum tersedia.</span></li>
                    @endif
                </ul>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
{{-- Pastikan Font Awesome sudah ada di layout utama --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script untuk validasi sederhana atau interaksi form bisa ditambahkan di sini jika perlu.
        const formDonasi = document.getElementById('formDonasiWA');
        if(formDonasi) {
            formDonasi.addEventListener('submit', function(event) {
                const teleponInput = document.getElementById('telepon_donatur');
                if (teleponInput) {
                    const teleponValue = teleponInput.value.replace(/[\s-()+]/g, ''); // Bersihkan nomor telepon
                    // Validasi nomor Indonesia (mulai 08, total 10-14 digit)
                    if (!/^(08)\d{8,12}$/.test(teleponValue)) {
                        alert('Mohon masukkan nomor WhatsApp yang valid (diawali 08 dan terdiri dari 10-14 digit angka).');
                        event.preventDefault();
                        teleponInput.focus();
                        return false;
                    }
                }
            });
        }
    });
</script>
@endpush