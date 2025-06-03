@extends('layouts.user')

@section('title', $kebutuhan->nama_kebutuhan . ' - ' . ($identitasPanti->nama_panti ?? 'Rumah Harapan'))

@push('styles')
<style>
    :root {
        --color-bg-detail-kebutuhan: #f8fafc; /* Latar belakang terang */
        --color-bg-white-kebutuhan: #ffffff;
        --color-primary-detail: #007bff; /* Biru primer */
        --color-accent-detail: #ffc107;   /* Kuning aksen */
        --color-text-header-detail: #212529;
        --color-text-body-detail: #343a40;
        --color-text-muted-detail: #6c757d;
        --color-border-detail: #dee2e6;
        --font-family-detail: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; /* Font yang clear */
        --shadow-soft-detail: 0 3px 10px rgba(0, 0, 0, 0.06);
        --shadow-medium-detail: 0 6px 15px rgba(0, 0, 0, 0.08);
        --border-radius-detail: 0.625rem; /* 10px */
    }

    body {
        font-family: var(--font-family-detail);
        background-color: var(--color-bg-white-kebutuhan);
        color: var(--color-text-body-detail);
        line-height: 1.75;
        margin: 0;
    }

    .kebutuhan-detail-page-wrapper {
        padding-top: 70px; /* Jarak dari navbar jika fixed-top */
        padding-bottom: 4rem;
    }

    .kebutuhan-detail-main-container {
        max-width: 800px; /* Kontainer utama lebih sempit untuk fokus */
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* HEADER KEBUTUHAN */
    .kebutuhan-detail-header {
        text-align: center;
        margin-bottom: 2.5rem;
        padding: 2rem 0;
        border-bottom: 1px solid var(--color-border-detail);
    }
    .kebutuhan-detail-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--color-text-header-detail);
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }
    .kebutuhan-header-meta-info {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem 1.5rem; /* Jarak antar item meta */
        font-size: 0.9rem;
        color: var(--color-text-muted-detail);
    }
    .meta-info-item {
        display: flex;
        align-items: center;
    }
    .meta-info-item i {
        margin-right: 0.5rem;
        color: var(--color-primary-detail); /* Ikon biru */
    }
    .meta-info-item strong {
        color: var(--color-text-body-detail);
        font-weight: 500;
    }

    /* GAMBAR UTAMA */
    .kebutuhan-main-image-wrapper {
        margin-bottom: 2.5rem;
        border-radius: var(--border-radius-detail);
        overflow: hidden;
        box-shadow: var(--shadow-medium-detail);
        background-color: #e9ecef; /* Placeholder background */
        min-height: 250px; /* Tinggi minimum jika tidak ada gambar */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .kebutuhan-main-image {
        width: 100%;
        height: auto;
        max-height: 500px; /* Batasi tinggi gambar */
        object-fit: cover; /* Atau 'contain' jika tidak ingin cropping */
        display: block;
    }
    .kebutuhan-image-placeholder-text {
        color: var(--color-text-muted-detail);
        font-style: italic;
    }

    /* INFORMASI DANA (Jika ada) */
    .kebutuhan-dana-summary {
        background-color: var(--color-bg-detail-kebutuhan);
        padding: 1.75rem;
        border-radius: var(--border-radius-detail);
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft-detail);
        text-align: center;
    }
    .dana-summary-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around; /* Sebar merata */
        gap: 1.5rem;
    }
    .dana-summary-item {
        flex-basis: 200px; /* Lebar dasar item */
        text-align: center;
    }
    .dana-summary-value {
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--color-primary-detail);
        display: block;
        margin-bottom: 0.25rem;
    }
    .dana-summary-label {
        font-size: 0.9rem;
        color: var(--color-text-muted-detail);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .dana-not-applicable { /* Jika bukan donasi dana */
        font-style: italic;
        color: var(--color-text-muted-detail);
    }

    /* DESKRIPSI KEBUTUHAN */
    .kebutuhan-description-content {
        background-color: var(--color-bg-white-kebutuhan);
        padding: 2rem;
        border-radius: var(--border-radius-detail);
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-soft-detail);
    }
    .kebutuhan-description-content .content-section-heading { /* Judul section kecil */
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--color-text-header-detail);
        margin-bottom: 1.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--color-primary-detail);
        display: inline-block;
    }
    .description-prose { /* Styling untuk konten dari editor WYSIWYG */
        font-size: 1.05rem;
        color: var(--color-text-body-detail);
    }
    .description-prose p { margin-bottom: 1.25rem; }
    .description-prose strong { font-weight: 600; color: var(--color-text-header-detail); }
    .description-prose ul, .description-prose ol { padding-left: 1.5rem; margin-bottom: 1.25rem; }
    .description-prose li { margin-bottom: 0.5rem; }

    /* TOMBOL AKSI (CTA) */
    .kebutuhan-cta-section {
        text-align: center;
        margin-bottom: 3rem;
    }
    .btn-donate-detail-page { /* Tombol donasi utama */
        background: linear-gradient(135deg, var(--color-accent-detail), #ffb300); /* Gradasi kuning */
        color: var(--color-text-header-detail);
        padding: 0.9rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        border-radius: 50px; /* Tombol sangat bulat */
        display: inline-flex; /* Untuk ikon */
        align-items: center;
        transition: all 0.25s ease;
        box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
    }
    .btn-donate-detail-page:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 15px rgba(255, 193, 7, 0.4);
        color: var(--color-text-header-detail); /* Pastikan warna teks tetap saat hover */
    }
    .btn-donate-detail-page i {
        margin-right: 0.75rem;
        font-size: 1.2em;
    }

    /* KEBUTUHAN LAINNYA */
    .kebutuhan-related-section {
        padding-top: 2rem;
        border-top: 1px solid var(--color-border-detail);
    }
    .kebutuhan-related-title { /* Judul "Kebutuhan Lainnya" */
        text-align: center;
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--color-text-header-detail);
        margin-bottom: 2rem;
    }
    .related-items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.75rem;
    }
    .related-item-card {
        background-color: var(--color-bg-white-kebutuhan);
        border-radius: var(--border-radius-detail);
        box-shadow: var(--shadow-soft-detail);
        overflow: hidden; /* Untuk gambar */
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .related-item-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-medium-detail);
    }
    .related-item-image-link {
        display: block;
        height: 180px; /* Tinggi gambar tetap */
        background-color: #f0f0f0; /* Placeholder */
    }
    .related-item-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .related-item-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        font-size: 0.9rem;
        color: var(--color-text-muted-detail);
    }
    .related-item-content {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .related-item-title {
        font-size: 1.15rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }
    .related-item-title a {
        color: var(--color-text-header-detail);
        text-decoration: none;
    }
    .related-item-title a:hover {
        color: var(--color-primary-detail);
    }
    .related-item-meta-info {
        font-size: 0.85rem;
        color: var(--color-text-muted-detail);
        margin-bottom: 1rem;
        flex-grow: 1; /* Agar tombol tetap di bawah */
    }
    .btn-related-detail { /* Tombol untuk item terkait */
        background-color: var(--color-bg-detail-kebutuhan);
        color: var(--color-primary-detail);
        border: 1px solid var(--color-primary-detail);
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: var(--border-radius-kebutuhan);
        text-decoration: none;
        text-align: center;
        display: block; /* Full width di card */
        margin-top: auto; /* Dorong ke bawah */
        transition: background-color 0.2s, color 0.2s;
    }
    .btn-related-detail:hover {
        background-color: var(--color-primary-detail);
        color: white;
    }

    /* Animasi loading awal (opsional) */
    .kebutuhan-detail-container.initial-loading {
        opacity: 0;
        transform: translateY(15px);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    }
    .kebutuhan-detail-container.loaded {
        opacity: 1;
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .kebutuhan-detail-page-wrapper { padding-top: 60px; }
        .kebutuhan-detail-main-container { padding: 0 1rem; }
        .kebutuhan-detail-title { font-size: 2rem; }
        .kebutuhan-header-meta-info { flex-direction: column; align-items: center; gap: 0.25rem; }
        .dana-summary-grid { flex-direction: column; gap: 1rem; }
        .dana-summary-item { flex-basis: auto; }
        .kebutuhan-description-content { padding: 1.5rem; }
        .related-items-grid { grid-template-columns: 1fr; } /* Satu kolom di mobile */
    }

</style>
@endpush

@section('content')
<div class="kebutuhan-detail-page-wrapper">
    <div class="kebutuhan-detail-main-container initial-loading"> {{-- Class untuk animasi loading --}}

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
                    <span>Target Pengumpulan hingga: <strong>{{ $kebutuhan->tanggal_target_tercapai->isoFormat('D MMMM YYYY') }}</strong></span>
                </div>
                @endif
                @if($kebutuhan->sisa_hari !== null && $kebutuhan->sisa_hari >= 0)
                <div class="meta-info-item">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Sisa Waktu: <strong>{{ $kebutuhan->sisa_hari }} hari</strong></span>
                </div>
                @elseif($kebutuhan->sisa_hari !== null && $kebutuhan->sisa_hari < 0)
                <div class="meta-info-item">
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
                 loading="lazy">
            @else
            <span class="kebutuhan-image-placeholder-text">Gambar untuk kebutuhan ini belum tersedia.</span>
            @endif
        </section>

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
                    <span class="dana-summary-value">{{ number_format($kebutuhan->persentase_terkumpul, 0) }}%</span>
                    <span class="dana-summary-label">Dari Target</span>
                </div>
            </div>
        </section>
        @else
        <section class="kebutuhan-dana-summary">
             <p class="dana-not-applicable">Ini adalah kebutuhan berbentuk barang atau dukungan non-finansial.</p>
        </section>
        @endif

        <!-- Deskripsi Kebutuhan -->
        <section class="kebutuhan-description-content">
            <h2 class="content-section-heading">Detail Kebutuhan</h2>
            <div class="description-prose">
                {!! $kebutuhan->deskripsi !!} {{-- Asumsi deskripsi dari WYSIWYG dan sudah di-sanitize --}}
            </div>
        </section>

        <!-- Tombol Aksi (CTA) -->
        <section class="kebutuhan-cta-section">
            <a href="{{ route('public.donasi.index', ['kebutuhan_id' => $kebutuhan->id, 'nama_kebutuhan' => $kebutuhan->nama_kebutuhan]) }}"
               class="btn-donate-detail-page">
                <i class="fas fa-donate"></i> Dukung Kebutuhan Ini
            </a>
        </section>

        <!-- Kebutuhan Lainnya -->
        @if(isset($kebutuhanLainnya) && $kebutuhanLainnya->isNotEmpty())
        <section class="kebutuhan-related-section">
            <h2 class="kebutuhan-related-title">Lihat Kebutuhan Mendesak Lainnya</h2>
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
                            <span>Gambar Tidak Tersedia</span>
                        </div>
                        @endif
                    </a>
                    <div class="related-item-content">
                        <h3 class="related-item-title">
                            <a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}">
                                {{ Str::limit($itemLain->nama_kebutuhan, 50) }}
                            </a>
                        </h3>
                        @if($itemLain->target_dana > 0)
                        <p class="related-item-meta-info">
                            Target: Rp {{ number_format($itemLain->target_dana, 0, ',', '.') }}
                        </p>
                        @else
                        <p class="related-item-meta-info">Kebutuhan barang/non-finansial.</p>
                        @endif
                        <a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}" class="btn-related-detail">
                            Lihat Detail Kebutuhan
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
    // Efek loading awal untuk kontainer utama
    const detailContainer = document.querySelector('.kebutuhan-detail-main-container');
    if (detailContainer) {
        // Hapus kelas initial-loading setelah delay singkat untuk memicu transisi
        setTimeout(() => {
            detailContainer.classList.add('loaded');
            detailContainer.classList.remove('initial-loading');
        }, 100); // delay 100ms
    }

    // Smooth scroll untuk anchor links (jika ada di halaman ini)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetEl = document.querySelector(this.getAttribute('href'));
            if (targetEl) {
                targetEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start' // atau 'center'
                });
            }
        });
    });

    // Lazy loading untuk gambar tambahan (jika ada gambar yg tidak menggunakan loading="lazy" native)
    // Jika semua gambar sudah pakai loading="lazy", script ini bisa opsional.
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) { // Jika menggunakan data-src untuk lazy load manual
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src'); // Hapus atribut setelah dimuat
                        observer.unobserve(img);
                    }
                }
            });
        }, { rootMargin: "0px 0px 100px 0px" }); // Mulai load gambar 100px sebelum masuk viewport

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
});
</script>
@endpush