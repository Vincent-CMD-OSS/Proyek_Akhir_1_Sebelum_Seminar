{{-- resources/views/admin/donasi/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Donasi')
{{-- ... --}}
@section('content')
    {{-- ... --}}
    <form action="{{ route('admin.donasi.update', $donasi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.donasi.partials._form', [
            'donasi' => $donasi,
            'kebutuhanList' => $kebutuhanList,
            'selectedKebutuhanId' => $donasi->kebutuhan_id, // Ambil dari $donasi
            'buttonText' => 'Update Donasi'
        ])
    </form>
    {{-- ... --}}
@endsection