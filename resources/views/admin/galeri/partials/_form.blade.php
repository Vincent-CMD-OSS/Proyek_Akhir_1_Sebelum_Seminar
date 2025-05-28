{{-- resources/views/admin/galeri/partials/_form.blade.php --}}
{{--
    Variables expected:
    $galeri (optional, instance of Galeri model for editing, null for creating)
    $buttonText (string, text for the submit button, e.g., 'Simpan Galeri' or 'Update Galeri')
--}}

@csrf {{-- CSRF token akan di-include oleh form utama --}}

<div class="row">
    <div class="col-md-8">
        {{-- Judul Galeri --}}
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Galeri <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $galeri->judul ?? '') }}" required>
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Deskripsi Galeri --}}
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $galeri->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Slug (Opsional, bisa disembunyikan jika auto-generate selalu diinginkan) --}}
        <div class="mb-3">
            <label for="slug" class="form-label">Slug (URL)</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $galeri->slug ?? '') }}" placeholder="Akan di-generate otomatis jika kosong">
            <small class="form-text text-muted">Gunakan huruf kecil, angka, dan tanda hubung (-). Kosongkan untuk auto-generate.</small>
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        {{-- Tanggal Kegiatan --}}
        <div class="mb-3">
            <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan/Upload</label>
            <input type="date" class="form-control @error('tanggal_kegiatan') is-invalid @enderror" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', isset($galeri) && $galeri->tanggal_kegiatan ? $galeri->tanggal_kegiatan->format('Y-m-d') : '') }}">
            @error('tanggal_kegiatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Lokasi --}}
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $galeri->lokasi ?? '') }}">
            @error('lokasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status Publikasi --}}
        <div class="mb-3">
            <label for="status_publikasi" class="form-label">Status Publikasi <span class="text-danger">*</span></label>
            <select class="form-select @error('status_publikasi') is-invalid @enderror" id="status_publikasi" name="status_publikasi" required>
                <option value="draft" {{ old('status_publikasi', $galeri->status_publikasi ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status_publikasi', $galeri->status_publikasi ?? '') == 'published' ? 'selected' : '' }}>Published</option>
            </select>
            @error('status_publikasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Gambar Galeri --}}
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Galeri @if(!isset($galeri) || !$galeri->gambar) <span class="text-danger">*</span> @endif</label>
            @if (isset($galeri) && $galeri->gambar)
                <div class="mb-2">
                    <img src="{{ Storage::url($galeri->gambar) }}" alt="{{ $galeri->judul }}" class="img-thumbnail" width="200">
                    <div class="form-check mt-1">
                        <input class="form-check-input" type="checkbox" name="remove_gambar" id="remove_gambar" value="1">
                        <label class="form-check-label" for="remove_gambar">
                            Hapus gambar saat ini (jika mengupload yang baru)
                        </label>
                    </div>
                </div>
                <small class="form-text text-muted d-block mb-1">Upload file baru untuk mengganti gambar di atas.</small>
            @endif
            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/jpeg,image/png,image/webp,image/gif">
            <small class="form-text text-muted">Format: JPG, PNG, WEBP, GIF. Maks: 2MB.</small>
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Simpan' }}</button>
    <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
</div>