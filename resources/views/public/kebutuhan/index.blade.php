@extends('layouts.user') {{-- Sesuaikan dengan layout publik utama Anda --}}

@section('title', 'Kebutuhan Panti - ' . ($identitasPanti->nama_panti ?? 'Rumah Harapan'))

@push('styles')
<style>
    :root {
        --color-bg-hero-kebutuhan: #e3f2fd; /* Biru langit sangat muda untuk hero */
        --color-bg-main-kebutuhan: #ffffff;
        --color-bg-item-hover: #f8fafc;
        --color-primary-kebutuhan: #007bff; /* Biru primer Bootstrap sebagai dasar */
        --color-accent-kebutuhan: #ffc107; /* Kuning Bootstrap sebagai aksen */
        --color-text-header-kebutuhan: #212529; /* Hitam Bootstrap */
        --color-text-body-kebutuhan: #495057;   /* Abu-abu Bootstrap */
        --color-text-muted-kebutuhan: #6c757d;
        --color-border-kebutuhan: #dee2e6;
        --font-family-kebutuhan: 'Nunito Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; /* Font yang lebih bulat dan modern */
        --shadow-soft-kebutuhan: 0 4px 15px rgba(0, 0, 0, 0.07);
        --shadow-medium-kebutuhan: 0 8px 25px rgba(0, 0, 0, 0.09);
        --border-radius-kebutuhan: 0.5rem; /* 8px */
    }

    body {
        font-family: var(--font-family-kebutuhan);
        background-color: var(--color-bg-main-kebutuhan);
        color: var(--color-text-body-kebutuhan);
        line-height: 1.7;
        margin: 0;
    }

    /* HERO SECTION */
    .kebutuhan-hero-section {
        min-height: 85vh; /* Lebih pendek dari 100vh */
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--color-bg-hero-kebutuhan) 0%, #ffffff 100%);
        padding: 3rem 1.5rem;
        text-align: center;
        position: relative; /* Untuk parallax effect jika diinginkan */
    }
    .kebutuhan-hero-content {
        max-width: 750px;
        z-index: 1; /* Agar di atas elemen parallax background */
    }
    .kebutuhan-hero-title {
        font-size: 2.8rem;
        font-weight: 800; /* Lebih bold */
        color: var(--color-text-header-kebutuhan);
        margin-bottom: 0.75rem;
        line-height: 1.2;
    }
    .kebutuhan-hero-subtitle {
        font-size: 1.15rem;
        color: var(--color-text-muted-kebutuhan);
        margin-bottom: 2rem;
    }
    .kebutuhan-hero-scroll {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        color: var(--color-primary-kebutuhan);
        cursor: pointer;
        animation: bounce 2s infinite;
        z-index: 1;
    }
    .kebutuhan-hero-scroll i { font-size: 1.5rem; }
    .kebutuhan-hero-scroll span { display: block; font-size: 0.8rem; margin-top: 0.25rem; }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
        40% { transform: translateX(-50%) translateY(-10px); }
        60% { transform: translateX(-50%) translateY(-5px); }
    }

    /* MAIN CONTENT SECTION */
    .kebutuhan-main-content {
        padding: 3rem 1.5rem;
    }
    .kebutuhan-container-public { /* Ganti nama agar tidak konflik jika ada .kebutuhan-container lain */
        max-width: 960px;
        margin: 0 auto;
    }

    /* SEARCH FORM */
    .search-form-wrapper {
        margin-bottom: 3rem;
        background-color: var(--color-bg-main-kebutuhan);
        padding: 1.5rem;
        border-radius: var(--border-radius-kebutuhan);
        box-shadow: var(--shadow-soft-kebutuhan);
    }
    .search-form-wrapper form {
        display: flex;
        gap: 0.75rem;
    }
    .search-form-wrapper .form-control-search { /* Custom class */
        flex-grow: 1;
        padding: 0.8rem 1rem;
        font-size: 1rem;
        border: 1px solid var(--color-border-kebutuhan);
        border-radius: var(--border-radius-kebutuhan);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-form-wrapper .form-control-search:focus {
        border-color: var(--color-primary-kebutuhan);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.2);
        outline: none;
    }
    .search-form-wrapper .btn-search-submit { /* Custom class */
        background-color: var(--color-primary-kebutuhan);
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: var(--border-radius-kebutuhan);
        cursor: pointer;
        transition: background-color 0.2s;
        font-weight: 500;
    }
    .search-form-wrapper .btn-search-submit:hover {
        background-color: #0056b3; /* Biru lebih gelap */
    }

    /* KEBUTUHAN ITEM LISTING (Bukan Card) */
    .kebutuhan-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    .kebutuhan-list-item {
        display: flex;
        flex-direction: column; /* Default untuk mobile */
        gap: 1.5rem;
        padding: 1.75rem 0;
        border-bottom: 1px solid var(--color-border-kebutuhan);
        background-color: transparent; /* Tidak ada background per item */
        transition: background-color 0.3s ease;
        opacity: 0; /* Untuk animasi */
        transform: translateY(30px);
        transition-property: opacity, transform, background-color;
        transition-duration: 0.6s;
        transition-timing-function: ease-out;
    }
    .kebutuhan-list-item:last-child {
        border-bottom: none;
    }
    .kebutuhan-list-item:hover {
        background-color: var(--color-bg-item-hover); /* Efek hover halus */
        /* box-shadow: var(--shadow-soft-kebutuhan); */ /* Opsional: shadow on hover */
        /* border-radius: var(--border-radius-kebutuhan); */ /* Opsional: radius on hover */
        /* padding: 1.75rem; */ /* Opsional: padding on hover */
        /* margin: 0 -1.75rem; */ /* Opsional: agar hover full width jika ada padding di parent */
    }
    .kebutuhan-list-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .kebutuhan-item-image-link {
        display: block;
        width: 100%; /* Full width di mobile */
        height: 220px; /* Tinggi gambar tetap */
        border-radius: var(--border-radius-kebutuhan);
        overflow: hidden;
        background-color: #e9ecef; /* Warna placeholder */
        flex-shrink: 0; /* Agar tidak mengecil */
    }
    .kebutuhan-item-image-link img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .kebutuhan-item-image-link:hover img {
        transform: scale(1.05);
    }
    .kebutuhan-item-placeholder { /* Jika tidak ada gambar */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 0.9rem;
        color: var(--color-text-muted-kebutuhan);
    }

    .kebutuhan-item-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .kebutuhan-item-content h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1.5rem; /* Judul lebih besar */
        font-weight: 700;
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
        font-size: 0.95rem;
        color: var(--color-text-body-kebutuhan);
        margin-bottom: 1rem;
        flex-grow: 1; /* Agar deskripsi mengisi ruang */
        line-height: 1.6;
    }
    .kebutuhan-item-dana-info {
        font-size: 0.9rem;
        color: var(--color-text-muted-kebutuhan);
        margin-bottom: 1.25rem;
        padding: 0.75rem;
        background-color: #f9f9f9;
        border-radius: var(--border-radius-sm);
    }
    .kebutuhan-item-dana-info strong {
        color: var(--color-text-header-kebutuhan);
    }
    .kebutuhan-item-dana-info .target-dana {
        display: block; margin-top: 0.25rem;
    }
    .kebutuhan-item-dana-info .sisa-hari {
        font-style: italic;
        margin-left: 0.5rem;
    }


    .kebutuhan-item-actions {
        margin-top: auto; /* Dorong tombol ke bawah */
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap; /* Agar tombol wrap di mobile */
    }
    .btn-kebutuhan-detail, .btn-kebutuhan-donasi { /* Custom button classes */
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: var(--border-radius-kebutuhan);
        text-decoration: none;
        text-align: center;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        flex-grow: 1; /* Agar tombol mengisi ruang jika hanya 1 atau 2 */
        min-width: 130px; /* Lebar minimum tombol */
    }
    .btn-kebutuhan-detail {
        background-color: var(--color-bg-white);
        color: var(--color-primary-kebutuhan);
        border-color: var(--color-primary-kebutuhan);
    }
    .btn-kebutuhan-detail:hover {
        background-color: var(--color-primary-kebutuhan);
        color: white;
    }
    .btn-kebutuhan-donasi {
        background-color: var(--color-accent-kebutuhan);
        color: var(--color-text-header-kebutuhan);
    }
    .btn-kebutuhan-donasi:hover {
        background-color: #ffb300; /* Kuning lebih gelap */
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* PAGINATION */
    .pagination-wrapper-custom { /* Custom class */
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }
    /* Anda bisa menambahkan styling custom untuk pagination jika default Bootstrap tidak cukup */

    /* NO KEBUTUHAN (EMPTY STATE) */
    .no-kebutuhan-found { /* Custom class */
        text-align: center;
        padding: 3rem 1rem;
        background-color: var(--color-bg-item-hover);
        border-radius: var(--border-radius-kebutuhan);
    }
    .no-kebutuhan-found p {
        font-size: 1.1rem;
        color: var(--color-text-muted-kebutuhan);
        margin-bottom: 0.5rem;
    }
    .no-kebutuhan-found a {
        color: var(--color-primary-kebutuhan);
        font-weight: 500;
    }

    /* Media Query untuk layout item di layar lebih besar */
    @media (min-width: 768px) {
        .kebutuhan-list-item {
            flex-direction: row; /* Gambar di kiri, konten di kanan */
            align-items: flex-start; /* Vertikal align ke atas */
        }
        .kebutuhan-item-image-link {
            width: 250px; /* Lebar gambar tetap di desktop */
            height: 180px; /* Tinggi gambar disesuaikan */
        }
        .btn-kebutuhan-detail, .btn-kebutuhan-donasi {
             flex-grow: 0; /* Tombol tidak stretch full width */
        }
    }
</style>
@endpush

@section('content')
<!-- HERO SECTION -->
<section class="kebutuhan-hero-section">
    <div class="kebutuhan-hero-content">
        {{-- <title> sudah di @section('title') --}}
        <h1 class="kebutuhan-hero-title">Dukung Kebutuhan Mereka</h1>
        <p class="kebutuhan-hero-subtitle">
            Setiap bantuan Anda, baik materi maupun non-materi, sangat berarti untuk menunjang kehidupan sehari-hari dan pendidikan anak-anak di {{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }}.
        </p>
    </div>
    <div class="kebutuhan-hero-scroll" onclick="document.querySelector('.kebutuhan-main-content').scrollIntoView({behavior: 'smooth'})">
        <i class="fas fa-chevron-down"></i>
        <span>Lihat Kebutuhan</span>
    </div>
</section>

<!-- MAIN CONTENT SECTION -->
<div class="kebutuhan-main-content">
    <div class="kebutuhan-container-public">
        {{-- Formulir Pencarian --}}
        <div class="search-form-wrapper">
            <form action="{{ route('public.kebutuhan.index') }}" method="GET">
                <input type="text" name="search" class="form-control-search" placeholder="Cari berdasarkan nama kebutuhan..." value="{{ request('search') }}">
                <button type="submit" class="btn-search-submit"><i class="fas fa-search me-1"></i> Cari</button>
            </form>
        </div>

        @if($kebutuhanItems->isNotEmpty())
            <ul class="kebutuhan-list">
                @foreach($kebutuhanItems as $item)
                <li class="kebutuhan-list-item">
                    <a href="{{ route('public.kebutuhan.show', $item->slug) }}" class="kebutuhan-item-image-link">
                        @if($item->gambar_kebutuhan)
                            <img src="{{ Storage::url($item->gambar_kebutuhan) }}" alt="{{ $item->nama_kebutuhan }}">
                        @else
                            <div class="kebutuhan-item-placeholder">
                                <span>Gambar Tidak Tersedia</span>
                            </div>
                        @endif
                    </a>
                    <div class="kebutuhan-item-content">
                        <h3><a href="{{ route('public.kebutuhan.show', $item->slug) }}">{{ $item->nama_kebutuhan }}</a></h3>
                        <p class="kebutuhan-item-deskripsi">{{ Str::limit(strip_tags($item->deskripsi), 150) }}</p>

                        @if($item->target_dana > 0)
                        <div class="kebutuhan-item-dana-info">
                            <!-- <span>Terkumpul: <strong>Rp {{ number_format($item->dana_terkumpul, 0, ',', '.') }}</strong></span> -->
                            <span class="target-dana">Target: Rp {{ number_format($item->target_dana, 0, ',', '.') }}</span>
                            @if($item->sisa_hari !== null)
                            <span class="sisa-hari text-muted-kebutuhan"><small><i class="fas fa-clock me-1"></i>{{ $item->sisa_hari }} hari lagi</small></span>
                            @endif
                        </div>
                        @else
                        <div class="kebutuhan-item-dana-info">
                            <p>Ini adalah kebutuhan barang atau non-finansial.</p>
                        </div>
                        @endif

                        <div class="kebutuhan-item-actions">
                            <a href="{{ route('public.kebutuhan.show', $item->slug) }}" class="btn-kebutuhan-detail"><i class="fas fa-info-circle me-1"></i> Detail</a>
                            <a href="{{ route('public.donasi.index', ['kebutuhan_id' => $item->id, 'nama_kebutuhan' => $item->nama_kebutuhan]) }}" class="btn-kebutuhan-donasi"><i class="fas fa-hand-holding-heart me-1"></i> Donasi</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>

            @if ($kebutuhanItems->hasPages())
            <div class="pagination-wrapper-custom">
                {{ $kebutuhanItems->appends(request()->query())->links() }}
            </div>
            @endif
        @else
            <div class="no-kebutuhan-found">
                <p><i class="fas fa-search fa-2x mb-2 text-muted-kebutuhan"></i></p>
                <p>Oops! Belum ada kebutuhan yang sesuai dengan pencarian Anda atau belum ada kebutuhan yang dipublikasikan saat ini.</p>
                <p>Anda tetap dapat membantu dengan <a href="{{ route('public.donasi.index') }}">berdonasi secara umum</a> untuk operasional panti.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.kebutuhan-list-item');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Tambahkan delay berdasarkan index untuk efek stagger
                setTimeout(() => {
                    entry.target.classList.add('is-visible');
                }, index * 100); // delay 100ms per item
                // observer.unobserve(entry.target); // Jika ingin animasi hanya sekali
            }
        });
    }, { threshold: 0.1 }); // Trigger saat 10% item terlihat

    items.forEach(item => {
        observer.observe(item);
    });

    // Parallax sederhana untuk hero (opsional)
    const heroSection = document.querySelector('.kebutuhan-hero-section');
    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            // Kurangi efek parallax agar tidak terlalu drastis
            heroSection.style.backgroundPositionY = `${scrolled * 0.3}px`;
        });
    }
});
</script>
@endpush