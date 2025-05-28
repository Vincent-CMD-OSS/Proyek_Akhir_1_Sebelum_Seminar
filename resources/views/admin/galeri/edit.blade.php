{{-- resources/views/admin/galeri/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Galeri: ' . $galeri->judul)
@section('page-title', 'Edit Galeri')

@push('styles')
    {{-- Tambahkan CSS spesifik jika ada --}}
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Galeri: {{ $galeri->judul }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf {{-- CSRF token untuk form utama --}}
                        @method('PUT') {{-- Method spoofing untuk update --}}
                        @include('admin.galeri.partials._form', [
                            'galeri' => $galeri, // Data galeri yang akan diedit
                            'buttonText' => 'Update Galeri'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Tambahkan JS spesifik jika ada --}}
    <script>
        // Script sederhana untuk preview gambar (sama seperti di create)
        const gambarInputEdit = document.getElementById('gambar');
        if (gambarInputEdit) {
            gambarInputEdit.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    // Cari elemen img yang menampilkan gambar lama
                    let previewElement = this.parentElement.querySelector('img.img-thumbnail');

                    // Jika tidak ada img.img-thumbnail di atas input (misal gambar lama dihapus dan user upload baru),
                    // coba cari atau buat yang baru.
                    if (!previewElement) {
                         const oldPreview = document.getElementById('gambar-preview-new');
                         if(oldPreview) oldPreview.remove();

                         previewElement = document.createElement('img');
                         previewElement.id = 'gambar-preview-new';
                         previewElement.classList.add('img-thumbnail', 'mb-2');
                         previewElement.width = 200;
                         this.parentNode.insertBefore(previewElement, this);
                    }


                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                        // Jika ada checkbox remove_gambar, pastikan ter-uncheck karena gambar baru diupload
                        const removeCheckbox = document.getElementById('remove_gambar');
                        if (removeCheckbox) {
                            removeCheckbox.checked = false;
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
@endpush