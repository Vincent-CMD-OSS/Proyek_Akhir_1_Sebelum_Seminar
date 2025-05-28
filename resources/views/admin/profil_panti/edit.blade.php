{{-- resources/views/admin/profil_panti/edit.blade.php --}}

@extends('layouts.admin') {{-- Menggunakan layout admin utama --}}

@section('title', 'Kelola Profil Panti Asuhan')
@section('page-title', 'Profil Panti') {{-- Untuk breadcrumb dan judul di topbar --}}

@push('styles')
    {{-- Tambahkan CSS spesifik untuk halaman ini jika ada --}}
    <style>
        .image-preview-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .image-preview {
            width: 150px;
            height: 100px;
            border: 1px solid #ddd;
            background-size: cover;
            background-position: center;
            margin-right: 10px;
            border-radius: .25rem;
            /* Menggunakan variabel CSS untuk background-image */
            /* Fallback jika --preview-image-url tidak didefinisikan */
            background-image: var(--preview-image-url, url('https://via.placeholder.com/150x100.png?text=No+Image'));
        }
        .form-check-input[type=checkbox] {
            margin-top: 0.3rem;
            margin-left: 0.5rem;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Utama Panti Asuhan</h5>
                </div>
                <div class="card-body">
                    {{-- Pesan Sukses untuk Update Profil Utama --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.profil.panti.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Slogan --}}
                        <div class="mb-3">
                            <label for="slogan" class="form-label">Slogan</label>
                            <input type="text" class="form-control @error('slogan') is-invalid @enderror" id="slogan" name="slogan" value="{{ old('slogan', $profil->slogan) }}">
                            @error('slogan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tentang Kami Deskripsi --}}
                        <div class="mb-3">
                            <label for="tentang_kami_deskripsi" class="form-label">Tentang Kami (Deskripsi)</label>
                            <textarea class="form-control @error('tentang_kami_deskripsi') is-invalid @enderror" id="tentang_kami_deskripsi" name="tentang_kami_deskripsi" rows="5">{{ old('tentang_kami_deskripsi', $profil->tentang_kami_deskripsi) }}</textarea>
                            @error('tentang_kami_deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tentang Kami Gambar --}}
                        <!-- <div class="mb-3">
                            <label for="tentang_kami_img" class="form-label">Gambar Tentang Kami</label>
                            <div class="image-preview-container">
                                @if ($profil->tentang_kami_img)
                                    <div class="image-preview" style="background-image: url('{{ asset('storage/' . $profil->tentang_kami_img) }}');"></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remove_tentang_kami_img" id="remove_tentang_kami_img">
                                        <label class="form-check-label" for="remove_tentang_kami_img">
                                            Hapus gambar saat ini
                                        </label>
                                    </div>
                                @else
                                    <div class="image-preview" style="background-image: url('https://via.placeholder.com/150x100.png?text=No+Image');"></div>
                                @endif
                            </div>
                            <input type="file" class="form-control @error('tentang_kami_img') is-invalid @enderror" id="tentang_kami_img" name="tentang_kami_img" onchange="previewImage(this, 'tentang_kami_img')">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB.</small>
                            @error('tentang_kami_img')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> -->

                        {{-- Tentang Kami Gambar --}}
                        <div class="mb-3">
                            <label for="tentang_kami_img" class="form-label">Gambar Tentang Kami</label>
                            <div class="image-preview-container">
                                @if ($profil->tentang_kami_img)
                                    <div class="image-preview" style="--preview-image-url: url('{{ asset('storage/' . $profil->tentang_kami_img) }}');"></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remove_tentang_kami_img" id="remove_tentang_kami_img">
                                        <label class="form-check-label" for="remove_tentang_kami_img">
                                            Hapus gambar saat ini
                                        </label>
                                    </div>
                                @else
                                    {{-- Jika tidak ada gambar, biarkan kosong agar fallback dari CSS utama yang digunakan --}}
                                    <div class="image-preview"></div>
                                @endif
                            </div>
                            <input type="file" class="form-control @error('tentang_kami_img') is-invalid @enderror" id="tentang_kami_img" name="tentang_kami_img" onchange="previewImage(this, 'tentang_kami_img')">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB.</small>
                            @error('tentang_kami_img')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Sejarah Singkat Deskripsi --}}
                        <div class="mb-3">
                            <label for="sejarah_singkat_deskripsi" class="form-label">Sejarah Singkat (Deskripsi)</label>
                            <textarea class="form-control @error('sejarah_singkat_deskripsi') is-invalid @enderror" id="sejarah_singkat_deskripsi" name="sejarah_singkat_deskripsi" rows="5">{{ old('sejarah_singkat_deskripsi', $profil->sejarah_singkat_deskripsi) }}</textarea>
                            @error('sejarah_singkat_deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Sejarah Singkat Gambar --}}
                        <div class="mb-3">
                            <label for="sejarah_singkat_img" class="form-label">Gambar Sejarah Singkat</label>
                            <div class="image-preview-container">
                                @if ($profil->sejarah_singkat_img)
                                    <div class="image-preview" style="--preview-image-url: url('{{ asset('storage/' . $profil->sejarah_singkat_img) }}');"></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remove_sejarah_singkat_img" id="remove_sejarah_singkat_img">
                                        <label class="form-check-label" for="remove_sejarah_singkat_img">
                                            Hapus gambar saat ini
                                        </label>
                                    </div>
                                @else
                                    <div class="image-preview"></div> {{-- Menggunakan fallback dari CSS --}}
                                @endif
                            </div>
                            <input type="file" class="form-control @error('sejarah_singkat_img') is-invalid @enderror" id="sejarah_singkat_img" name="sejarah_singkat_img" onchange="previewImage(this, 'sejarah_singkat_img')">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB.</small>
                            @error('sejarah_singkat_img')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Visi Deskripsi --}}
                        <div class="mb-3">
                            <label for="visi_deskripsi" class="form-label">Visi (Deskripsi)</label>
                            <textarea class="form-control @error('visi_deskripsi') is-invalid @enderror" id="visi_deskripsi" name="visi_deskripsi" rows="3">{{ old('visi_deskripsi', $profil->visi_deskripsi) }}</textarea>
                            @error('visi_deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Misi Deskripsi --}}
                        <div class="mb-3">
                            <label for="misi_deskripsi" class="form-label">Misi (Deskripsi)</label>
                            <textarea class="form-control @error('misi_deskripsi') is-invalid @enderror" id="misi_deskripsi" name="misi_deskripsi" rows="5">{{ old('misi_deskripsi', $profil->misi_deskripsi) }}</textarea>
                            @error('misi_deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Visi Misi Gambar --}}
                        <div class="mb-3">
                            <label for="visi_misi_img" class="form-label">Gambar Visi & Misi</label>
                            <div class="image-preview-container">
                                @if ($profil->visi_misi_img)
                                    <div class="image-preview" style="--preview-image-url: url('{{ asset('storage/' . $profil->visi_misi_img) }}');"></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remove_visi_misi_img" id="remove_visi_misi_img">
                                        <label class="form-check-label" for="remove_visi_misi_img">
                                            Hapus gambar saat ini
                                        </label>
                                    </div>
                                @else
                                    <div class="image-preview"></div> {{-- Menggunakan fallback dari CSS --}}
                                @endif
                            </div>
                            <input type="file" class="form-control @error('visi_misi_img') is-invalid @enderror" id="visi_misi_img" name="visi_misi_img" onchange="previewImage(this, 'visi_misi_img')">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB.</small>
                            @error('visi_misi_img')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gambar Struktur Organisasi Utama --}}
                        <div class="mb-3">
                            <label for="struktur_organisasi_img_utama" class="form-label">Gambar Bagan Struktur Organisasi (Utama)</label>
                            <div class="image-preview-container">
                                @if ($profil->struktur_organisasi_img_utama)
                                    <div class="image-preview" style="--preview-image-url: url('{{ asset('storage/' . $profil->struktur_organisasi_img_utama) }}');"></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remove_struktur_organisasi_img_utama" id="remove_struktur_organisasi_img_utama">
                                        <label class="form-check-label" for="remove_struktur_organisasi_img_utama">
                                            Hapus gambar saat ini
                                        </label>
                                    </div>
                                @else
                                    <div class="image-preview"></div> {{-- Menggunakan fallback dari CSS --}}
                                @endif
                            </div>
                            <input type="file" class="form-control @error('struktur_organisasi_img_utama') is-invalid @enderror" id="struktur_organisasi_img_utama" name="struktur_organisasi_img_utama" onchange="previewImage(this, 'struktur_organisasi_img_utama')">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB.</small>
                            @error('struktur_organisasi_img_utama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gambar Tim Pendiri Utama --}}
                        <div class="mb-3">
                            <label for="tim_pendiri_img_utama" class="form-label">Gambar Grup Tim Pendiri (Utama)</label>
                            <div class="image-preview-container">
                                @if ($profil->tim_pendiri_img_utama)
                                    <div class="image-preview" style="--preview-image-url: url('{{ asset('storage/' . $profil->tim_pendiri_img_utama) }}');"></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remove_tim_pendiri_img_utama" id="remove_tim_pendiri_img_utama">
                                        <label class="form-check-label" for="remove_tim_pendiri_img_utama">
                                            Hapus gambar saat ini
                                        </label>
                                    </div>
                                @else
                                    <div class="image-preview"></div> {{-- Menggunakan fallback dari CSS --}}
                                @endif
                            </div>
                            <input type="file" class="form-control @error('tim_pendiri_img_utama') is-invalid @enderror" id="tim_pendiri_img_utama" name="tim_pendiri_img_utama" onchange="previewImage(this, 'tim_pendiri_img_utama')">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB.</small>
                            @error('tim_pendiri_img_utama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Lokasi Deskripsi --}}
                        <div class="mb-3">
                            <label for="lokasi_deskripsi" class="form-label">Lokasi (Deskripsi)</label>
                            <textarea class="form-control @error('lokasi_deskripsi') is-invalid @enderror" id="lokasi_deskripsi" name="lokasi_deskripsi" rows="3">{{ old('lokasi_deskripsi', $profil->lokasi_deskripsi) }}</textarea>
                            @error('lokasi_deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Lokasi Gambar --}}
                        <div class="mb-3">
                            <label for="lokasi_img" class="form-label">Gambar Peta Lokasi</label>
                            <div class="image-preview-container">
                                @if ($profil->lokasi_img)
                                    <div class="image-preview" style="--preview-image-url: url('{{ asset('storage/' . $profil->lokasi_img) }}');"></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remove_lokasi_img" id="remove_lokasi_img">
                                        <label class="form-check-label" for="remove_lokasi_img">
                                            Hapus gambar saat ini
                                        </label>
                                    </div>
                                @else
                                    <div class="image-preview"></div> {{-- Menggunakan fallback dari CSS --}}
                                @endif
                            </div>
                            <input type="file" class="form-control @error('lokasi_img') is-invalid @enderror" id="lokasi_img" name="lokasi_img" onchange="previewImage(this, 'lokasi_img')">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB.</small>
                            @error('lokasi_img')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Struktur Organisasi Anggota --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Kelola Anggota Struktur Organisasi</h5>
            </div>
            <div class="card-body">
                @if (session('success_struktur'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success_struktur') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- Pesan error umum untuk operasi struktur --}}
                @php $strukturErrorBags = collect($errors->getBags())->filter(fn($bag, $key) => str_starts_with($key, 'struktur_')); @endphp
                @if ($strukturErrorBags->isNotEmpty())
                    <div class="alert alert-danger" role="alert">
                        Terdapat kesalahan pada input data anggota struktur. Silakan periksa kembali form tambah/edit yang relevan.
                        {{-- Anda bisa loop $strukturErrorBags jika ingin menampilkan pesan lebih detail di sini --}}
                    </div>
                @endif

                @include('admin.profil_panti.partials._struktur_anggota_section', [
                    'profil' => $profil,
                    'strukturAnggotaList' => $strukturAnggota,
                    'editStrukturAnggota' => $editStrukturAnggota ?? null
                ])
            </div>
        </div>
    </div>
</div>  


    {{-- Bagian Tim Pendiri Anggota --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Kelola Anggota Tim Pendiri</h5>
            </div>
            <div class="card-body">
                 @if (session('success_pendiri'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success_pendiri') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- Pesan error umum untuk operasi pendiri --}}
                @php $pendiriErrorBags = collect($errors->getBags())->filter(fn($bag, $key) => str_starts_with($key, 'pendiri_')); @endphp
                @if ($pendiriErrorBags->isNotEmpty())
                    <div class="alert alert-danger" role="alert">
                        Terdapat kesalahan pada input data anggota tim pendiri. Silakan periksa kembali form tambah/edit yang relevan.
                    </div>
                @endif

                @include('admin.profil_panti.partials._tim_pendiri_anggota_section', [
                    'profil' => $profil,
                    'timPendiriList' => $timPendiri,
                    'editTimPendiri' => $editTimPendiri ?? null
                ])
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    {{-- Tambahkan JS spesifik untuk halaman ini jika ada --}}
    {{-- Script untuk preview gambar sederhana --}}
    <script>
        function previewImage(input, fieldName) {
            const file = input.files[0];
            const previewContainer = input.previousElementSibling; // Ambil div image-preview-container
            const previewElement = previewContainer.querySelector('.image-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewElement.style.backgroundImage = `url('${e.target.result}')`;
                }
                reader.readAsDataURL(file);
            } else {
                // Kembalikan ke placeholder jika tidak ada file atau file di-clear
                // Cek apakah ada gambar lama
                const currentImageCheckbox = document.getElementById(`remove_${fieldName}`);
                let originalImageUrl = `https://via.placeholder.com/150x100.png?text=No+Image`; // Default placeholder

                previewElement.style.removeProperty('--preview-image-url');

                // Jika ada checkbox 'remove' dan tidak di-check, dan ada gambar asli, gunakan gambar asli
                // Ini sedikit rumit karena kita tidak menyimpan path gambar asli di JS
                // Untuk kesederhanaan, kita reset ke placeholder umum atau biarkan gambar server-side
                // Cara paling mudah adalah biarkan saja, karena kalau di-clear, saat submit tanpa file baru, gambar lama tidak akan terhapus (kecuali checkbox 'remove' di-tick)
                // Jadi, fungsi preview ini hanya untuk file yang BARU dipilih.
            }
        }

        

        // Pastikan Bootstrap JS sudah dimuat jika ingin menggunakan fitur dismiss alert
        // Jika menggunakan Bootstrap Bundle dari CDN di layout, ini sudah termasuk.
        // Jika tidak, pastikan 'bootstrap.js' atau 'bootstrap.bundle.js' dimuat.
        // Contoh:
        // var alertList = document.querySelectorAll('.alert')
        // alertList.forEach(function (alert) {
        //   new bootstrap.Alert(alert)
        // })
    </script>
@endpush