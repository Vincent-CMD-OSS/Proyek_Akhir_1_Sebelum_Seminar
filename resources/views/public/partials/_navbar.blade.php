{{-- resources/views/public/partials/_navbar.blade.php --}}
<nav id="site-navbar" class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            {{-- Bisa ganti dengan gambar logo jika ada --}}
            {{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavPublic" aria-controls="navbarNavPublic" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i> {{-- Ikon burger menu --}}
        </button>
        <div class="collapse navbar-collapse" id="navbarNavPublic">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.profil_panti.index') }}">Profil</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.galeri.index') }}">Galeri</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.operasional.index') }}">Operasional</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.kebutuhan.index') }}">Kebutuhan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.donasi.index') }}">Donasi</a>
                </li>
                {{-- Tambahkan menu lain jika ada, misal: Kegiatan, Kebutuhan --}}
                <li class="nav-item">
                    {{-- Nanti akan diganti route ke halaman login admin --}}
                    <a class="nav-link" href="{{ route('login') }}">Login Admin</a>
                </li>
            </ul>
            <a href="#donasi" class="btn btn-donasi-navbar ms-lg-3">Donasi Sekarang</a> {{-- Nanti akan diganti route ke halaman donasi --}}
        </div>
    </div>
</nav>