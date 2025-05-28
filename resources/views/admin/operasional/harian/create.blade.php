{{-- resources/views/admin/operasional/harian/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Slot Jadwal Harian')
@section('page-title', 'Tambah Jadwal Harian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Slot Jadwal Operasional Harian</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.operasional.harian.store') }}" method="POST">
                        @csrf
                        @include('admin.operasional.harian.partials._form', [
                            'jadwal' => null,
                            'buttonText' => 'Simpan Slot Jadwal'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection