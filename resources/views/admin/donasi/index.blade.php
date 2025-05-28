{{-- resources/views/admin/donasi/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Rekapitulasi Donasi')
@section('page-title', 'Rekap Donasi')

@push('styles')
    <style>
        .table-actions form { display: inline-block; margin-left: 5px; }
        .img-thumbnail-bukti { max-width: 100px; max-height: 70px; object-fit: cover; cursor: pointer; }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Semua Donasi</h5>
                        <a href="{{ route('admin.donasi.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Catat Donasi Baru</a>
                    </div>
                </div>
                <div class="card-body">
                    @include('partials.admin._messages')

                    {{-- Form Filter --}}
                    <form method="GET" action="{{ route('admin.donasi.index') }}" class="mb-4 p-3 border rounded">
                        <h6><i class="fas fa-filter me-1"></i> Filter Donasi</h6>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label for="filter_nama_donatur" class="form-label form-label-sm">Nama Donatur</label>
                                <input type="text" name="nama_donatur" id="filter_nama_donatur" class="form-control form-control-sm" value="{{ request('nama_donatur') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="filter_kebutuhan_id" class="form-label form-label-sm">Untuk Kebutuhan</label>
                                <select name="kebutuhan_id_filter" id="filter_kebutuhan_id" class="form-select form-select-sm">
                                    <option value="">Semua</option>
                                    <option value="umum" {{ request('kebutuhan_id_filter') === 'umum' ? 'selected' : '' }}>Donasi Umum (Tanpa Alokasi)</option>
                                    @foreach($kebutuhanList as $id => $nama)
                                        <option value="{{ $id }}" {{ request('kebutuhan_id_filter') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="filter_status_verifikasi" class="form-label form-label-sm">Status Verifikasi</label>
                                <select name="status_verifikasi" id="filter_status_verifikasi" class="form-select form-select-sm">
                                    <option value="">Semua Status</option>
                                    <option value="Pending" {{ request('status_verifikasi') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Terverifikasi" {{ request('status_verifikasi') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                    <option value="Ditolak" {{ request('status_verifikasi') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                             <div class="col-md-2">
                                <label for="filter_tanggal_awal" class="form-label form-label-sm">Dari Tanggal</label>
                                <input type="date" name="tanggal_awal" id="filter_tanggal_awal" class="form-control form-control-sm" value="{{ request('tanggal_awal') }}">
                            </div>
                             <div class="col-md-2">
                                <label for="filter_tanggal_akhir" class="form-label form-label-sm">Sampai Tanggal</label>
                                <input type="date" name="tanggal_akhir" id="filter_tanggal_akhir" class="form-control form-control-sm" value="{{ request('tanggal_akhir') }}">
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-info btn-sm">Terapkan Filter</button>
                            <a href="{{ route('admin.donasi.index') }}" class="btn btn-secondary btn-sm">Reset Filter</a>
                        </div>
                    </form>


                    @if($donasiItems->isEmpty())
                        <div class="alert alert-info">Belum ada data donasi yang dicatat.</div>
                    @else
                        <p>Total Donasi Ditampilkan: Rp {{ number_format($donasiItems->sum('jumlah_donasi'), 0, ',', '.') }} (dari {{ $donasiItems->total() }} catatan)</p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tgl Donasi</th>
                                        <th>Donatur</th>
                                        <th>Jumlah (Rp)</th>
                                        <th>Untuk Kebutuhan</th>
                                        <th>Status</th>
                                        <th>Bukti</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($donasiItems as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_donasi->format('d M Y') }}</td>
                                        <td>{{ $item->nama_donatur }} <br>
                                            @if($item->nomor_telepon_donatur) <small class="text-muted d-block"><i class="fas fa-phone-alt fa-xs"></i> {{ $item->nomor_telepon_donatur }}</small> @endif
                                            @if($item->email_donatur) <small class="text-muted d-block"><i class="fas fa-envelope fa-xs"></i> {{ $item->email_donatur }}</small> @endif
                                        </td>
                                        <td class="text-end">{{ number_format($item->jumlah_donasi, 0, ',', '.') }}</td>
                                        <td>
                                            @if($item->kebutuhan)
                                                <a href="{{ route('admin.kebutuhan.show', $item->kebutuhan->id) }}">{{ $item->kebutuhan->nama_kebutuhan }}</a>
                                            @else
                                                <span class="text-muted"><em>Umum</em></span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge
                                                @if($item->status_verifikasi == 'Terverifikasi') bg-success
                                                @elseif($item->status_verifikasi == 'Ditolak') bg-danger
                                                @else bg-warning text-dark @endif">
                                                {{ $item->status_verifikasi }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($item->bukti_pembayaran)
                                                <a href="{{ Storage::url($item->bukti_pembayaran) }}" data-bs-toggle="tooltip" title="Lihat Bukti" target="_blank">
                                                    <img src="{{ Storage::url($item->bukti_pembayaran) }}" alt="Bukti" class="img-thumbnail-bukti">
                                                </a>
                                            @else - @endif
                                        </td>
                                        <td class="table-actions">
                                            <!-- <a href="{{ route('admin.donasi.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-eye"></i></a>  -->
                                            <a href="{{ route('admin.donasi.edit', $item->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.donasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan donasi ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $donasiItems->appends(request()->query())->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Inisialisasi Tooltip Bootstrap jika ada
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endpush