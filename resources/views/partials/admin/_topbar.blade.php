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

        @if (Auth::check())

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