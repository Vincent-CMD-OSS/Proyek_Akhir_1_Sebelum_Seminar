{{-- resources/views/admin/galeri/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Galeri Baru')
@section('page-title', 'Tambah Galeri')

@push('styles')
    {{-- Tambahkan CSS spesifik jika ada, misalnya untuk editor WYSIWYG jika digunakan untuk deskripsi --}}
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Galeri Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf {{-- CSRF token untuk form utama --}}
                        @include('admin.galeri.partials._form', [
                            'galeri' => null, // Tidak ada data galeri untuk form create
                            'buttonText' => 'Simpan Galeri Baru'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- @push('scripts')
    {{-- Tambahkan JS spesifik jika ada, misalnya untuk preview gambar atau inisialisasi editor --}}
    <script>
        // Script sederhana untuk preview gambar jika diperlukan
        // (Mirip dengan yang ada di profil panti, bisa disesuaikan)
        const gambarInput = document.getElementById('gambar');
        if (gambarInput) {
            gambarInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    const existingImage = document.querySelector('img[src^="{{ Storage::url('') }}"]'); // Cari gambar lama (jika ada di form edit)
                    let previewElement;

                    if (existingImage && existingImage.parentElement.querySelector('img.img-thumbnail')) {
                        previewElement = existingImage.parentElement.querySelector('img.img-thumbnail');
                    } else {
                        // Buat elemen img baru jika tidak ada (untuk form create atau jika gambar lama tidak ada)
                        const oldPreview = document.getElementById('gambar-preview-new');
                        if(oldPreview) oldPreview.remove(); // Hapus preview lama jika ada

                        previewElement = document.createElement('img');
                        previewElement.id = 'gambar-preview-new';
                        previewElement.classList.add('img-thumbnail', 'mb-2');
                        previewElement.width = 200;
                        // Sisipkan sebelum input file
                        this.parentNode.insertBefore(previewElement, this);
                    }

                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
@endpush -->

@push('scripts')
    <script>
        const gambarInputCreate = document.getElementById('gambar'); // Beri nama variabel unik jika ada di edit juga
        if (gambarInputCreate) {
            gambarInputCreate.addEventListener('change', function(event) {
                const file = event.target.files[0];
                let previewElement = document.getElementById('gambar-preview-new'); // Cari preview yang mungkin sudah dibuat

                if (file) {
                    const reader = new FileReader();

                    if (!previewElement) { // Jika preview belum ada, buat baru
                        previewElement = document.createElement('img');
                        previewElement.id = 'gambar-preview-new';
                        previewElement.classList.add('img-thumbnail', 'mb-2');
                        previewElement.width = 200;
                        // Sisipkan sebelum input file
                        this.parentNode.insertBefore(previewElement, this);
                    }

                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                        previewElement.style.display = 'block'; // Pastikan terlihat
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Jika file di-clear dari input, sembunyikan atau hapus preview
                    if (previewElement) {
                        previewElement.style.display = 'none'; // Atau previewElement.remove();
                        // previewElement.src = ''; // Kosongkan src
                    }
                }
            });
        }
    </script>
@endpush