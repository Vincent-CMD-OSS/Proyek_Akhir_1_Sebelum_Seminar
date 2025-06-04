@extends('layouts.user')

@section('title', $kebutuhan->nama_kebutuhan . ' - ' . ($identitasPanti->nama_panti ?? 'Rumah Harapan'))

@push('styles')
<style>
    :root {
        --color-primary-detail: #005A9C; /* Biru korporat yang lebih dalam */
        --color-secondary-detail: #F5A623; /* Oranye sebagai aksen hangat */
        --color-bg-page-detail: #f4f7f6; /* Background halaman yang sangat netral (off-white/abu muda) */
        --color-bg-content-detail: #ffffff;
        --color-text-header-detail: #1a2533; /* Abu-abu sangat gelap, hampir hitam */
        --color-text-body-detail: #4a5568;  /* Abu-abu lebih lembut untuk body */
        --color-text-muted-detail: #718096; /* Abu-abu untuk teks muted */
        --color-border-soft-detail: #e2e8f0; /* Border yang halus */
        --color-border-medium-detail: #cbd5e0;
        --font-family-detail: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Arial, sans-serif; /* Font sans-serif standar yang clear */
        --shadow-card-detail: 0 4px 12px rgba(0, 0, 0, 0.08); /* Shadow untuk card */
        --shadow-subtle-detail: 0 2px 6px rgba(0, 0, 0, 0.05);
        --border-radius-card-detail: 0.75rem; /* 12px */
        --border-radius-button-detail: 0.5rem; /* 8px */
    }

    body {
        font-family: var(--font-family-detail);
        background-color: var(--color-bg-page-detail); /* Background halaman utama */
        color: var(--color-text-body-detail);
        line-height: 1.7;
        margin: 0;
    }

    .kebutuhan-detail-page-wrapper {
        padding-top: 2.5rem; /* Jarak atas */
        padding-bottom: 4rem;
    }

    .kebutuhan-detail-main-container {
        max-width: 850px; /* Kontainer sedikit lebih lebar */
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* Box utama untuk konten detail */
    .kebutuhan-detail-content-box {
        background-color: var(--color-bg-content-detail);
        border-radius: var(--border-radius-card-detail);
        box-shadow: var(--shadow-card-detail);
        overflow: hidden; /* Untuk border radius pada gambar jika gambar di paling atas */
        margin-bottom: 2.5rem;
    }

    /* HEADER KEBUTUHAN (di dalam content box) */
    .kebutuhan-detail-header {
        padding: 2rem 2rem 1.5rem; /* Padding disesuaikan */
        text-align: left; /* Rata kiri untuk header */
        border-bottom: 1px solid var(--color-border-soft-detail);
    }
    .kebutuhan-detail-title {
        font-size: 2.2rem; /* Disesuaikan */
        font-weight: 700;
        color: var(--color-text-header-detail);
        margin-bottom: 1rem; /* Jarak lebih ke meta info */
        line-height: 1.3;
    }
    .kebutuhan-header-meta-info {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start; /* Rata kiri */
        gap: 0.75rem 2rem; /* Jarak antar item meta */
        font-size: 0.9rem;
        color: var(--color-text-muted-detail);
    }
    .meta-info-item {
        display: flex;
        align-items: center;
    }
    .meta-info-item i {
        margin-right: 0.6rem;
        color: var(--color-primary-detail);
        font-size: 1.1em; /* Ikon sedikit lebih besar */
    }
    .meta-info-item strong {
        color: var(--color-text-body-detail);
        font-weight: 500;
    }

    /* GAMBAR UTAMA (di dalam content box) */
    .kebutuhan-main-image-wrapper {
        /* margin-bottom: 0; Dihapus jika gambar bagian dari content box */
        background-color: #f0f3f5; /* Placeholder background lebih netral */
        min-height: 300px;
        max-height: 550px; /* Batasi tinggi gambar agar tidak terlalu dominan */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden; /* Jika gambar lebih besar dari wrapper */
    }
    .kebutuhan-main-image {
        width: 100%;
        height: 100%; /* Fill wrapper height jika aspect ratio berbeda */
        object-fit: cover; /* Atau 'contain' */
        display: block;
    }
    .kebutuhan-image-placeholder-text {
        color: var(--color-text-muted-detail);
        font-style: italic;
        padding: 2rem;
        text-align: center;
    }

    /* KONTEN SETELAH GAMBAR (di dalam content box) */
    .kebutuhan-detail-body-content {
        padding: 2rem;
    }

    /* INFORMASI DANA */
    .kebutuhan-dana-summary {
        background-color: var(--color-bg-page-detail); /* Background sedikit beda untuk kontras */
        padding: 1.5rem; /* Padding dikurangi */
        border-radius: var(--border-radius-button-detail); /* Radius lebih kecil */
        margin-bottom: 2rem;
        border: 1px solid var(--color-border-soft-detail);
    }
    .dana-summary-grid {
        display: grid; /* Menggunakan grid untuk alignment yg lebih baik */
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Kolom responsif */
        gap: 1.5rem;
        text-align: center;
    }
    .dana-summary-item {
        /* flex-basis dihapus karena sudah pakai grid */
    }
    .dana-summary-value {
        font-size: 1.8rem; /* Lebih menonjol */
        font-weight: 700; /* Bold */
        color: var(--color-primary-detail);
        display: block;
        margin-bottom: 0.3rem;
    }
    .dana-summary-label {
        font-size: 0.85rem; /* Lebih kecil */
        color: var(--color-text-muted-detail);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .dana-not-applicable {
        font-style: italic;
        color: var(--color-text-muted-detail);
        padding: 1rem 0; /* Padding jika hanya teks ini */
        text-align: center;
    }

    /* DESKRIPSI KEBUTUHAN */
    .kebutuhan-description-content {
        /* Background dan shadow dihapus karena sudah di .kebutuhan-detail-content-box */
        /* padding: 0; Dihapus, padding sudah di .kebutuhan-detail-body-content */
        margin-bottom: 2rem;
    }
    .kebutuhan-description-content .content-section-heading {
        font-size: 1.4rem; /* Disesuaikan */
        font-weight: 600;
        color: var(--color-text-header-detail);
        margin-bottom: 1.25rem;
        padding-bottom: 0.6rem;
        border-bottom: 2px solid var(--color-primary-detail);
        display: inline-block;
    }
    .description-prose {
        font-size: 1rem; /* Ukuran font body standar */
        color: var(--color-text-body-detail);
    }
    .description-prose p { margin-bottom: 1.25rem; line-height: 1.75; }
    .description-prose strong { font-weight: 600; color: var(--color-text-header-detail); }
    .description-prose ul, .description-prose ol { padding-left: 1.75rem; margin-bottom: 1.25rem; }
    .description-prose li { margin-bottom: 0.6rem; }
    .description-prose a { color: var(--color-primary-detail); text-decoration: none; }
    .description-prose a:hover { text-decoration: underline; }


    /* TOMBOL AKSI (CTA) */
    .kebutuhan-cta-section {
        text-align: center;
        padding: 1rem 0 0; /* Padding atas, tanpa margin bawah */
    }
    .btn-donate-detail-page {
        background: var(--color-secondary-detail); /* Warna aksen oranye */
        color: #ffffff; /* Teks putih agar kontras dengan oranye */
        padding: 0.9rem 2.8rem; /* Padding disesuaikan */
        font-size: 1.05rem; /* Sedikit lebih kecil */
        font-weight: 600;
        text-decoration: none;
        border-radius: var(--border-radius-button-detail); /* Radius konsisten */
        display: inline-flex;
        align-items: center;
        border: none; /* Tanpa border */
        transition: background-color 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease;
        box-shadow: 0 4px 10px rgba(0,0,0, 0.1); /* Shadow netral */
    }
    .btn-donate-detail-page:hover {
        background-color: #e09114; /* Oranye lebih gelap */
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0, 0.15);
        color: #ffffff;
    }
    .btn-donate-detail-page i {
        margin-right: 0.75rem;
        font-size: 1.1em;
    }

    /* KEBUTUHAN LAINNYA (di luar content box utama) */
    .kebutuhan-related-section {
        padding-top: 3rem;
        margin-top: 2rem; /* Jarak dari box konten utama */
        /* border-top: 1px solid var(--color-border-medium-detail); Dihapus, pemisahan visual dari margin */
    }
    .kebutuhan-related-title {
        text-align: center;
        font-size: 1.7rem; /* Disesuaikan */
        font-weight: 600;
        color: var(--color-text-header-detail);
        margin-bottom: 2.5rem;
    }
    .related-items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); /* Ukuran card disesuaikan */
        gap: 2rem; /* Jarak antar card */
    }
    .related-item-card {
        background-color: var(--color-bg-content-detail);
        border-radius: var(--border-radius-card-detail);
        box-shadow: var(--shadow-card-detail);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .related-item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .related-item-image-link {
        display: block;
        height: 170px; /* Tinggi gambar disesuaikan */
        background-color: #f0f3f5;
    }
    .related-item-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .related-item-image-placeholder {
        display: flex;
        flex-direction: column; /* Ikon dan teks vertikal */
        align-items: center;
        justify-content: center;
        height: 100%;
        font-size: 0.85rem;
        color: var(--color-text-muted-detail);
        text-align: center;
        padding: 1rem;
    }
     .related-item-image-placeholder i { /* Styling ikon placeholder */
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    .related-item-content {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .related-item-title {
        font-size: 1.1rem; /* Disesuaikan */
        font-weight: 600;
        margin: 0 0 0.6rem 0;
    }
    .related-item-title a {
        color: var(--color-text-header-detail);
        text-decoration: none;
    }
    .related-item-title a:hover {
        color: var(--color-primary-detail);
    }
    .related-item-meta-info {
        font-size: 0.8rem;
        color: var(--color-text-muted-detail);
        margin-bottom: 1rem;
        flex-grow: 1;
    }
    .btn-related-detail {
        background-color: transparent; /* Tombol outline */
        color: var(--color-primary-detail);
        border: 2px solid var(--color-primary-detail); /* Border lebih tebal */
        padding: 0.6rem 1rem; /* Padding disesuaikan */
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: var(--border-radius-button-detail);
        text-decoration: none;
        text-align: center;
        display: block;
        margin-top: auto;
        transition: background-color 0.2s, color 0.2s;
    }
    .btn-related-detail:hover {
        background-color: var(--color-primary-detail);
        color: white;
    }

    /* Animasi loading awal (sama seperti sebelumnya) */
    .kebutuhan-detail-main-container.initial-loading {
        opacity: 0;
        transform: translateY(15px);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    }
    .kebutuhan-detail-main-container.loaded {
        opacity: 1;
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .kebutuhan-detail-page-wrapper { padding-top: 1.5rem; }
        .kebutuhan-detail-main-container { padding: 0 1rem; }
        .kebutuhan-detail-title { font-size: 1.8rem; }
        .kebutuhan-header-meta-info { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        .dana-summary-grid { grid-template-columns: 1fr; gap: 1rem; } /* Satu kolom untuk dana summary */
        .kebutuhan-description-content .content-section-heading { font-size: 1.25rem; }
        .related-items-grid { grid-template-columns: 1fr; }
        .kebutuhan-detail-header, .kebutuhan-detail-body-content { padding: 1.5rem; }
    }
    @media (max-width: 576px) {
         .kebutuhan-main-image-wrapper { min-height: 200px; }
         .kebutuhan-detail-title { font-size: 1.6rem; }
         .related-item-card { margin-bottom: 1.5rem; } /* Jarak antar card terkait di mobile */
         .btn-donate-detail-page { padding: 0.8rem 2rem; font-size: 1rem; }
    }

</style>
@endpush

@section('content')
<div class="kebutuhan-detail-page-wrapper">
    <div class="kebutuhan-detail-main-container initial-loading"> {{-- Class untuk animasi loading --}}

        <div class="kebutuhan-detail-content-box">
            <!-- Header Section -->
            <header class="kebutuhan-detail-header">
                <h1 class="kebutuhan-detail-title">{{ $kebutuhan->nama_kebutuhan }}</h1>
                <div class="kebutuhan-header-meta-info">
                    @if($kebutuhan->tanggal_mulai_dipublikasikan)
                    <div class="meta-info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Dipublikasikan: <strong>{{ $kebutuhan->tanggal_mulai_dipublikasikan->isoFormat('D MMMM YYYY') }}</strong></span>
                    </div>
                    @endif

                    @if($kebutuhan->tanggal_target_tercapai)
                    <div class="meta-info-item">
                        <i class="fas fa-flag-checkered"></i>
                        <span>Batas Pengumpulan: <strong>{{ $kebutuhan->tanggal_target_tercapai->isoFormat('D MMMM YYYY') }}</strong></span>
                    </div>
                    @endif
                    @if($kebutuhan->sisa_hari !== null && $kebutuhan->sisa_hari >= 0)
                    <div class="meta-info-item">
                        <i class="fas fa-hourglass-half"></i>
                        <span>Sisa Waktu: <strong>{{ $kebutuhan->sisa_hari == 0 ? 'Hari terakhir!' : $kebutuhan->sisa_hari . ' hari' }}</strong></span>
                    </div>
                    @elseif($kebutuhan->sisa_hari !== null && $kebutuhan->sisa_hari < 0)
                    <div class="meta-info-item text-danger">
                        <i class="fas fa-times-circle"></i>
                        <span>Periode Pengumpulan Telah Berakhir</span>
                    </div>
                    @endif
                </div>
            </header>

            <!-- Gambar Utama -->
            <section class="kebutuhan-main-image-wrapper">
                @if($kebutuhan->gambar_kebutuhan)
                <img src="{{ Storage::url($kebutuhan->gambar_kebutuhan) }}"
                     alt="Gambar {{ $kebutuhan->nama_kebutuhan }}"
                     class="kebutuhan-main-image"
                     loading="eager"> {{-- Gambar utama eager load --}}
                @else
                <span class="kebutuhan-image-placeholder-text">Gambar representatif untuk kebutuhan ini belum tersedia.</span>
                @endif
            </section>

            <!-- Konten Body (Informasi Dana, Deskripsi, CTA) -->
            <div class="kebutuhan-detail-body-content">
                <!-- Informasi Dana (Jika ada target dana) -->
                @if($kebutuhan->target_dana > 0)
                <section class="kebutuhan-dana-summary">
                    <div class="dana-summary-grid">
                        <div class="dana-summary-item">
                            <span class="dana-summary-value">Rp {{ number_format($kebutuhan->dana_terkumpul, 0, ',', '.') }}</span>
                            <span class="dana-summary-label">Dana Terkumpul</span>
                        </div>
                        <div class="dana-summary-item">
                            <span class="dana-summary-value">Rp {{ number_format($kebutuhan->target_dana, 0, ',', '.') }}</span>
                            <span class="dana-summary-label">Target Donasi</span>
                        </div>
                        <div class="dana-summary-item">
                            <span class="dana-summary-value">{{ number_format($kebutuhan->persentase_terkumpul, 1) }}%</span> {{-- 1 angka desimal --}}
                            <span class="dana-summary-label">Dari Target</span>
                        </div>
                    </div>
                </section>
                @else
                <section class="kebutuhan-dana-summary">
                     <p class="dana-not-applicable">Ini adalah kebutuhan yang berbentuk barang atau dukungan non-finansial.</p>
                </section>
                @endif

                <!-- Deskripsi Kebutuhan -->
                <section class="kebutuhan-description-content">
                    <h2 class="content-section-heading">Rincian Kebutuhan</h2>
                    <div class="description-prose">
                        {!! $kebutuhan->deskripsi !!}
                    </div>
                </section>

                <!-- Tombol Aksi (CTA) -->
                <section class="kebutuhan-cta-section">
                    <a href="{{ route('public.donasi.index', ['kebutuhan_id' => $kebutuhan->id, 'nama_kebutuhan' => $kebutuhan->nama_kebutuhan]) }}"
                       class="btn-donate-detail-page">
                        <i class="fas fa-hand-holding-heart"></i> Salurkan Dukungan Anda
                    </a>
                </section>
            </div>
        </div>


        <!-- Kebutuhan Lainnya -->
        @if(isset($kebutuhanLainnya) && $kebutuhanLainnya->isNotEmpty())
        <section class="kebutuhan-related-section">
            <h2 class="kebutuhan-related-title">Kebutuhan Lain yang Mendesak</h2>
            <div class="related-items-grid">
                @foreach($kebutuhanLainnya as $itemLain)
                <article class="related-item-card">
                    <a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}" class="related-item-image-link">
                        @if($itemLain->gambar_kebutuhan)
                        <img src="{{ Storage::url($itemLain->gambar_kebutuhan) }}"
                             alt="{{ $itemLain->nama_kebutuhan }}"
                             class="related-item-image"
                             loading="lazy">
                        @else
                        <div class="related-item-image-placeholder">
                            <i class="fas fa-box-open"></i>
                            <span>Gambar Belum Tersedia</span>
                        </div>
                        @endif
                    </a>
                    <div class="related-item-content">
                        <h3 class="related-item-title">
                            <a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}">
                                {{ Str::limit($itemLain->nama_kebutuhan, 55) }}
                            </a>
                        </h3>
                        @if($itemLain->target_dana > 0)
                        <p class="related-item-meta-info">
                            Target: Rp {{ number_format($itemLain->target_dana, 0, ',', '.') }}
                        </p>
                        @else
                        <p class="related-item-meta-info">Kebutuhan barang/jasa.</p>
                        @endif
                        <a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}" class="btn-related-detail">
                           <i class="fas fa-search-plus me-1"></i> Lihat Detail
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailContainer = document.querySelector('.kebutuhan-detail-main-container');
    if (detailContainer) {
        setTimeout(() => {
            detailContainer.classList.add('loaded');
            detailContainer.classList.remove('initial-loading');
        }, 50); // kurangi delay agar lebih cepat
    }

    // Smooth scroll untuk anchor (jika ada)
    // ... (script smooth scroll bisa tetap ada jika diperlukan di masa depan) ...
});
</script>
@endpush