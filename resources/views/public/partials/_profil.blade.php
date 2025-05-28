{{-- resources/views/public/partials/_profil.blade.php --}}
<section id="profil" class="profil-section">
    <div class="container content-container">
        <div class="row align-items-center gy-5 gx-lg-4">
            {{-- Kolom Gambar --}}
            <div class="col-lg-6 col-md-12 order-lg-1 order-md-2 order-2 text-center text-lg-start">
                <div class="profil-images-wrapper">
                    <div class="profil-images-column-stacked">
                        {{-- Gambar 1 (dinamis dari sejarah_singkat_img) --}}
                        @if(isset($profilPanti) && $profilPanti->sejarah_singkat_img)
                            <img src="{{ asset('storage/' . $profilPanti->sejarah_singkat_img) }}" alt="Sejarah Panti Asuhan Rumah Harapan" class="img-fluid profil-image-top-stack">
                        @else
                            {{-- Gambar placeholder jika tidak ada data dari admin --}}
                            <img src="{{ asset('images/gambar11.jpg') }}" alt="Kegiatan edukasi keluarga di Panti Asuhan" class="img-fluid profil-image-top-stack">
                        @endif

                        {{-- Gambar 2 (dinamis dari visi_misi_img) --}}
                        @if(isset($profilPanti) && $profilPanti->visi_misi_img)
                            <img src="{{ asset('storage/' . $profilPanti->visi_misi_img) }}" alt="Visi Misi Panti Asuhan Rumah Harapan" class="img-fluid profil-image-bottom-stack">
                        @else
                            {{-- Gambar placeholder jika tidak ada data dari admin --}}
                            <img src="{{ asset('images/Gambar12.jpg') }}" alt="Anak-anak membaca buku bersama" class="img-fluid profil-image-bottom-stack">
                        @endif
                    </div>
                    <div class="profil-image-column-main">
                        {{-- Gambar Utama (dinamis dari tentang_kami_img - sudah dari sebelumnya) --}}
                        @if(isset($profilPanti) && $profilPanti->tentang_kami_img)
                            <img src="{{ asset('storage/' . $profilPanti->tentang_kami_img) }}" alt="Profil Panti Asuhan Rumah Harapan" class="img-fluid profil-image-center">
                        @else
                            <img src="{{ asset('images/Gambar13.jpg') }}" alt="Gedung Panti Asuhan Rumah Harapan" class="img-fluid profil-image-center">
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kolom Teks (tetap sama seperti sebelumnya) --}}
            <div class="col-lg-6 col-md-12 order-lg-2 order-md-1 order-1">
                <div class="profil-text-content">
                    <p class="sub-heading">Siapa Kami?</p>
                    <h2 class="section-title">Tentang Kami</h2>
                    
                    @if(isset($profilPanti) && $profilPanti->tentang_kami_deskripsi)
                        <p class="section-description">
                            {!! nl2br(e($profilPanti->tentang_kami_deskripsi)) !!}
                        </p>
                    @else
                        <p class="section-description">
                            Hope Village adalah komunitas peduli anak yang hadir untuk memberikan
                            tempat tinggal, pendidikan, dan kasih sayang bagi anak-anak yatim dan
                            terlantar di pedesaan Indonesia. Dengan fasilitas seperti sekolah, gereja,
                            klinik medis, dan akses air bersih, kami berkomitmen menciptakan
                            lingkungan yang aman dan penuh harapan agar setiap anak bisa tumbuh,
                            belajar, dan meraih masa depan yang lebih baik. Bersama para sponsor
                            dan relawan, kami membangun bukan hanya rumah, tetapi juga harapan
                            dan masa depan yang cerah bagi generasi mendatang.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>