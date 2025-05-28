<header class="admin-topbar">
    <div class="topbar-left">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">@yield('page-title', 'Dashboard')</li>
            </ol>
        </nav>
        <h6 class="page-main-title">@yield('page-title', 'Dashboard')</h6>
    </div>

    <div class="topbar-right">
        <div class="search-bar">
            {{-- Ganti input dengan styling Bootstrap jika perlu atau gunakan custom style dari admin-styles.css --}}
            <input type="text" class="form-control" placeholder="Type here...">
        </div>
        <a href="#" class="btn-online-builder">Online Builder</a>

        @if (Auth::check())
            <button class="topbar-icon-btn">
                <i class="fas fa-star"></i> <span class="badge bg-info text-dark">11,141</span> {{-- Sesuaikan kelas badge Bootstrap --}}
            </button>
            <button class="topbar-icon-btn">
                <i class="fas fa-cog"></i>
            </button>
            <button class="topbar-icon-btn">
                <i class="fas fa-bell"></i>
            </button>

            {{-- Info User & Tombol Logout (sesuaikan dengan kebutuhan Anda) --}}
            <div class="dropdown">
                <button class="topbar-icon-btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                    <span class="d-none d-sm-inline ms-1">{{ Auth::user()->nama ?? 'User' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li> {{-- Ganti dengan route profil --}}
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout.submit') }}"> {{-- Ganti dengan route logout Anda --}}
                            @csrf
                            <button type="submit" class="dropdown-item">Sign Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="topbar-icon-btn"><i class="fas fa-user-circle"></i> Sign In</a>  {{-- Ganti dengan route login Anda --}}
        @endif
    </div>
</header>