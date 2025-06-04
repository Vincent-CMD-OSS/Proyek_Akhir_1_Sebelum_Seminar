{{-- resources/views/public/partials/_galeri.blade.php --}}

@push('styles')
<style>
    /* Variabel Warna Biru & Ukuran Tombol */
    :root {
        --galeri-btn-blue-primary: #0d6efd;
        --galeri-btn-blue-hover: #0b5ed7;
        --galeri-btn-blue-focus-shadow: rgba(13, 110, 253, 0.25);
        --galeri-btn-text-light: #ffffff;
        --galeri-btn-padding-y: 0.5rem;      /* Padding Y standar */
        --galeri-btn-padding-x: 1rem;       /* Padding X standar */
        --galeri-btn-font-size: 0.875rem;   /* Font size standar (14px) */
        --galeri-btn-line-height: 1.5;
        --galeri-btn-border-radius: 0.375rem; /* Radius standar (6px) */
    }

    /* Base Button Style */
    .btn-galeri-base {
        display: inline-flex; align-items: center; justify-content: center;
        font-weight: 500; text-align: center; text-decoration: none;
        vertical-align: middle; cursor: pointer; user-select: none;
        border: 1px solid transparent;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        padding: var(--galeri-btn-padding-y) var(--galeri-btn-padding-x);
        font-size: var(--galeri-btn-font-size);
        line-height: var(--galeri-btn-line-height);
        border-radius: var(--galeri-btn-border-radius);
    }
    .btn-galeri-base i { margin-right: 0.4rem; font-size: 0.9em; }

    /* Tombol Biru Solid */
    .btn-galeri-biru {
        background-color: var(--galeri-btn-blue-primary); color: var(--galeri-btn-text-light); border-color: var(--galeri-btn-blue-primary);
    }
    .btn-galeri-biru:hover { background-color: var(--galeri-btn-blue-hover); border-color: var(--galeri-btn-blue-hover); color: var(--galeri-btn-text-light); }
    .btn-galeri-biru:focus { box-shadow: 0 0 0 0.25rem var(--galeri-btn-blue-focus-shadow); outline: 0; }

    /* Tombol Biru Outline */
    .btn-outline-galeri-biru {
        color: var(--galeri-btn-blue-primary); border-color: var(--galeri-btn-blue-primary); background-color: transparent;
    }
    .btn-outline-galeri-biru:hover { color: var(--galeri-btn-text-light); background-color: var(--galeri-btn-blue-primary); border-color: var(--galeri-btn-blue-primary); }
    .btn-outline-galeri-biru:focus { box-shadow: 0 0 0 0.25rem var(--galeri-btn-blue-focus-shadow); outline: 0; }

    /* Modifier untuk Ukuran Tombol Lebih Besar */
    .btn-galeri-lg {
        padding: 0.75rem 1.75rem;
        font-size: 1rem; /* 16px */
        border-radius: 0.5rem; /* 8px */
    }
</style>
@endpush

<section id="galeri" class="scrollspy-section padding-large" style="padding-top: 100px; padding-bottom: 100px;">
    <div class="container">
        {{-- Header Section Galeri (biarkan seperti yang sudah ada) --}}
        <div class="row">
           <div class="col-md-12">
                <div class="galeri-section-header text-center mb-5 pb-3" style="margin-top: 5%;">
                    <p class="galeri-pre-title mb-2"><span>Dokumentasi kegiatan</span></p>
                    <h2 class="galeri-main-title mb-3">Galeri Digital</h2>
                    <p class="galeri-subtitle">
                        Ikuti berbagai kegiatan, pencapaian, dan momen inspiratif dari anak-anak dan keluarga
                        besar Rumah Harapan dalam membangun masa depan yang lebih baik.
                    </p>
                </div>
            </div>
        </div>

        @if(isset($galeriUtama) && $galeriUtama)
            <div class="row mt-5 align-items-stretch">
                {{-- Kolom Galeri Utama (Kiri) --}}
                <div class="col-lg-7 col-md-6 mb-4 mb-md-0">
                    <div class="galeri-item h-100 d-flex flex-column">
                        <figure class="galeri-image flex-grow-1">
                            <a href="{{ route('public.galeri.show', ['identifier' => $galeriUtama->slug ?: $galeriUtama->id]) }}">
                                <img src="{{ $galeriUtama->gambar ? Storage::url($galeriUtama->gambar) : asset('images/placeholder-galeri-besar.jpg') }}" alt="{{ $galeriUtama->judul }}" class="img-fluid rounded shadow">
                            </a>
                            <div class="date-badge">
                                <span>{{ $galeriUtama->tanggal_kegiatan ? $galeriUtama->tanggal_kegiatan->format('d M Y') : $galeriUtama->created_at->format('d M Y') }}</span>
                            </div>
                        </figure>
                        <div class="galeri-content mt-4">
                            <h3>
                                <a href="{{ route('public.galeri.show', ['identifier' => $galeriUtama->slug ?: $galeriUtama->id]) }}" class="text-decoration-none" style="color: inherit;">
                                    {{ $galeriUtama->judul }}
                                </a>
                            </h3>
                            <p>{{ Str::limit(strip_tags($galeriUtama->deskripsi), 150, '...') }}</p>
                            {{-- Tombol Lihat Detail - Menggunakan kelas standar --}}
                            <a href="{{ route('public.galeri.show', ['identifier' => $galeriUtama->slug ?: $galeriUtama->id]) }}" class="btn-galeri-base btn-outline-galeri-biru mt-3">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kolom Galeri List Kecil (Kanan) --}}
                <div class="col-lg-5 col-md-6">
                    <div class="row">
                        @forelse ($galeriListKecil as $itemKecil)
                            <div class="col-12 {{ !$loop->last ? 'mb-4' : '' }}">
                                <div class="galeri-item-small d-flex align-items-start">
                                    <figure class="galeri-image-small me-3" style="flex-shrink: 0; width: 120px; height: 90px;">
                                        <a href="{{ route('public.galeri.show', ['identifier' => $itemKecil->slug ?: $itemKecil->id]) }}">
                                            <img src="{{ $itemKecil->gambar ? Storage::url($itemKecil->gambar) : asset('images/placeholder-galeri-kecil.jpg') }}" alt="{{ $itemKecil->judul }}" class="img-fluid rounded shadow" style="width: 100%; height: 100%; object-fit: cover;">
                                        </a>
                                    </figure>
                                    <div class="galeri-content-small">
                                        <h4 style="font-size: 1rem; margin-bottom: 0.3rem;">
                                            <a href="{{ route('public.galeri.show', ['identifier' => $itemKecil->slug ?: $itemKecil->id]) }}" class="text-decoration-none" style="color: inherit; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $itemKecil->judul }}
                                            </a>
                                        </h4>
                                        <p class="mb-2" style="font-size: 0.85rem; color: #6c757d;">{{ Str::limit(strip_tags($itemKecil->deskripsi), 60, '...') }}</p>
                                        {{-- Tombol "Selengkapnya" - Menggunakan kelas standar --}}
                                        <a href="{{ route('public.galeri.show', ['identifier' => $itemKecil->slug ?: $itemKecil->id]) }}" class="btn-galeri-base btn-outline-galeri-biru mt-1">
                                            <i class="fas fa-arrow-right"></i> Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">Belum ada item galeri lainnya.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @else
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <p class="alert alert-info">Belum ada kegiatan yang didokumentasikan di galeri.</p>
                </div>
            </div>
        @endif

        {{-- Tombol Lihat Semua Galeri - Menggunakan kelas standar dengan modifier ukuran besar --}}
        <div class="row mt-5 pt-4" style="margin-top: 60px !important;">
            <div class="col-12 text-center">
                <a href="{{ route('public.galeri.index') }}" class="btn-galeri-base btn-galeri-biru btn-galeri-lg">
                    <i class="fas fa-images"></i> Lihat Semua Galeri
                </a>
            </div>
        </div>
    </div>
</section>