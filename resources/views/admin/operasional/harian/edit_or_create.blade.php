{{-- resources/views/admin/operasional/harian/edit_or_create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Atur Jadwal Harian - ' . $namaHariProper)
@section('page-title', 'Atur Jadwal Harian: ' . $namaHariProper)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-xl-6"> {{-- Kolom diperkecil --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Jadwal Kunjungan untuk Hari: <strong>{{ $namaHariProper }}</strong></h5>
                    <small class="text-muted">Kosongkan jam buka dan jam tutup jika panti tutup untuk kunjungan pada hari ini.</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.operasional.harian.store_or_update', ['hari' => strtolower($namaHariProper)]) }}" method="POST">
                        @csrf
                        {{-- Tidak perlu @method('PUT') karena kita menggunakan POST untuk create/update --}}

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jam_buka" class="form-label">Jam Buka Kunjungan</label>
                                <input type="time" class="form-control @error('jam_buka') is-invalid @enderror"
                                       id="jam_buka" name="jam_buka"
                                       value="{{ old('jam_buka', $jadwal->jam_buka ? \Carbon\Carbon::parse($jadwal->jam_buka)->format('H:i') : '') }}">
                                @error('jam_buka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jam_tutup" class="form-label">Jam Tutup Kunjungan</label>
                                <input type="time" class="form-control @error('jam_tutup') is-invalid @enderror"
                                       id="jam_tutup" name="jam_tutup"
                                       value="{{ old('jam_tutup', $jadwal->jam_tutup ? \Carbon\Carbon::parse($jadwal->jam_tutup)->format('H:i') : '') }}">
                                @error('jam_tutup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mt-2" role="alert">
                            Jika jam buka dan jam tutup dikosongkan, maka pada hari <strong>{{ $namaHariProper }}</strong> panti dianggap <strong>TUTUP</strong> untuk kunjungan.
                            Jika diisi, maka panti <strong>BUKA</strong> untuk kunjungan pada rentang jam tersebut.
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Jadwal {{ $namaHariProper }}</button>
                            <a href="{{ route('admin.operasional.index') }}#harian-tab-pane" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection