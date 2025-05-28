{{-- resources/views/public/home.blade.php --}}
@extends('layouts.user') {{-- Menggunakan layout user.blade.php --}}

@section('title', 'Beranda') {{-- Contoh judul halaman spesifik --}}

@section('content')
    {{-- Tidak perlu @include navbar dan footer lagi di sini --}}
    {{-- Cukup include section-section konten halaman ini --}}
    @include('public.partials._hero')
    @include('public.partials._profil')
    @include('public.partials._galeri')
    @include('public.partials._operasional')
    @include('public.partials._donasi')
    {{-- Include section lain jika ada untuk halaman Beranda --}}
@endsection

@push('styles')
    {{-- CSS spesifik untuk halaman Beranda jika ada --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/home-specific.css') }}"> --}}
@endpush

@push('scripts')
    {{-- JS spesifik untuk halaman Beranda jika ada --}}
    {{-- <script src="{{ asset('js/home-specific.js') }}"></script> --}}
@endpush