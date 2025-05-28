{{-- resources/views/admin/galeri/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Daftar Galeri Digital')
@section('page-title', 'Galeri Digital')

@push('styles')
    <style>
        .table-actions form {
            display: inline-block;
            margin-left: 5px;
        }
        .img-thumbnail-small {
            max-width: 100px;
            max-height: 70px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Item Galeri</h5>
                        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Galeri Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Pesan Sukses/Error --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                     @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Fitur Pencarian dan Filter (Opsional) --}}
                    <form method="GET" action="{{ route('admin.galeri.index') }}" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-5">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari judul, deskripsi, lokasi..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status_publikasi" class="form-select form-select-sm">
                                    <option value="">Semua Status</option>
                                    <option value="draft" {{ request('status_publikasi') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ request('status_publikasi') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info btn-sm w-100">Cari/Filter</button>
                            </div>
                             <div class="col-md-2">
                                <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary btn-sm w-100">Reset</a>
                            </div>
                        </div>
                    </form>

                    @if($galeriItems->isEmpty())
                        <div class="alert alert-info">
                            Belum ada item galeri yang ditambahkan.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Gambar</th>
                                        <th>Judul</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Status</th>
                                        <th>Dibuat Pada</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($galeriItems as $index => $item)
                                    <tr>
                                        <td>{{ $galeriItems->firstItem() + $index }}</td>
                                        <td>
                                            @if($item->gambar)
                                                <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" class="img-thumbnail-small">
                                            @else=
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ $item->tanggal_kegiatan ? $item->tanggal_kegiatan->format('d M Y') : '-' }}</td>
                                        <td>
                                            @if($item->status_publikasi == 'published')
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                        <td class="table-actions">
                                            <a href="{{ route('admin.galeri.edit', $item->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item galeri ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination Links --}}
                        <div class="mt-3">
                            {{ $galeriItems->appends(request()->query())->links() }} {{-- appends() untuk menjaga parameter filter/search saat paginasi --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Tambahkan JS spesifik jika ada --}}
@endpush