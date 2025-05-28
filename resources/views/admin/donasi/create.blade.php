{{-- resources/views/admin/donasi/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Catatan Donasi Baru')
@section('page-title', 'Tambah Donasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Donasi
                        @if($selectedKebutuhanId && ($k = $kebutuhanList->get($selectedKebutuhanId)))
                            <small class="text-muted d-block">Untuk Kebutuhan: {{ $k }}</small>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.donasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.donasi.partials._form', [
                            'donasi' => null,
                            'kebutuhanList' => $kebutuhanList,
                            'selectedKebutuhanId' => $selectedKebutuhanId,
                            'buttonText' => 'Simpan Donasi'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('admin.donasi.partials._script_image_preview')
@endpush