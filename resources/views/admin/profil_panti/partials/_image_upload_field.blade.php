{{--
    Variables expected:
    $field_name (string, e.g., 'tentang_kami_img')
    $label (string, e.g., 'Gambar Tentang Kami')
    $current_image_url (string|null, URL of the current image if exists)
    $current_image_path (string|null, path of the current image in storage)
--}}
<div class="mb-3 image-upload-field">
    <label for="{{ $field_name }}" class="form-label">{{ $label }}</label>
    <div class="image-preview-container">
        @if($current_image_url)
            <img src="{{ $current_image_url }}" alt="Preview {{ $label }}" class="image-preview" data-original-src="{{ $current_image_url }}">
            <div class="image-preview-placeholder" style="display: none;">Tidak ada gambar</div>
        @else
            <img src="#" alt="Preview {{ $label }}" class="image-preview" style="display: none;">
            <div class="image-preview-placeholder">Tidak ada gambar</div>
        @endif
        <div>
            <input class="form-control @error($field_name) is-invalid @enderror" type="file" id="{{ $field_name }}" name="{{ $field_name }}" accept="image/jpeg,image/png,image/webp">
            @if($current_image_path)
            <div class="form-check form-check-inline mt-2">
                <input class="form-check-input remove-image-checkbox" type="checkbox" id="remove_{{ $field_name }}" name="remove_{{ $field_name }}" value="1">
                <label class="form-check-label" for="remove_{{ $field_name }}">Hapus gambar saat ini</label>
            </div>
            @endif
            <input type="hidden" class="current-image-path" value="{{ $current_image_path ? '1' : '' }}">
        </div>
    </div>
    @error($field_name) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    <small class="form-text text-muted">Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.</small>
</div>