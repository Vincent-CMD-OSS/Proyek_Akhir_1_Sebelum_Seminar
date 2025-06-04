@extends('layouts.admin')

@section('title', 'Identitas Panti Asuhan')

@push('styles')
<style>
    /* ... (CSS BARU DARI ATAS DILETAKKAN DI SINI) ... */
    :root {
        --admin-card-border-radius: 0.5rem;
        --admin-input-border-radius: 0.375rem;
        --admin-btn-border-radius: 0.375rem;
        --admin-spacing-unit: 1rem;
        --admin-text-muted: #858796;
        --admin-border-color: #e3e6f0;
    }
    .card-body .form-label { font-weight: 500; color: #5a5c69; margin-bottom: 0.5rem; }
    .card-body .form-control, .card-body .form-select { border-radius: var(--admin-input-border-radius); font-size: 0.9rem; }
    .card-body .btn { border-radius: var(--admin-btn-border-radius); font-size: 0.9rem; }
    .card-body .invalid-feedback { font-size: 0.8rem; }
    .card .card-header { padding: 0.75rem 1.25rem; }
    .card { border-radius: var(--admin-card-border-radius); }

    .identitas-panti-form .mb-3,
    .identitas-panti-form .row > .col-md-6.mb-3,
    .identitas-panti-form .row > .col-md-4.mb-3 {
        margin-bottom: calc(var(--admin-spacing-unit) * 1.25) !important;
    }
    .identitas-panti-form h6.mt-4 {
        margin-top: calc(var(--admin-spacing-unit) * 1.75) !important; font-size: 0.95rem;
        color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em;
    }

    .form-tambah-foto-wrapper {
        padding: var(--admin-spacing-unit); border: 1px solid var(--admin-border-color);
        border-radius: var(--admin-card-border-radius); background-color: #f8f9fc;
        margin-bottom: calc(var(--admin-spacing-unit) * 1.5);
    }
    .form-tambah-foto-wrapper h5 { font-size: 1.1rem; margin-bottom: var(--admin-spacing-unit); color: #5a5c69; }

    .foto-list-item {
        display: flex; align-items: flex-start; padding: var(--admin-spacing-unit);
        border: 1px solid var(--admin-border-color); border-radius: var(--admin-card-border-radius);
        margin-bottom: var(--admin-spacing-unit); background-color: #fff;
    }
    .foto-list-item:last-child { margin-bottom: 0; }

    .foto-thumbnail-wrapper {
        width: 120px; height: 90px; margin-right: var(--admin-spacing-unit);
        flex-shrink: 0; overflow: hidden; border-radius: var(--admin-input-border-radius);
        background-color: #e9ecef;
    }
    .foto-thumbnail-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .foto-info-details { flex-grow: 1; }
    .keterangan-display strong {
        display: block; font-weight: 500; color: #36b9cc; /* SB Admin Info Color */
        margin-bottom: 0.25rem; font-size: 0.95rem;
    }
    .keterangan-display p.upload-date { font-size: 0.8rem; color: var(--admin-text-muted); margin-bottom: 0.5rem; }
    .keterangan-display .btn-edit-keterangan { font-size: 0.75rem; padding: 0.25rem 0.5rem; }

    .edit-keterangan-form-container {
        margin-top: 0.75rem; padding: var(--admin-spacing-unit);
        border: 1px solid #d1d3e2; border-radius: var(--admin-input-border-radius);
        background-color: #f5f5f9;
    }
    .edit-keterangan-form-container .form-control-sm { font-size: 0.85rem; }
    .edit-keterangan-form-container .btn-sm { font-size: 0.8rem; padding: 0.25rem 0.6rem; }
    .edit-keterangan-form-container .invalid-feedback { font-size: 0.75rem; }

    .foto-actions { margin-left: var(--admin-spacing-unit); flex-shrink: 0; }
    .foto-actions .btn-danger.btn-sm { font-size: 0.8rem; padding: 0.35rem 0.7rem; }

    .list-group { border: none; padding: 0; } /* Hapus style default Bootstrap jika tidak diperlukan */
    .list-group .foto-list-item { border-radius: var(--admin-card-border-radius); }

</style>
@endpush

@section('content')
<div class="container-fluid" data-error-foto-id="{{ session('edit_keterangan_foto_id_error') }}">
    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>

    {{-- Notifikasi Global --}}
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

    <!-- Form Identitas Panti -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Utama Identitas Panti</h6>
        </div>
        <div class="card-body identitas-panti-form">
            <form action="{{ route('admin.identitas_panti.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_panti" class="form-label">Nama Panti Asuhan</label>
                    <input type="text" class="form-control @error('nama_panti') is-invalid @enderror" id="nama_panti" name="nama_panti" value="{{ old('nama_panti', $identitasPanti->nama_panti ?? '') }}">
                    @error('nama_panti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="lokasi_gmaps" class="form-label">Lokasi (Google Maps Embed/Link)</label>
                    <textarea class="form-control @error('lokasi_gmaps') is-invalid @enderror" id="lokasi_gmaps" name="lokasi_gmaps" rows="3" placeholder="Contoh: <iframe src='...'></iframe> atau https://maps.google.com/...">{{ old('lokasi_gmaps', $identitasPanti->lokasi_gmaps ?? '') }}</textarea>
                    @error('lokasi_gmaps')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nomor_wa" class="form-label">Nomor WA Pihak Panti</label>
                        <input type="text" class="form-control @error('nomor_wa') is-invalid @enderror" id="nomor_wa" name="nomor_wa" value="{{ old('nomor_wa', $identitasPanti->nomor_wa ?? '') }}" placeholder="Contoh: 081234567890">
                        @error('nomor_wa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email_panti" class="form-label">Email Pihak Panti</label>
                        <input type="email" class="form-control @error('email_panti') is-invalid @enderror" id="email_panti" name="email_panti" value="{{ old('email_panti', $identitasPanti->email_panti ?? '') }}" placeholder="Contoh: info@panti.com">
                        @error('email_panti')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h6 class="mt-4 mb-3">Sosial Media</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="facebook_url" class="form-label">Facebook URL</label>
                        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $identitasPanti->facebook_url ?? '') }}" placeholder="https://facebook.com/namapanti">
                        @error('facebook_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="youtube_url" class="form-label">Youtube URL</label>
                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $identitasPanti->youtube_url ?? '') }}" placeholder="https://youtube.com/c/namapanti">
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="instagram_url" class="form-label">Instagram URL</label>
                        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $identitasPanti->instagram_url ?? '') }}" placeholder="https://instagram.com/namapanti">
                        @error('instagram_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-2"><i class="fas fa-save me-1"></i> Simpan Perubahan Identitas</button>
            </form>
        </div>
    </div>


    <!-- Pengelolaan Foto Panti -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Foto Panti Asuhan (Maksimal 8 Foto)</h6>
        </div>
        <div class="card-body">
            @if (session('success_foto'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success_foto') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error_foto'))
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error_foto') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Form Tambah Foto -->
            @if ($fotos->count() < 8)
            <div class="form-tambah-foto-wrapper">
                <h5><i class="fas fa-plus-circle me-2 text-success"></i>Tambah Foto Baru</h5>
                <form action="{{ route('admin.identitas_panti.foto.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('foto', 'fotoStore') is-invalid @enderror" id="foto" name="foto" accept="image/*" required>
                        @error('foto', 'fotoStore')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan_foto_store" class="form-label">Keterangan (Opsional)</label> {{-- ID unik untuk store --}}
                        <input type="text" class="form-control @error('keterangan_foto', 'fotoStore') is-invalid @enderror" id="keterangan_foto_store" name="keterangan_foto" value="{{ old('keterangan_foto') }}" placeholder="Misal: Tampak depan panti">
                        @error('keterangan_foto', 'fotoStore')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload me-1"></i> Upload Foto</button>
                </form>
            </div>
            @else
            <div class="alert alert-info">Anda telah mencapai batas maksimal 8 foto. Hapus foto lama untuk menambah yang baru.</div>
            @endif


            <!-- Daftar Foto yang Sudah Diupload -->
            <h5 class="mt-4 mb-3"><i class="fas fa-images me-2 text-info"></i>Daftar Foto ({{ $fotos->count() }}/8)</h5>
            @if ($fotos->isEmpty())
                <p class="text-muted">Belum ada foto yang diupload.</p>
            @else
                <div class="list-group"> {{-- List group bisa dihilangkan jika tidak menambah style signifikan --}}
                    @foreach ($fotos as $foto)
                    <div class="foto-list-item" id="foto-item-{{ $foto->id }}">
                        <div class="foto-thumbnail-wrapper">
                            <img src="{{ Storage::url($foto->file_path) }}" alt="{{ $foto->keterangan ?? 'Foto Panti' }}">
                        </div>
                        <div class="foto-info-details">
                            <div class="keterangan-display keterangan-display-{{ $foto->id }}">
                                <strong>{{ $foto->keterangan ?? 'Tanpa keterangan' }}</strong>
                                <p class="upload-date"><small>Diupload: {{ $foto->created_at->format('d M Y, H:i') }}</small></p>
                                <button type="button" class="btn btn-sm btn-outline-info btn-edit-keterangan" data-foto-id="{{ $foto->id }}">
                                    <i class="fas fa-pencil-alt"></i> Edit Keterangan
                                </button>
                            </div>

                            <div class="edit-keterangan-form-container edit-keterangan-form-{{ $foto->id }}" style="display: none;">
                                <form action="{{ route('admin.identitas_panti.foto.keterangan.update', $foto->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label for="keterangan_edit_{{ $foto->id }}" class="form-label visually-hidden">Keterangan</label>
                                        <input type="text" class="form-control form-control-sm @error('keterangan_edit_' . $foto->id, 'fotoUpdate_' . $foto->id) is-invalid @enderror"
                                               id="keterangan_edit_{{ $foto->id }}" name="keterangan_edit_{{ $foto->id }}"
                                               value="{{ old('keterangan_edit_' . $foto->id, $foto->keterangan) }}" placeholder="Masukkan keterangan foto">
                                        @error('keterangan_edit_' . $foto->id, 'fotoUpdate_' . $foto->id)
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save me-1"></i>Simpan</button>
                                    <button type="button" class="btn btn-secondary btn-sm btn-cancel-edit-keterangan" data-foto-id="{{ $foto->id }}"><i class="fas fa-times me-1"></i>Batal</button>
                                </form>
                            </div>
                        </div>
                        <div class="foto-actions">
                            <form action="{{ route('admin.identitas_panti.foto.destroy', $foto->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// ... (JavaScript Anda sebelumnya sudah cukup baik, hanya pastikan selektornya sesuai) ...
document.addEventListener('DOMContentLoaded', function () {
    function closeAllEditForms() {
        document.querySelectorAll('.edit-keterangan-form-container').forEach(formContainer => {
            formContainer.style.display = 'none';
        });
        document.querySelectorAll('.keterangan-display').forEach(displayArea => {
            displayArea.style.display = 'block';
        });
    }

    document.querySelectorAll('.btn-edit-keterangan').forEach(button => {
        button.addEventListener('click', function () {
            const fotoId = this.dataset.fotoId;
            closeAllEditForms(); // Tutup semua form edit lain dulu
            document.querySelector('.keterangan-display-' + fotoId).style.display = 'none';
            const formContainer = document.querySelector('.edit-keterangan-form-' + fotoId);
            formContainer.style.display = 'block';
            // Fokus ke input pertama di form edit
            const inputField = formContainer.querySelector('input[type="text"], textarea');
            if (inputField) {
                inputField.focus();
            }
        });
    });

    document.querySelectorAll('.btn-cancel-edit-keterangan').forEach(button => {
        button.addEventListener('click', function () {
            const fotoId = this.dataset.fotoId;
            const formContainer = document.querySelector('.edit-keterangan-form-' + fotoId);
            formContainer.style.display = 'none';
            document.querySelector('.keterangan-display-' + fotoId).style.display = 'block';

            // Hapus kelas is-invalid dan sembunyikan pesan error
            formContainer.querySelectorAll('.is-invalid').forEach(invalidInput => {
                invalidInput.classList.remove('is-invalid');
            });
            formContainer.querySelectorAll('.invalid-feedback').forEach(feedback => {
                feedback.style.display = 'none'; // Atau .textContent = '' jika Anda mengisi pesan error via JS
            });
        });
    });

    const containerElement = document.querySelector('.container-fluid[data-error-foto-id]');
    const errorFotoIdFromSession = containerElement ? containerElement.dataset.errorFotoId : null;

    if (errorFotoIdFromSession && errorFotoIdFromSession !== "") {
        const displayElement = document.querySelector('.keterangan-display-' + errorFotoIdFromSession);
        const formContainerElement = document.querySelector('.edit-keterangan-form-' + errorFotoIdFromSession);

        if (displayElement && formContainerElement) {
            closeAllEditForms();
            displayElement.style.display = 'none';
            formContainerElement.style.display = 'block';

            // Fokus ke input yang error (atau input pertama jika tidak ada error spesifik)
            const errorInput = formContainerElement.querySelector('.is-invalid');
            if (errorInput) {
                errorInput.focus();
            } else {
                const firstInput = formContainerElement.querySelector('input[type="text"], textarea');
                if (firstInput) {
                    firstInput.focus();
                }
            }
        }
    }
});
</script>

@php
    if (session()->has('edit_keterangan_foto_id_error')) {
        session()->forget('edit_keterangan_foto_id_error');
    }
@endphp

@endpush