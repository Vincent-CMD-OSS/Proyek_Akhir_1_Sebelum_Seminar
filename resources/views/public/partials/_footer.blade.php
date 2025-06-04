<footer id="footer" class="site-footer">
    <div class="container">
        <div class="row footer-widgets">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 footer-widget">
                <h3 class="footer-logo">{{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }}</h3>
                <p class="social-media-title">Sosial Media Kami</p>
                <ul class="social-icons list-unstyled d-flex">
                    @if(isset($identitasPanti) && $identitasPanti->facebook_url)
                        <li><a href="{{ $identitasPanti->facebook_url }}" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                    @endif
                    @if(isset($identitasPanti) && $identitasPanti->instagram_url)
                        <li><a href="{{ $identitasPanti->instagram_url }}" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
                    @endif
                    @if(isset($identitasPanti) && $identitasPanti->youtube_url)
                        <li><a href="{{ $identitasPanti->youtube_url }}" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a></li>
                    @endif
                    {{-- Jika tidak ada link sosial media sama sekali, bisa tampilkan pesan --}}
                    @if(isset($identitasPanti) && !$identitasPanti->facebook_url && !$identitasPanti->instagram_url && !$identitasPanti->youtube_url)
                        <li class="text-muted small">Segera hadir</li>
                    @endif
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 footer-widget">
                <h4 class="footer-title">Akses Cepat</h4>
                <ul class="list-unstyled quick-links">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="#profil">Tentang Kami</a></li>
                    <li><a href="#galeri">Galeri Digital</a></li>
                    <li><a href="#operasional">Jam Operasional</a></li>
                    <li><a href="#donasi">Donasi</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 footer-widget">
                <h4 class="footer-title">Kontak Info</h4>
                <ul class="list-unstyled contact-info">
                    @if(isset($identitasPanti) && $identitasPanti->nomor_wa)
                        <li><i class="fab fa-whatsapp me-2"></i> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $identitasPanti->nomor_wa) }}" target="_blank">{{ $identitasPanti->nomor_wa }}</a></li>
                    @endif
                    @if(isset($identitasPanti) && $identitasPanti->email_panti)
                        <li><i class="fas fa-envelope me-2"></i> <a href="mailto:{{ $identitasPanti->email_panti }}">{{ $identitasPanti->email_panti }}</a></li>
                    @endif
                    @if(isset($identitasPanti) && !$identitasPanti->nomor_wa && !$identitasPanti->email_panti)
                         <li class="text-muted small">Informasi kontak akan segera tersedia.</li>
                    @endif
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-widget">
                <h4 class="footer-title">Lokasi Kami</h4>
                
                {{-- Ambil deskripsi lokasi dari ProfilPanti --}}
                @if(isset($profilPanti) && $profilPanti->lokasi_deskripsi)
                    <p class="location-text">{!! nl2br(e($profilPanti->lokasi_deskripsi)) !!}</p>
                @else
                    <p class="location-text">Jl. Harapan Bangsa No. 123, Kota Sejahtera, Indonesia 12345</p>
                @endif

                <div class="map-container"> {{-- Ganti nama class dari map-placeholder --}}
                    @if(isset($identitasPanti) && $identitasPanti->lokasi_gmaps)
                        @php
                            $gmapsContent = $identitasPanti->lokasi_gmaps;
                        @endphp
                        {{-- Cek apakah itu kode iframe --}}
                        @if(str_contains(strtolower($gmapsContent), '<iframe'))
                            {{-- Jika iframe, tampilkan langsung (pastikan admin memasukkan kode yang aman) --}}
                            {!! $gmapsContent !!}
                        @else
                            {{-- Jika hanya link, tampilkan gambar placeholder yang bisa diklik --}}
                            <a href="{{ $gmapsContent }}" target="_blank" class="map-link-placeholder">
                                <img src="{{ asset('images/maps_placeholder.png') }}" alt="Lihat Peta Lokasi Rumah Harapan" class="img-fluid rounded">
                                <span class="map-link-text">Lihat di Google Maps</span>
                            </a>
                        @endif
                    @else
                        {{-- Fallback jika tidak ada data gmaps --}}
                        <a href="#" class="map-link-placeholder">
                            <img src="{{ asset('images/maps_placeholder.png') }}" alt="Peta Lokasi Rumah Harapan" class="img-fluid rounded">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="copyright-text text-center mb-0">© {{ date('Y') }} {{ $identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan' }}. All Rights Reserved.</p>
        </div>
    </div>
</footer>