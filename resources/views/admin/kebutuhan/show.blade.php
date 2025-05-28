{{-- resources/views/admin/kebutuhan/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Kebutuhan: ' . $kebutuhan->nama_kebutuhan)
@section('page-title', 'Detail Kebutuhan')

@push('styles')
<style>
    .table-actions form { display: inline-block; margin-left: 5px; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Pesan sukses/error untuk operasi penerimaan dana --}}
    @if (session('success_penerimaan'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success_penerimaan') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
     @if (session('error_penerimaan'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error_penerimaan') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="row">
        {{-- Kolom Detail Kebutuhan Utama --}}
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ $kebutuhan->nama_kebutuhan }}</h5>
                        <a href="{{ route('admin.kebutuhan.edit', $kebutuhan->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit Info Kebutuhan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($kebutuhan->gambar_kebutuhan)
                        <img src="{{ Storage::url($kebutuhan->gambar_kebutuhan) }}" alt="{{ $kebutuhan->nama_kebutuhan }}" class="img-fluid rounded mb-3" style="max-height: 300px; width:100%; object-fit:cover;">
                    @endif
                    <p><strong>Status:</strong>
                        <span class="badge
                            @if($kebutuhan->status_kebutuhan == 'Aktif') bg-primary
                            @elseif($kebutuhan->status_kebutuhan == 'Tercapai') bg-success
                            @elseif($kebutuhan->status_kebutuhan == 'Dibatalkan') bg-danger
                            @else bg-secondary @endif">
                            {{ $kebutuhan->status_kebutuhan }}
                        </span>
                    </p>
                    <p><strong>Deskripsi:</strong></p>
                    <div style="white-space: pre-wrap;">{{ $kebutuhan->deskripsi }}</div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Target Dana:</strong></p>
                            <p class="text-lg">{{ $kebutuhan->target_dana ? 'Rp ' . number_format($kebutuhan->target_dana, 0, ',', '.') : 'Tidak Ditentukan' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Dana Terkumpul:</strong></p>
                            <p class="text-lg text-success">Rp {{ number_format($kebutuhan->dana_terkumpul_aktual, 0, ',', '.') }}</p>
                        </div>
                    </div>
                     @if($kebutuhan->target_dana > 0)
                        <p class="mb-1"><strong>Sisa Dibutuhkan:</strong> Rp {{ number_format($kebutuhan->sisa_dana_dibutuhkan, 0, ',', '.') }}</p>
                        <div class="progress mb-3" style="height: 20px;" title="{{ round($kebutuhan->persentase_tercapai) }}%">
                            @php
                                $persentaseShow = $kebutuhan->persentase_tercapai;
                                $progressClassShow = 'bg-warning'; // Default jika tidak terlalu tinggi
                                if ($persentaseShow >= 100) $progressClassShow = 'bg-success';
                                elseif ($persentaseShow >= 70) $progressClassShow = 'bg-info';
                                // Tidak perlu else bg-danger jika defaultnya sudah bg-warning atau bg-danger. Sesuaikan.
                            @endphp
                            <div class="progress-bar progress-bar-striped progress-bar-animated {{ $progressClassShow }}"
                                 role="progressbar"
                                 style="--progress-width: {{ $persentaseShow }}%; width: var(--progress-width);"
                                 aria-valuenow="{{ $persentaseShow }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                                {{ round($persentaseShow) }}%
                            </div>
                        </div>
                    @endif
                     <hr>
                    <p><strong>Tanggal Mulai Publikasi:</strong> {{ $kebutuhan->tanggal_mulai_dipublikasikan ? $kebutuhan->tanggal_mulai_dipublikasikan->format('d M Y') : '-' }}</p>
                    <p><strong>Tanggal Target Tercapai:</strong> {{ $kebutuhan->tanggal_target_tercapai ? $kebutuhan->tanggal_target_tercapai->format('d M Y') : '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Kolom Catatan Penerimaan Dana --}}
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Riwayat Penerimaan Dana</h5>
                       <a href="{{ route('admin.donasi.create', ['kebutuhan_id' => $kebutuhan->id]) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Tambah Catatan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($kebutuhan->donasiTerkait->isEmpty())
                        <p class="text-center text-muted"><em>Belum ada catatan penerimaan dana untuk kebutuhan ini.</em></p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jumlah (Rp)</th>
                                        <th>Pemberi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                               <tbody>
                                    {{-- GANTI LOOP INI --}}
                                    @foreach($kebutuhan->donasiTerkait()->orderBy('tanggal_donasi', 'desc')->get() as $donasi_item)
                                    <tr>
                                        <td>{{ $donasi_item->tanggal_donasi->format('d M Y') }}</td>
                                        <td class="text-end">{{ number_format($donasi_item->jumlah_donasi, 0, ',', '.') }}</td>
                                        <td>{{ $donasi_item->nama_donatur }}</td>
                                        <td class="table-actions">
                                            {{-- Link Edit sekarang ke DonasiController --}}
                                            <a href="{{ route('admin.donasi.edit', $donasi_item->id) }}?redirect_kebutuhan_id={{ $kebutuhan->id }}" class="btn btn-outline-primary btn-xs" title="Edit">
                                                <i class="fas fa-edit fa-xs"></i>
                                            </a>
                                            {{-- Form Destroy sekarang ke DonasiController --}}
                                            <form action="{{ route('admin.donasi.destroy', $donasi_item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan donasi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="redirect_kebutuhan_id" value="{{ $kebutuhan->id }}"> {{-- Kirim ID Kebutuhan untuk redirect --}}
                                                <button type="submit" class="btn btn-outline-danger btn-xs" title="Hapus">
                                                    <i class="fas fa-trash fa-xs"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                         {{-- Jika ingin paginasi untuk penerimaan, perlu query terpisah di controller show --}}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.kebutuhan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Kebutuhan</a>
    </div>
</div>
@endsection