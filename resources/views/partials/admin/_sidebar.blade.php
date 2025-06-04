{{-- resources/views/partials/admin/_sidebar.blade.php --}}
<aside class="admin-sidebar">
    <div class="sidebar-logo-container">
        <a href="{{ route('admin.dashboard') }}" class="logo-text">
            <img src="https://demos.creative-tim.com/soft-ui-dashboard/assets/img/logo-ct.png" alt="Logo Panti Asuhan" style="height: 24px; margin-right: 8px;">
            {{ config('app.name', 'Rumah Harapan') }}
        </a>
    </div>

    <hr style="margin: 0 1rem 1rem 1rem; border-color: #e9ecef; border-top-width: 1px; opacity: 0.25;">

    <nav class="sidebar-nav">
        <ul>
            <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="menu-icon"><i class="fas fa-tv"></i></span>
                    Dashboard
                </a>
            </li>

            <li class="{{ Request::routeIs('admin.identitas_panti.*') ? 'active' : '' }}">
                <a href="{{ route('admin.identitas_panti.edit') }}">
                    <span class="menu-icon"><i class="fas fa-id-card-alt"></i></span> {{-- Ganti ikon jika perlu --}}
                    Identitas Panti
                </a>
            </li>

            {{-- Item Menu Profil Panti - DIPERBARUI --}}
            <li class="{{ Request::routeIs('admin.profil.panti.*') ? 'active' : '' }}"> {{-- Menggunakan wildcard untuk semua route di bawah profil.panti --}}
                <a href="{{ route('admin.profil.panti.edit') }}"> {{-- Mengarah ke halaman edit --}}
                    <span class="menu-icon"><i class="fas fa-landmark"></i></span>
                    Profil Panti
                </a>
            </li>

            {{-- ... sisa item menu lainnya ... --}}
            <li class="{{ Request::routeIs('admin.galeri*') ? 'active' : '' }}">
                <a href="{{ route('admin.galeri.index') }}">
                    <span class="menu-icon"><i class="fas fa-images"></i></span>
                    Galeri
                </a>
            </li>
            <li class="{{ Request::routeIs('admin.operasional.*') ? 'active' : '' }}">
                <a href="{{ route('admin.operasional.index') }}">
                    <span class="menu-icon"><i class="fas fa-tasks"></i></span>
                    Operasional
                </a>
            </li>
            <li class="{{ Request::routeIs('admin.kebutuhan*') ? 'active' : '' }}">
                <a href="{{ route('admin.kebutuhan.index') }}">
                    <span class="menu-icon"><i class="fas fa-clipboard-list"></i></span>
                    Kebutuhan
                </a>
            </li>
            <li class="{{ Request::routeIs('admin.donasi*') ? 'active' : '' }}">
                 <a href="{{ route('admin.donasi.index') }}">
                    <span class="menu-icon"><i class="fas fa-hand-holding-heart"></i></span>
                    Donasi
                </a>
            </li>

             <li class="{{ Request::routeIs('admin.kunjungan.index') || Request::routeIs('admin.kunjungan.*') ? 'active' : '' }}">
                <a href="{{ route('admin.kunjungan.index') }}">
                    <span class="menu-icon"><i class="fas fa-calendar-check"></i></span>
                    Permintaan Kunjungan
                </a>
            </li>

            <li class="nav-section-title">Pengaturan Akun</li>
            <li class="{{ Request::routeIs('admin.profile.user*') ? 'active' : '' }}">
                <a href="#">
                    <span class="menu-icon"><i class="fas fa-user-circle"></i></span>
                    Profil Saya
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="#" class="btn btn-documentation">Panduan</a>
    </div>
</aside>