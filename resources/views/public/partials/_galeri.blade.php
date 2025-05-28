{{-- resources/views/public/partials/_galeri.blade.php --}}
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

        {{-- Cek apakah ada data galeri utama --}}
        @if(isset($galeriUtama) && $galeriUtama)
            <div class="row mt-5 align-items-stretch">
                {{-- Kolom Galeri Utama (Kiri) --}}
                <div class="col-lg-7 col-md-6 mb-4 mb-md-0">
                    <div class="galeri-item h-100 d-flex flex-column">
                        <figure class="galeri-image flex-grow-1">
                            <img src="{{ $galeriUtama->gambar ? Storage::url($galeriUtama->gambar) : asset('images/placeholder-galeri-besar.jpg') }}" alt="{{ $galeriUtama->judul }}" class="img-fluid rounded shadow">
                            <div class="date-badge">
                                <span>{{ $galeriUtama->tanggal_kegiatan ? $galeriUtama->tanggal_kegiatan->format('d M Y') : $galeriUtama->created_at->format('d M Y') }}</span>
                            </div>
                        </figure>
                        <div class="galeri-content mt-4">
                            <h3>{{ $galeriUtama->judul }}</h3>
                            {{-- Potong deskripsi jika terlalu panjang --}}
                            <p>{{ Str::limit(strip_tags($galeriUtama->deskripsi), 150, '...') }}</p>
                            {{-- Tambahkan link ke halaman detail jika ada nanti --}}
                            {{-- <a href="#" class="btn-with-line mt-3">Read more</a> --}}
                        </div>
                    </div>
                </div>

                {{-- Kolom Galeri List Kecil (Kanan) --}}
                <div class="col-lg-5 col-md-6">
                    <div class="row">
                        @forelse ($galeriListKecil as $itemKecil)
                            <div class="col-12 {{ !$loop->last ? 'mb-4' : '' }}">
                                <div class="galeri-item-small d-flex align-items-center">
                                    <figure class="galeri-image-small me-3">
                                        <img src="{{ $itemKecil->gambar ? Storage::url($itemKecil->gambar) : asset('images/placeholder-galeri-kecil.jpg') }}" alt="{{ $itemKecil->judul }}" class="img-fluid rounded shadow">
                                        <div class="date-badge-small">
                                            <span>{{ $itemKecil->tanggal_kegiatan ? $itemKecil->tanggal_kegiatan->format('d M Y') : $itemKecil->created_at->format('d M Y') }}</span>
                                        </div>
                                    </figure>
                                    <div class="galeri-content-small">
                                        <h4>{{ $itemKecil->judul }}</h4>
                                        <p class="mb-0">{{ Str::limit(strip_tags($itemKecil->deskripsi), 70, '...') }}</p>
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
            {{-- Tampilkan pesan jika tidak ada galeri sama sekali --}}
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <p class="alert alert-info">Belum ada kegiatan yang didokumentasikan di galeri.</p>
                </div>
            </div>
        @endif

        {{-- Tombol Lihat Semua Galeri --}}
        <div class="row mt-5 pt-4" style="margin-top: 60px !important;">
            <div class="col-12 text-center">
                {{-- Ganti href jika sudah ada halaman list galeri --}}
                <a href="#" class="btn btn-accent btn-xlarge btn-rounded">Lihat Semua Galeri</a>
            </div>
        </div>
    </div>
</section>