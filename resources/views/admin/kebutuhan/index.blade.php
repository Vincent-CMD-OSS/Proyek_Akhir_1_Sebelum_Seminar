{{-- resources/views/admin/kebutuhan/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Daftar Kebutuhan Panti')
@section('page-title', 'Kebutuhan Panti')

@push('styles')
    <style>
        .table-actions form { display: inline-block; margin-left: 5px; }
        .img-thumbnail-small { max-width: 80px; max-height: 50px; object-fit: cover; }
        .progress { height: 10px; margin-top: 5px; }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Kebutuhan</h5>
                        <a href="{{ route('admin.kebutuhan.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Kebutuhan</a>
                    </div>
                </div>
                <div class="card-body">
                    @include('partials.admin._messages') {{-- Untuk session success/error --}}

                    <form method="GET" action="{{ route('admin.kebutuhan.index') }}" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-5"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama kebutuhan..." value="{{ request('search') }}"></div>
                            <div class="col-md-3">
                                <select name="status_kebutuhan" class="form-select form-select-sm">
                                    <option value="">Semua Status</option>
                                    <option value="Draft" {{ request('status_kebutuhan') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Aktif" {{ request('status_kebutuhan') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tercapai" {{ request('status_kebutuhan') == 'Tercapai' ? 'selected' : '' }}>Tercapai</option>
                                    <option value="Dibatalkan" {{ request('status_kebutuhan') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md-2"><button type="submit" class="btn btn-info btn-sm w-100">Filter</button></div>
                            <div class="col-md-2"><a href="{{ route('admin.kebutuhan.index') }}" class="btn btn-secondary btn-sm w-100">Reset</a></div>
                        </div>
                    </form>

                    @if($kebutuhanItems->isEmpty())
                        <div class="alert alert-info">Belum ada data kebutuhan.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Gambar</th>
                                        <th>Nama Kebutuhan</th>
                                        <th>Status</th>
                                        <th>Target Dana</th>
                                        <th>Terkumpul (via Catatan)</th>
                                        <th>Progres</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kebutuhanItems as $index => $item)
                                    <tr>
                                        <td>{{ $kebutuhanItems->firstItem() + $index }}</td>
                                        <td>
                                            @if($item->gambar_kebutuhan)
                                                <img src="{{ Storage::url($item->gambar_kebutuhan) }}" alt="{{ $item->nama_kebutuhan }}" class="img-thumbnail-small">
                                            @else - @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.kebutuhan.show', $item->id) }}">{{ $item->nama_kebutuhan }}</a>
                                            <br><small class="text-muted">Slug: {{ $item->slug }}</small>
                                        </td>
                                        <td>
                                            <span class="badge
                                                @if($item->status_kebutuhan == 'Aktif') bg-primary
                                                @elseif($item->status_kebutuhan == 'Tercapai') bg-success
                                                @elseif($item->status_kebutuhan == 'Dibatalkan') bg-danger
                                                @else bg-secondary @endif">
                                                {{ $item->status_kebutuhan }}
                                            </span>
                                        </td>
                                        <td>{{ $item->target_dana ? 'Rp ' . number_format($item->target_dana, 0, ',', '.') : '-' }}</td>
                                        <td>Rp {{ number_format($item->dana_terkumpul_aktual, 0, ',', '.') }}</td>
                                        <td>
                                            @if($item->target_dana > 0)
                                                @php
                                                    $persentase = $item->persentase_tercapai;
                                                    $progressClass = 'bg-danger'; // Default
                                                    if ($persentase >= 100) $progressClass = 'bg-success';
                                                    elseif ($persentase >= 75) $progressClass = 'bg-info';
                                                    elseif ($persentase >= 50) $progressClass = 'bg-warning';
                                                @endphp
                                                <div class="progress" title="{{ round($persentase) }}%">
                                                    {{-- Menggunakan variabel PHP untuk class dan variabel CSS untuk width --}}
                                                    <div class="progress-bar {{ $progressClass }}"
                                                         role="progressbar"
                                                         style="--progress-width: {{ $persentase }}%; width: var(--progress-width);"
                                                         aria-valuenow="{{ $persentase }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100">
                                                        {{-- Teks persentase di dalam bar bisa dihilangkan jika terlalu sempit --}}
                                                        {{-- {{ round($persentase) }}% --}}
                                                    </div>
                                                </div>
                                                <small>{{ round($persentase) }}% tercapai</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="table-actions">
                                            <a href="{{ route('admin.kebutuhan.show', $item->id) }}" class="btn btn-info btn-sm" title="Lihat Detail & Catatan Dana"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.kebutuhan.edit', $item->id) }}" class="btn btn-primary btn-sm" title="Edit Kebutuhan"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.kebutuhan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kebutuhan ini? Semua catatan penerimaan dana terkait juga akan dihapus.');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Kebutuhan"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $kebutuhanItems->appends(request()->query())->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection