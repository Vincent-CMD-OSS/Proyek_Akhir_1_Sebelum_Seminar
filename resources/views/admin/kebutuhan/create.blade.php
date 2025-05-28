{{-- resources/views/admin/kebutuhan/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Kebutuhan Baru')
@section('page-title', 'Tambah Kebutuhan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Form Tambah Kebutuhan</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.kebutuhan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.kebutuhan.partials._form', [
                            'kebutuhan' => null,
                            'buttonText' => 'Simpan Kebutuhan'
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