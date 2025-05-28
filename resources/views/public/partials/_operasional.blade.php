{{-- resources/views/public/partials/_operasional.blade.php --}}
<section id="operasional" class="operasional-section">
    <div class="operasional-background-blob"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-1 operasional-content-left mb-5 mb-lg-0">
                <div class="operasional-pre-title d-flex align-items-center mb-2">
                    <span class="line me-2"></span>
                    <span>Tumbuh Dengan Harapan</span>
                </div>
                <h2 class="operasional-main-title mb-4">Mengenai Jam Operasional</h2>

                <ul class="list-unstyled operasional-info-list">
                    <li class="d-flex align-items-start mb-4">
                        <div class="icon-wrapper jam-operasional me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4 class="item-title">Jam Operasional</h4>
                            {{-- Teks Statis Sesuai Permintaan --}}
                            <p class="item-text">Senin - Jumat: 08.00 - 17.00 WIB. Sabtu: 09.00 - 15.00 WIB. Minggu & Hari Libur Nasional: Tutup untuk kunjungan umum, kecuali dengan perjanjian.</p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start mb-4">
                        <div class="icon-wrapper kunjungan me-3">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h4 class="item-title">Kunjungan</h4>
                            {{-- Teks Statis Sesuai Permintaan --}}
                            <p class="item-text">Untuk kenyamanan bersama, mohon konfirmasi kunjungan Anda minimal 1 hari sebelumnya melalui kontak yang tersedia.</p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start">
                        <div class="icon-wrapper lokasi me-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 class="item-title">Lokasi</h4>
                            {{-- Deskripsi Lokasi Dinamis dari Profil Panti --}}
                            @if(isset($profilPanti) && $profilPanti->lokasi_deskripsi)
                                <p class="item-text">{!! nl2br(e($profilPanti->lokasi_deskripsi)) !!}</p>
                            @else
                                <p class="item-text">Informasi lokasi detail akan segera tersedia. Silakan hubungi kami untuk petunjuk arah.</p>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 order-lg-2 operasional-content-right">
                <div class="operasional-image-card">
                    {{-- Gambar Dinamis dari Profil Panti (misalnya lokasi_img atau tentang_kami_img) --}}
                    @if(isset($profilPanti) && $profilPanti->lokasi_img)
                        <img src="{{ asset('storage/' . $profilPanti->lokasi_img) }}" alt="Lokasi Panti Asuhan Rumah Harapan" class="img-fluid">
                    @elseif(isset($profilPanti) && $profilPanti->tentang_kami_img)
                        {{-- Fallback ke gambar tentang_kami_img jika lokasi_img tidak ada --}}
                        <img src="{{ asset('storage/' . $profilPanti->tentang_kami_img) }}" alt="Panti Asuhan Rumah Harapan" class="img-fluid">
                    @else
                        {{-- Gambar placeholder jika tidak ada data dari admin --}}
                        <img src="{{ asset('images/panti_building_example.jpg') }}" alt="Panti Asuhan Rumah Harapan" class="img-fluid">
                    @endif
                    <div class="image-caption">
                        Panti Asuhan Rumah Harapan
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>