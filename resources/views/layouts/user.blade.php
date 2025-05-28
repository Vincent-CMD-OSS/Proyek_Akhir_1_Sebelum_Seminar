{{-- views/layouts/user.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Judul Halaman Dinamis --}}
    <title>@yield('title', config('app.name', 'Laravel') . ' - Panti Asuhan Rumah Harapan')</title>

    <!-- Fonts (jika menggunakan) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- Tambahkan Font Awesome jika belum di-include di app.css/app.js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />


    <!-- Scripts & Styles (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    

    @stack('styles') {{-- Untuk CSS spesifik per halaman --}}
</head>
<body class="font-sans antialiased"> {{-- Kelas Tailwind, sesuaikan jika tidak pakai --}}
    {{-- Ganti bg-gray-100 jika tidak sesuai dengan desain publikmu --}}
    <div class="min-h-screen"> {{-- Ganti bg-gray-100 jika tidak sesuai --}}

        {{-- Include Navbar Publik --}}
        @include('public.partials._navbar') {{-- PASTIKAN PATH INI BENAR --}}

        <!-- Page Content -->
        <main>
            {{-- Hapus container bawaan jika section sudah punya container sendiri --}}
            {{-- <div class="container mx-auto px-4 py-8"> --}}
                @yield('content') {{-- Konten spesifik halaman akan masuk di sini --}}
            {{-- </div> --}}
        </main>

        {{-- Include Footer Publik --}}
        @include('public.partials._footer') {{-- PASTIKAN PATH INI BENAR --}}

    </div>

    @stack('scripts') {{-- Untuk JS spesifik per halaman --}}
</body>
</html>