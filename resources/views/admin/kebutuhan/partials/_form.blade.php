{{-- resources/views/admin/kebutuhan/partials/_form.blade.php --}}
{{--
    Variables:
    $kebutuhan (optional, instance of Kebutuhan)
    $buttonText (string)
--}}

@csrf

<div class="row">
    <div class="col-md-8">
        {{-- Nama Kebutuhan --}}
        <div class="mb-3">
            <label for="nama_kebutuhan" class="form-label">Nama/Judul Kebutuhan <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_kebutuhan') is-invalid @enderror" id="nama_kebutuhan" name="nama_kebutuhan" value="{{ old('nama_kebutuhan', $kebutuhan->nama_kebutuhan ?? '') }}" required>
            @error('nama_kebutuhan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Kebutuhan <span class="text-danger">*</span></label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="8" required>{{ old('deskripsi', $kebutuhan->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Slug --}}
        <div class="mb-3">
            <label for="slug" class="form-label">Slug (URL)</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $kebutuhan->slug ?? '') }}" placeholder="Akan di-generate otomatis jika kosong">
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        {{-- Status Kebutuhan --}}
        <div class="mb-3">
            <label for="status_kebutuhan" class="form-label">Status Kebutuhan <span class="text-danger">*</span></label>
            @php
                $isStatusFinal = isset($kebutuhan) && in_array($kebutuhan->status_kebutuhan, ['Tercapai', 'Dibatalkan']);
                $currentStatus = old('status_kebutuhan', $kebutuhan->status_kebutuhan ?? 'Draft');
            @endphp
            <select class="form-select @error('status_kebutuhan') is-invalid @enderror" id="status_kebutuhan" name="status_kebutuhan" required {{ $isStatusFinal ? 'disabled' : '' }}>
                <option value="Draft" {{ $currentStatus == 'Draft' ? 'selected' : '' }} {{ $isStatusFinal && $currentStatus != 'Draft' ? 'disabled' : '' }}>Draft</option>
                <option value="Aktif" {{ $currentStatus == 'Aktif' ? 'selected' : '' }} {{ $isStatusFinal && $currentStatus != 'Aktif' ? 'disabled' : '' }}>Aktif (Dipublikasikan)</option>
                <option value="Tercapai" {{ $currentStatus == 'Tercapai' ? 'selected' : '' }}>Tercapai</option>
                <option value="Dibatalkan" {{ $currentStatus == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @if($isStatusFinal)
                <input type="hidden" name="status_kebutuhan" value="{{ $kebutuhan->status_kebutuhan }}">
                <small class="form-text text-warning">Status sudah final ({{ $kebutuhan->status_kebutuhan }}) dan tidak dapat diubah.</small>
            @endif
            @error('status_kebutuhan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Target Dana --}}
        <div class="mb-3">
            <label for="target_dana" class="form-label">Target Dana (Rp)</label>
            <input type="number" class="form-control @error('target_dana') is-invalid @enderror" id="target_dana" name="target_dana" value="{{ old('target_dana', $kebutuhan->target_dana ?? '') }}" min="0" step="any" placeholder="Kosongkan jika tidak ada target spesifik">
            @error('target_dana')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Mulai Dipublikasikan --}}
        <div class="mb-3">
            <label for="tanggal_mulai_dipublikasikan" class="form-label">Tanggal Mulai Publikasi</label>
            <input type="date" class="form-control @error('tanggal_mulai_dipublikasikan') is-invalid @enderror" id="tanggal_mulai_dipublikasikan" name="tanggal_mulai_dipublikasikan"
                   value="{{ old('tanggal_mulai_dipublikasikan', isset($kebutuhan) && $kebutuhan->tanggal_mulai_dipublikasikan ? $kebutuhan->tanggal_mulai_dipublikasikan->format('Y-m-d') : '') }}">
            @error('tanggal_mulai_dipublikasikan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Target Tercapai --}}
        <div class="mb-3">
            <label for="tanggal_target_tercapai" class="form-label">Tanggal Target Tercapai</label>
            <input type="date" class="form-control @error('tanggal_target_tercapai') is-invalid @enderror" id="tanggal_target_tercapai" name="tanggal_target_tercapai"
                   value="{{ old('tanggal_target_tercapai', isset($kebutuhan) && $kebutuhan->tanggal_target_tercapai ? $kebutuhan->tanggal_target_tercapai->format('Y-m-d') : '') }}">
            @error('tanggal_target_tercapai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Gambar Kebutuhan --}}
        <div class="mb-3">
            <label for="gambar_kebutuhan" class="form-label">Gambar Kebutuhan (Opsional)</label>
            @if (isset($kebutuhan) && $kebutuhan->gambar_kebutuhan)
                <div class="mb-2">
                    <img src="{{ Storage::url($kebutuhan->gambar_kebutuhan) }}" alt="{{ $kebutuhan->nama_kebutuhan }}" class="img-thumbnail" width="200" id="gambar-kebutuhan-preview">
                     <div class="form-check mt-1">
                        <input class="form-check-input" type="checkbox" name="remove_gambar_kebutuhan" id="remove_gambar_kebutuhan" value="1">
                        <label class="form-check-label" for="remove_gambar_kebutuhan">
                            Hapus gambar saat ini
                        </label>
                    </div>
                </div>
            @else
                <img src="#" alt="Preview Gambar" class="img-thumbnail mb-2" width="200" id="gambar-kebutuhan-preview" style="display: none;">
            @endif
            <input type="file" class="form-control @error('gambar_kebutuhan') is-invalid @enderror" id="gambar_kebutuhan_input" name="gambar_kebutuhan" accept="image/jpeg,image/png,image/webp">
            @error('gambar_kebutuhan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Simpan' }}</button>
    <a href="{{ route('admin.kebutuhan.index') }}" class="btn btn-secondary">Batal</a>
</div>