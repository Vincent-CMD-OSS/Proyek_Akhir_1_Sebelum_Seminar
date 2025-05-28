{{-- resources/views/admin/kebutuhan/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Kebutuhan: ' . $kebutuhan->nama_kebutuhan)
@section('page-title', 'Edit Kebutuhan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Edit Kebutuhan: {{ $kebutuhan->nama_kebutuhan }}</h5></div>
                <div class="card-body">
                    @if (session('error')) {{-- Error spesifik dari controller update --}}
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('admin.kebutuhan.update', $kebutuhan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.kebutuhan.partials._form', [
                            'kebutuhan' => $kebutuhan,
                            'buttonText' => 'Update Kebutuhan'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('admin.kebutuhan.partials._script_image_preview')
@endpush