@extends('layouts.admin')

@section('title', 'Identitas Panti Asuhan')

@push('styles')
<style>
    .identitas-panti-form .form-label {
        font-weight: 500;
    }
    .foto-list-item {
        display: flex;
        align-items: flex-start; /* Ubah agar tombol edit sejajar dengan atas info */
        margin-bottom: 1rem;
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }
    .foto-list-item img {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        margin-right: 1rem;
        border-radius: 0.25rem;
    }
    .foto-list-item .info {
        flex-grow: 1;
    }
    .foto-list-item .info .keterangan-display p { /* Target paragraf spesifik */
        margin-bottom: 0.25rem;
        font-size: 0.9em;
        color: #6c757d;
    }
    .foto-list-item .info .keterangan-display strong {
        display: block; /* Agar tombol edit bisa di bawahnya */
        margin-bottom: 0.25rem;
    }
    .foto-list-item .actions form {
        display: inline-block;
    }
    .card-header-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .edit-keterangan-form-container {
        margin-top: 0.5rem;
        padding: 0.75rem;
        border: 1px solid #e0e0e0;
        border-radius: 0.25rem;
        background-color: #f9f9f9;
    }
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

    <!-- Form Identitas Panti (Tetap sama) -->
    <div class="card shadow mb-4">
        {{-- ... Isi form identitas panti Anda ... --}}
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Utama Identitas Panti</h6>
        </div>
        <div class="card-body identitas-panti-form">
            <form action="{{ route('admin.identitas_panti.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_panti" class="form-label">Nama Panti Asuhan</label>
                    <input type="text" class="form-control @error('nama_panti') is-invalid @enderror" id="nama_panti" name="nama_panti" value="{{ old('nama_panti', $identitasPanti->nama_panti) }}">
                    @error('nama_panti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="lokasi_gmaps" class="form-label">Lokasi (Google Maps Embed/Link)</label>
                    <textarea class="form-control @error('lokasi_gmaps') is-invalid @enderror" id="lokasi_gmaps" name="lokasi_gmaps" rows="3" placeholder="Contoh: <iframe src='...'></iframe> atau https://maps.google.com/...">{{ old('lokasi_gmaps', $identitasPanti->lokasi_gmaps) }}</textarea>
                    @error('lokasi_gmaps')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nomor_wa" class="form-label">Nomor WA Pihak Panti</label>
                        <input type="text" class="form-control @error('nomor_wa') is-invalid @enderror" id="nomor_wa" name="nomor_wa" value="{{ old('nomor_wa', $identitasPanti->nomor_wa) }}" placeholder="Contoh: 081234567890">
                        @error('nomor_wa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email_panti" class="form-label">Email Pihak Panti</label>
                        <input type="email" class="form-control @error('email_panti') is-invalid @enderror" id="email_panti" name="email_panti" value="{{ old('email_panti', $identitasPanti->email_panti) }}" placeholder="Contoh: info@panti.com">
                        @error('email_panti')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h6 class="mt-4 mb-3">Sosial Media</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="facebook_url" class="form-label">Facebook URL</label>
                        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $identitasPanti->facebook_url) }}" placeholder="https://facebook.com/namapanti">
                        @error('facebook_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="youtube_url" class="form-label">Youtube URL</label>
                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $identitasPanti->youtube_url) }}" placeholder="https://youtube.com/c/namapanti">
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="instagram_url" class="form-label">Instagram URL</label>
                        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $identitasPanti->instagram_url) }}" placeholder="https://instagram.com/namapanti">
                        @error('instagram_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan Identitas</button>
            </form>
        </div>
    </div>


    <!-- Pengelolaan Foto Panti -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 card-header-action">
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

            <!-- Form Tambah Foto (Tetap sama) -->
            @if ($fotos->count() < 8)
            <div class="mb-4 p-3 border rounded">
                <h5>Tambah Foto Baru</h5>
                <form action="{{ route('admin.identitas_panti.foto.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control @error('foto', 'fotoStore') is-invalid @enderror" id="foto" name="foto" accept="image/*" required>
                        @error('foto', 'fotoStore')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan_foto" class="form-label">Keterangan (Opsional)</label>
                        <input type="text" class="form-control @error('keterangan_foto', 'fotoStore') is-invalid @enderror" id="keterangan_foto" name="keterangan_foto" value="{{ old('keterangan_foto') }}">
                        @error('keterangan_foto', 'fotoStore')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Upload Foto</button>
                </form>
            </div>
            @else
            <div class="alert alert-info">Anda telah mencapai batas maksimal 8 foto. Hapus foto lama untuk menambah yang baru.</div>
            @endif


            <!-- Daftar Foto yang Sudah Diupload -->
            <h5 class="mt-4">Daftar Foto ({{ $fotos->count() }}/8)</h5>
            @if ($fotos->isEmpty())
                <p>Belum ada foto yang diupload.</p>
            @else
                <div class="list-group">
                    @foreach ($fotos as $foto)
                    <div class="foto-list-item" id="foto-item-{{ $foto->id }}">
                        <img src="{{ Storage::url($foto->file_path) }}" alt="{{ $foto->keterangan ?? 'Foto Panti' }}">
                        <div class="info">
                            {{-- Area untuk menampilkan keterangan atau form edit --}}
                            <div class="keterangan-display-{{ $foto->id }}">
                                <strong>{{ $foto->keterangan ?? 'Tanpa keterangan' }}</strong>
                                <p>Diupload pada: {{ $foto->created_at->format('d M Y, H:i') }}</p>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-keterangan" data-foto-id="{{ $foto->id }}">
                                    <i class="fas fa-edit"></i> Edit Keterangan
                                </button>
                            </div>

                            {{-- Form edit keterangan (disembunyikan secara default) --}}
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
                                            <div class="invalid-feedback d-block"> {{-- d-block agar selalu terlihat jika ada error --}}
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    <button type="button" class="btn btn-secondary btn-sm btn-cancel-edit-keterangan" data-foto-id="{{ $foto->id }}">Batal</button>
                                </form>
                            </div>
                        </div>
                        <div class="actions">
                            <form action="{{ route('admin.identitas_panti.foto.destroy', $foto->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
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
document.addEventListener('DOMContentLoaded', function () {
    // ... (fungsi closeAllEditForms dan event listener untuk btn-edit-keterangan, btn-cancel-edit-keterangan tetap sama) ...
    function closeAllEditForms() {
        document.querySelectorAll('.edit-keterangan-form-container').forEach(formContainer => {
            formContainer.style.display = 'none';
        });
        document.querySelectorAll('.keterangan-display').forEach(displayArea => { // Target class umum
            displayArea.style.display = 'block';
        });
    }

    document.querySelectorAll('.btn-edit-keterangan').forEach(button => {
        button.addEventListener('click', function () {
            const fotoId = this.dataset.fotoId;
            closeAllEditForms();
            document.querySelector('.keterangan-display-' + fotoId).style.display = 'none';
            const formContainer = document.querySelector('.edit-keterangan-form-' + fotoId);
            formContainer.style.display = 'block';
            formContainer.querySelector('#nama_gambar_edit_' + fotoId).focus();
        });
    });

    document.querySelectorAll('.btn-cancel-edit-keterangan').forEach(button => {
        button.addEventListener('click', function () {
            const fotoId = this.dataset.fotoId;
            const formContainer = document.querySelector('.edit-keterangan-form-' + fotoId);
            formContainer.style.display = 'none';
            document.querySelector('.keterangan-display-' + fotoId).style.display = 'block';

            formContainer.querySelectorAll('.is-invalid').forEach(invalidInput => {
                invalidInput.classList.remove('is-invalid');
            });
            formContainer.querySelectorAll('.invalid-feedback').forEach(feedback => {
                feedback.style.display = 'none';
            });
        });
    });

    // Baca nilai dari data attribute
    const containerElement = document.querySelector('.container-fluid[data-error-foto-id]'); // Lebih spesifik
    const errorFotoIdFromSession = containerElement ? containerElement.dataset.errorFotoId : null;

    if (errorFotoIdFromSession && errorFotoIdFromSession !== "") { // Periksa juga apakah bukan string kosong
        const displayElement = document.querySelector('.keterangan-display-' + errorFotoIdFromSession);
        const formContainerElement = document.querySelector('.edit-keterangan-form-' + errorFotoIdFromSession);

        if (displayElement && formContainerElement) {
            closeAllEditForms();
            displayElement.style.display = 'none';
            formContainerElement.style.display = 'block';

            const inputNamaGambar = formContainerElement.querySelector('#nama_gambar_edit_' + errorFotoIdFromSession);
            const inputKeterangan = formContainerElement.querySelector('#keterangan_edit_' + errorFotoIdFromSession);

            // Fokus ke input yang relevan
            if (inputNamaGambar && inputNamaGambar.classList.contains('is-invalid')) {
                inputNamaGambar.focus();
            } else if (inputKeterangan && inputKeterangan.classList.contains('is-invalid')) {
                inputKeterangan.focus();
            } else if (inputNamaGambar) {
                inputNamaGambar.focus();
            } else if (inputKeterangan) {
                inputKeterangan.focus();
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