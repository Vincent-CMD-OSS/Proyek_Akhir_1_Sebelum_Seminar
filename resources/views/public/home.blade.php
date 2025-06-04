@extends('layouts.user') 

@section('title', 'Beranda')

@section('content')
    @include('public.partials._hero')
    @include('public.partials._profil')
    @include('public.partials._galeri')
    @include('public.partials._operasional')
    @include('public.partials._donasi')
@endsection

@push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/home-specific.css') }}"> --}}
@endpush

@push('scripts')
    {{-- <script src="{{ asset('js/home-specific.js') }}"></script> --}}
@endpush