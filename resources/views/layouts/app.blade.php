<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Tetap berguna jika ada form kontak/dll --}}

    <title>{{ config('app.name', 'Laravel') }} - Panti Asuhan Rumah Harapan</title> {{-- Judul sesuai --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> sesuaikan jika pakai Tailwind, Bootstrap, dll --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Scripts & Styles (Gunakan Vite atau Mix) -->
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    {{-- Pastikan path CSS/JS sesuai dengan setup Anda --}}

    @stack('styles') {{-- Untuk CSS tambahan per halaman --}}

</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900"> {{-- Sesuaikan background --}}

        {{-- Include Header Publik --}}
        {{-- @include('layouts.partials.public._header')  --}}

        {{-- Include Navigasi Utama (jika terpisah dari header) --}}
        {{-- @include('layouts.partials.public._navigation') --}}

        <!-- Page Content -->
        <main>
            {{-- Konten spesifik halaman akan dimuat di sini --}}
            @yield('content') 
        </main>

        {{-- Include Footer Publik --}}
        {{-- @include('layouts.partials.public._footer') --}}

    </div>

    @stack('scripts') {{-- Untuk JS tambahan per halaman --}}
</body>
</html>