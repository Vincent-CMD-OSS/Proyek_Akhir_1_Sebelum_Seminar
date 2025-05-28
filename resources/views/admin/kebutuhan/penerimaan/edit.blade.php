{{-- resources/views/admin/kebutuhan/penerimaan/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Catatan Penerimaan Dana')
@section('page-title', 'Edit Catatan Penerimaan Dana')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Catatan Penerimaan untuk: <a href="{{ route('admin.kebutuhan.show', $kebutuhan->id) }}">{{ $kebutuhan->nama_kebutuhan }}</a></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kebutuhan.penerimaan.update', [$kebutuhan->id, $penerimaanDanaKebutuhan->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.kebutuhan.penerimaan.partials._form', [
                            'kebutuhan' => $kebutuhan,
                            'penerimaan' => $penerimaanDanaKebutuhan,
                            'buttonText' => 'Update Catatan Penerimaan'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection