{{-- resources/views/admin/operasional/harian/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Slot Jadwal Harian')
@section('page-title', 'Edit Jadwal Harian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Slot Jadwal Operasional Harian</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.operasional.harian.update', $jadwalOperasionalHarian->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.operasional.harian.partials._form', [
                            'jadwal' => $jadwalOperasionalHarian,
                            'buttonText' => 'Update Slot Jadwal'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection