{{-- resources/views/admin/kebutuhan/penerimaan/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Catatan Penerimaan Dana untuk ' . $kebutuhan->nama_kebutuhan)
@section('page-title', 'Tambah Catatan Penerimaan Dana')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tambah Catatan Penerimaan untuk: <a href="{{ route('admin.kebutuhan.show', $kebutuhan->id) }}">{{ $kebutuhan->nama_kebutuhan }}</a></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kebutuhan.penerimaan.store', $kebutuhan->id) }}" method="POST">
                        @csrf
                        @include('admin.kebutuhan.penerimaan.partials._form', [
                            'kebutuhan' => $kebutuhan,
                            'penerimaan' => null,
                            'buttonText' => 'Simpan Catatan Penerimaan'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection