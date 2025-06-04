@extends('layouts.user') {{-- Sesuaikan dengan layout publik utama Anda --}}

@section('title', 'Kebutuhan Panti - ' . ($identitasPanti->nama_panti ?? 'Rumah Harapan'))

@push('styles')
<style>
    :root {
        --color-primary-kebutuhan: #0d6efd; /* Biru Bootstrap Default */
        --color-secondary-kebutuhan: #6c757d; /* Abu-abu Bootstrap untuk aksen sekunder */
        --color-bg-hero-kebutuhan: #e7f1ff; /* Biru sangat lembut (lebih terang dari #e3f2fd) */
        --color-bg-main-kebutuhan: #ffffff;
        --color-bg-item-hover: #f8f9fa;
        --color-text-header-kebutuhan: #212529; /* Hitam Bootstrap */
        --color-text-body-kebutuhan: #495057;
        --color-text-muted-kebutuhan: #6c757d;
        --color-border-kebutuhan: #dee2e6; /* Border Bootstrap Default */
        --font-family-kebutuhan: 'Nunito Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; /* Font yang lebih bulat dan modern */
        --shadow-soft-kebutuhan: 0 5px 20px rgba(0, 0, 0, 0.05); /* Shadow lebih halus */
        --shadow-medium-kebutuhan: 0 8px 25px rgba(0, 0, 0, 0.07);
        --border-radius-kebutuhan: 0.5rem; /* 8px */
        --border-radius-sm-kebutuhan: 0.3rem; /* Lebih kecil */
    }

    body {
        font-family: var(--font-family-kebutuhan);
        background-color: var(--color-bg-main-kebutuhan);
        color: var(--color-text-body-kebutuhan);
        line-height: 1.7;
        margin: 0;
    }

    /* HERO SECTION - REVISI */
    .kebutuhan-hero-section {
        height: 100vh; /* Tinggi 100vh */
        display: flex;
        align-items: center;
        justify-content: center;
        /* Menggunakan background gradasi lembut dari warna hero ke putih */
        background: linear-gradient(160deg, var(--color-bg-hero-kebutuhan) 30%, rgba(255,255,255,0.8) 100%),
                    url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'); /* GANTI URL GAMBAR INI */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 3rem 1.5rem;
        text-align: center;
        position: relative;
        color: var(--color-text-header-kebutuhan);
    }

    /* Tidak perlu ::before jika gradasi sudah cukup melembutkan */

    .kebutuhan-hero-content {
        max-width: 750px; /* Konten lebih lebar sedikit */
        position: relative;
        z-index: 2; /* Pastikan di atas background */
    }

    .kebutuhan-hero-tagline {
        display: inline-block;
        background-color: rgba(13, 110, 253, 0.1); /* Warna biru primer transparan */
        color: var(--color-primary-kebutuhan);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        letter-spacing: 0.5px;
    }

    .kebutuhan-hero-title {
        font-size: 3.2rem;
        font-weight: 800; /* Lebih tebal */
        color: var(--color-text-header-kebutuhan);
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .kebutuhan-hero-subtitle {
        font-size: 1.15rem;
        color: var(--color-text-body-kebutuhan); /* Lebih jelas dari muted */
        margin-bottom: 0; /* Dihapus margin bawah karena tidak ada tombol CTA */
        max-width: 650px;
        margin-left: auto;
        margin-right: auto;
    }

    .kebutuhan-hero-scroll-indicator { /* Indikator scroll down */
        position: absolute;
        bottom: 40px; /* Posisi dari bawah */
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        color: var(--color-primary-kebutuhan);
        cursor: pointer;
        animation: bounceKebutuhan 2.5s infinite; /* Animasi bounce lebih lambat */
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
    }
    .kebutuhan-hero-scroll-indicator i {
        font-size: 1.8rem; /* Ukuran ikon */
    }
    .kebutuhan-hero-scroll-indicator span {
        font-size: 0.8rem;
        font-weight: 500;
        margin-top: 0.3rem;
        letter-spacing: 0.5px;
        opacity: 0.8;
    }

    @keyframes bounceKebutuhan { /* Nama animasi unik */
        0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
        40% { transform: translateX(-50%) translateY(-12px); }
        60% { transform: translateX(-50%) translateY(-6px); }
    }


    /* MAIN CONTENT SECTION */
    .kebutuhan-main-content {
        padding: 4rem 1.5rem;
        background-color: var(--color-bg-main-kebutuhan);
    }
    .kebutuhan-container-public {
        max-width: 900px;
        margin: 0 auto;
    }

    .section-title-kebutuhan {
        text-align: center;
        font-size: 2.2rem;
        font-weight: 700; /* Lebih bold */
        color: var(--color-text-header-kebutuhan);
        margin-bottom: 1rem;
    }
    .section-subtitle-kebutuhan {
        text-align: center;
        font-size: 1.05rem;
        color: var(--color-text-muted-kebutuhan);
        margin-bottom: 3.5rem; /* Jarak lebih ke daftar */
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    /* KEBUTUHAN ITEM LISTING (Sama seperti sebelumnya, sudah bagus) */
    .kebutuhan-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    .kebutuhan-list-item {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--color-border-kebutuhan);
        border-radius: var(--border-radius-kebutuhan);
        background-color: var(--color-bg-main-kebutuhan);
        box-shadow: var(--shadow-soft-kebutuhan);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
    }
    .kebutuhan-list-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium-kebutuhan);
    }
    .kebutuhan-list-item.is-visible {
        opacity: 1;
        transform: translateY(0);
        transition-property: opacity, transform;
        transition-duration: 0.5s;
        transition-timing-function: ease-out;
    }

    .kebutuhan-item-image-link {
        display: block;
        width: 100%;
        height: 230px;
        border-radius: var(--border-radius-sm-kebutuhan);
        overflow: hidden;
        background-color: #e9ecef;
        flex-shrink: 0;
    }
    .kebutuhan-item-image-link img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .kebutuhan-item-image-link:hover img {
        transform: scale(1.08);
    }
    .kebutuhan-item-placeholder {
        display: flex;
        flex-direction: column; /* Agar ikon dan teks bisa vertikal */
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 100%;
        font-size: 0.9rem;
        color: var(--color-text-muted-kebutuhan);
    }
    .kebutuhan-item-placeholder i { /* Styling untuk ikon placeholder */
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        opacity: 0.6;
    }


    .kebutuhan-item-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .kebutuhan-item-content h3 {
        margin: 0 0 0.75rem 0;
        font-size: 1.4rem;
        font-weight: 600;
    }
    .kebutuhan-item-content h3 a {
        color: var(--color-text-header-kebutuhan);
        text-decoration: none;
        transition: color 0.2s;
    }
    .kebutuhan-item-content h3 a:hover {
        color: var(--color-primary-kebutuhan);
    }
    .kebutuhan-item-deskripsi {
        font-size: 0.9rem;
        color: var(--color-text-body-kebutuhan);
        margin-bottom: 1rem;
        flex-grow: 1;
        line-height: 1.65;
    }
    .kebutuhan-item-dana-info {
        font-size: 0.85rem;
        color: var(--color-text-muted-kebutuhan);
        margin-bottom: 1.25rem;
        padding: 0.8rem 1rem;
        background-color: var(--color-bg-hero-kebutuhan); /* Warna bg hero untuk konsistensi */
        border-radius: var(--border-radius-sm-kebutuhan);
        border-left: 4px solid var(--color-primary-kebutuhan);
    }
    .kebutuhan-item-dana-info strong {
        color: var(--color-text-header-kebutuhan);
        font-weight: 600;
    }
    .kebutuhan-item-dana-info .target-dana {
        display: block; margin-top: 0.3rem;
    }
    .kebutuhan-item-dana-info .sisa-hari {
        display: block;
        margin-top: 0.3rem;
        font-size: 0.8rem;
    }
    .kebutuhan-item-dana-info .sisa-hari i {
        color: var(--color-primary-kebutuhan);
    }

    .kebutuhan-item-actions {
        margin-top: auto;
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .btn-kebutuhan-detail, .btn-kebutuhan-donasi {
        padding: 0.7rem 1.3rem;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: var(--border-radius-kebutuhan);
        text-decoration: none;
        text-align: center;
        transition: all 0.25s ease;
        border: 2px solid transparent;
        flex-grow: 1;
        min-width: 140px;
    }
    .btn-kebutuhan-detail {
        background-color: transparent;
        color: var(--color-primary-kebutuhan);
        border-color: var(--color-primary-kebutuhan);
    }
    .btn-kebutuhan-detail:hover {
        background-color: var(--color-primary-kebutuhan);
        color: white;
    }
    .btn-kebutuhan-donasi {
        background-color: var(--color-secondary-kebutuhan);
        color: white;
        border-color: var(--color-secondary-kebutuhan);
    }
    .btn-kebutuhan-donasi:hover {
        background-color: #545b62; /* Abu-abu lebih gelap */
        border-color: #545b62;
        transform: translateY(-1px);
    }

    /* PAGINATION (Sama seperti sebelumnya) */
    .pagination-wrapper-custom {
        margin-top: 3.5rem;
        display: flex;
        justify-content: center;
    }
    .pagination .page-item .page-link {
        color: var(--color-primary-kebutuhan);
        border-radius: var(--border-radius-sm-kebutuhan) !important;
        margin: 0 0.2rem;
        border-color: var(--color-border-kebutuhan);
    }
    .pagination .page-item.active .page-link {
        background-color: var(--color-primary-kebutuhan);
        border-color: var(--color-primary-kebutuhan);
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
    }
    .pagination .page-item .page-link:hover {
        background-color: var(--color-bg-hero-kebutuhan);
        border-color: var(--color-primary-kebutuhan);
    }

    /* NO KEBUTUHAN (EMPTY STATE - Sama seperti sebelumnya) */
    .no-kebutuhan-found {
        text-align: center;
        padding: 4rem 1.5rem;
        background-color: var(--color-bg-item-hover);
        border-radius: var(--border-radius-kebutuhan);
        box-shadow: var(--shadow-soft-kebutuhan);
    }
    .no-kebutuhan-found .icon-placeholder {
        font-size: 3.5rem;
        color: var(--color-primary-kebutuhan);
        margin-bottom: 1.5rem;
        opacity: 0.7;
    }
    .no-kebutuhan-found h4 {
        font-size: 1.4rem;
        color: var(--color-text-header-kebutuhan);
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    .no-kebutuhan-found p {
        font-size: 1rem;
        color: var(--color-text-muted-kebutuhan);
        margin-bottom: 1.5rem;
    }
    .no-kebutuhan-found a {
        color: var(--color-primary-kebutuhan);
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px dashed var(--color-primary-kebutuhan);
        padding-bottom: 2px;
        transition: color 0.2s, border-color 0.2s;
    }
    .no-kebutuhan-found a:hover {
        color: #0b5ed7; /* Biru lebih gelap */
        border-color: #0b5ed7;
    }

    /* Media Queries (penyesuaian minor jika perlu) */
    @media (min-width: 768px) {
        .kebutuhan-list-item {
            flex-direction: row;
            align-items: flex-start;
        }
        .kebutuhan-item-image-link {
            width: 250px; /* Lebar gambar di desktop disesuaikan */
            height: 190px; /* Tinggi disesuaikan */
        }
        .btn-kebutuhan-detail, .btn-kebutuhan-donasi {
             flex-grow: 0;
        }
         .kebutuhan-hero-title {
            font-size: 3.8rem;
        }
         .kebutuhan-hero-subtitle {
            font-size: 1.25rem;
        }
    }
    @media (min-width: 992px) {
        .kebutuhan-item-image-link {
            width: 280px;
            height: 210px;
        }
        .kebutuhan-item-content h3 {
            font-size: 1.5rem;
        }
         .kebutuhan-item-deskripsi {
            font-size: 0.95rem;
        }
    }
    @media (max-width: 576px) { /* Penyesuaian untuk mobile kecil */
        .kebutuhan-hero-title {
            font-size: 2.5rem;
        }
        .kebutuhan-hero-subtitle {
            font-size: 1.05rem;
        }
        .kebutuhan-hero-tagline {
            font-size: 0.85rem;
            padding: 0.4rem 1rem;
        }
        .section-title-kebutuhan {
            font-size: 1.8rem;
        }
        .section-subtitle-kebutuhan {
            font-size: 0.95rem;
            margin-bottom: 2.5rem;
        }
        .kebutuhan-list-item {
            padding: 1.2rem;
        }
        .kebutuhan-item-content h3 {
            font-size: 1.25rem;
        }
        .kebutuhan-item-image-link {
            height: 200px;
        }
    }

</style>
@endpush

@section('content')
<!-- HERO SECTION -->
<section class="kebutuhan-hero-section" id="hero-kebutuhan">
    <div class="kebutuhan-hero-content">
        <span class="kebutuhan-hero-tagline">Bersama Kita Bisa</span>
        <h1 class="kebutuhan-hero-title">Bantu Penuhi Kebutuhan, Ukir Masa Depan</h1>
        <p class="kebutuhan-hero-subtitle">
            Setiap kontribusi Anda adalah cahaya harapan bagi anak-anak di {{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }}. Mari bersama-sama wujudkan impian mereka.
        </p>
        {{-- Tombol CTA dihapus --}}
    </div>
    <a href="#daftar-kebutuhan" class="kebutuhan-hero-scroll-indicator" onclick="event.preventDefault(); document.getElementById('daftar-kebutuhan').scrollIntoView({behavior: 'smooth'});" aria-label="Scroll ke daftar kebutuhan">
        <i class="fas fa-chevron-down"></i>
        <span>Lihat Kebutuhan</span>
    </a>
</section>

<!-- MAIN CONTENT SECTION -->
<div class="kebutuhan-main-content" id="daftar-kebutuhan">
    <div class="kebutuhan-container-public">

        <h2 class="section-title-kebutuhan">Kebutuhan Mendesak Saat Ini</h2>
        <p class="section-subtitle-kebutuhan">
            Uluran tangan Anda, sekecil apapun, akan sangat berarti untuk menunjang kehidupan sehari-hari dan pendidikan mereka.
        </p>

        @if($kebutuhanItems->isNotEmpty())
            <ul class="kebutuhan-list">
                @foreach($kebutuhanItems as $item)
                <li class="kebutuhan-list-item">
                    <a href="{{ route('public.kebutuhan.show', $item->slug) }}" class="kebutuhan-item-image-link">
                        @if($item->gambar_kebutuhan)
                            <img src="{{ Storage::url($item->gambar_kebutuhan) }}" alt="{{ $item->nama_kebutuhan }}" loading="lazy">
                        @else
                            <div class="kebutuhan-item-placeholder">
                                <i class="fas fa-gift"></i> {{-- Ikon placeholder diganti --}}
                                <span>Bantuan Anda Diharapkan</span>
                            </div>
                        @endif
                    </a>
                    <div class="kebutuhan-item-content">
                        <h3><a href="{{ route('public.kebutuhan.show', $item->slug) }}">{{ $item->nama_kebutuhan }}</a></h3>
                        <p class="kebutuhan-item-deskripsi">{{ Str::limit(strip_tags($item->deskripsi), 180) }}</p>

                        @if($item->target_dana > 0)
                        <div class="kebutuhan-item-dana-info">
                            <span class="target-dana">Target Dana: <strong>Rp {{ number_format($item->target_dana, 0, ',', '.') }}</strong></span>
                            @if($item->sisa_hari !== null && $item->sisa_hari >= 0)
                                <span class="sisa-hari">
                                    <i class="fas fa-hourglass-half me-1"></i> {{-- Ikon sisa hari diganti --}}
                                    @if($item->sisa_hari == 0)
                                        Hari terakhir penggalangan!
                                    @else
                                        Tersisa {{ $item->sisa_hari }} hari lagi
                                    @endif
                                </span>
                            @elseif($item->sisa_hari < 0)
                                <span class="sisa-hari text-danger"><i class="fas fa-times-circle me-1"></i>Batas waktu terlewat</span>
                            @endif
                        </div>
                        @else
                        <div class="kebutuhan-item-dana-info">
                            <p class="mb-0">Kebutuhan berupa barang atau dukungan non-finansial.</p>
                        </div>
                        @endif

                        <div class="kebutuhan-item-actions">
                            <a href="{{ route('public.kebutuhan.show', $item->slug) }}" class="btn-kebutuhan-detail"><i class="fas fa-info-circle me-2"></i>Lihat Detail</a>
                            <a href="{{ route('public.donasi.index', ['kebutuhan_id' => $item->id, 'nama_kebutuhan' => $item->nama_kebutuhan]) }}" class="btn-kebutuhan-donasi"><i class="fas fa-donate me-2"></i>Donasi Sekarang</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>

            @if ($kebutuhanItems->hasPages())
            <div class="pagination-wrapper-custom">
                {{ $kebutuhanItems->links() }}
            </div>
            @endif
        @else
            <div class="no-kebutuhan-found">
                <div class="icon-placeholder">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4>Belum Ada Kebutuhan Mendesak</h4>
                <p>Terima kasih atas kepedulian Anda! Saat ini belum ada kebutuhan spesifik yang kami publikasikan.</p>
                <p>Dukungan Anda tetap sangat berarti melalui <a href="{{ route('public.donasi.index') }}">donasi umum</a> untuk operasional panti.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.kebutuhan-list-item');

    if (items.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('is-visible');
                    }, index * 100); // Kurangi delay stagger agar lebih cepat
                }
            });
        }, { threshold: 0.05 });

        items.forEach(item => {
            observer.observe(item);
        });
    }

    // Script parallax di-comment secara default untuk performa
    // Jika ingin digunakan, pastikan untuk menambahkan ID `hero-kebutuhan` ke section hero
    /*
    const heroSection = document.getElementById('hero-kebutuhan');
    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            heroSection.style.backgroundPositionY = `${scrolled * 0.3}px`; // Adjust 0.3 for intensity
        });
    }
    */
});
</script>
@endpush