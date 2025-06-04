<nav id="site-navbar" class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            @if(isset($identitasPanti) && $identitasPanti->logo_path)
                <!-- <img src="{{ asset('storage/' . $identitasPanti->logo_path) }}" alt="{{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }} Logo" style="max-height: 40px; width: auto;"> -->
                <!-- <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }} Logo" style="max-height: 40px; width: auto;"> -->
                <img src="/assets/images/logo.png"
                    alt="Logo"
                    style="max-height: 40px; width: auto; position: absolute; top: 10px; left: 10px; z-index: 9999; background: white;">
            @else
                {{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }}
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavPublic" aria-controls="navbarNavPublic" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i> {{-- Ikon burger menu --}}
        </button>
        <div class="collapse navbar-collapse" id="navbarNavPublic">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    {{-- Untuk Beranda, kita bisa cek route 'home' atau path '/' --}}
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    {{-- Cek nama route untuk Profil Panti --}}
                    <a class="nav-link {{ Route::is('public.profil_panti.index') ? 'active' : '' }}" href="{{ route('public.profil_panti.index') }}">Profil</a>
                </li>
                 <li class="nav-item">
                    {{-- Cek nama route untuk Galeri (termasuk halaman detail jika ada) --}}
                    {{-- Jika halaman detail galeri memiliki route yang berbeda, misal 'public.galeri.show', tambahkan juga --}}
                    <a class="nav-link {{ Route::is('public.galeri.index') || Route::is('public.galeri.show') ? 'active' : '' }}" href="{{ route('public.galeri.index') }}">Galeri</a>
                </li>
                 <li class="nav-item">
                    {{-- Cek nama route untuk Operasional --}}
                    <a class="nav-link {{ Route::is('public.operasional.index') ? 'active' : '' }}" href="{{ route('public.operasional.index') }}">Operasional</a>
                </li>
                <li class="nav-item">
                    {{-- Ganti 'public.kebutuhan.index' dengan nama route yang benar jika sudah ada --}}
                    <a class="nav-link {{ Route::is('public.kebutuhan.index') ? 'active' : '' }}" href="{{ route('public.kebutuhan.index') }}">Kebutuhan</a>
                </li>
                <li class="nav-item">
                     {{-- Ganti 'public.donasi.index' dengan nama route yang benar jika sudah ada --}}
                    <a class="nav-link {{ Route::is('public.donasi.index') ? 'active' : '' }}" href="{{ route('public.donasi.index') }}">Donasi</a>
                </li>
                <li class="nav-item">
                    {{-- Tombol Login Admin tidak perlu 'active' state --}}
                    <a class="nav-link" href="{{ route('login') }}" class="btn btn-donasi-navbar ms-lg-3">Login Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>