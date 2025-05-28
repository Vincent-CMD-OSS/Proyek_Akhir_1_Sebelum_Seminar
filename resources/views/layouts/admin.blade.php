<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel')) - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    {{-- PILIH SALAH SATU CARA MEMUAT BOOTSTRAP CSS --}}
    {{-- Cara 1: Jika menggunakan CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    {{-- Cara 2: Jika Bootstrap sudah di-compile ke app.css via Vite/Mix (sesuaikan path jika perlu) --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    {{-- atau untuk Vite: --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}


    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Your Custom Admin Styles (HARUS ADA DAN TERISI) -->
    <link rel="stylesheet" href="{{ asset('css/admin-styles.css') }}">

    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="admin-layout">
        @include('partials.admin._sidebar') {{-- Menggunakan sidebar dari file partials --}}

        <main class="main-content-wrapper">
            @include('partials.admin._topbar') {{-- Menggunakan topbar dari file partials --}}

            <div class="page-content">
                @yield('content') {{-- Di sinilah konten spesifik halaman akan ditampilkan --}}
            </div>
        </main>
    </div>

    <!-- Optional: Bootstrap JS Bundle (Popper.js included) - if you need Bootstrap JS components -->
    <!-- {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> --}} -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
    {{-- Jika JS Bootstrap sudah di-compile via Vite/Mix, baris di atas tidak perlu jika sudah ada di app.js --}}
    @stack('scripts')
</body>
</html>