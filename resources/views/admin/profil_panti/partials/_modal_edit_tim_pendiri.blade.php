{{--
    Variables expected:
    $pendiri (TimPendiriAnggota model instance)
    $is_editing_active (boolean, true if this modal should be shown directly from controller)
--}}
<div class="modal fade" id="editTimPendiriModal-{{ $pendiri->id }}" tabindex="-1" aria-labelledby="editTimPendiriModalLabel-{{ $pendiri->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.profil.panti.pendiri.update', $pendiri->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTimPendiriModalLabel-{{ $pendiri->id }}">Edit Anggota Tim Pendiri: {{ $pendiri->nama_pendiri }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Pesan error validasi (jika ada dan menggunakan error bag 'pendiri_update_{id}') --}}
                    @if ($errors->{'pendiri_update_' . $pendiri->id}->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->{'pendiri_update_' . $pendiri->id}->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="edit_tp_nama_pendiri_{{ $pendiri->id }}" class="form-label">Nama Pendiri <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_pendiri', 'pendiri_update_' . $pendiri->id) is-invalid @enderror" id="edit_tp_nama_pendiri_{{ $pendiri->id }}" name="nama_pendiri" value="{{ old('nama_pendiri', $pendiri->nama_pendiri) }}" required>
                         @error('nama_pendiri', 'pendiri_update_' . $pendiri->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_tp_peran_atau_jabatan_{{ $pendiri->id }}" class="form-label">Peran/Jabatan</label>
                        <input type="text" class="form-control @error('peran_atau_jabatan', 'pendiri_update_' . $pendiri->id) is-invalid @enderror" id="edit_tp_peran_atau_jabatan_{{ $pendiri->id }}" name="peran_atau_jabatan" value="{{ old('peran_atau_jabatan', $pendiri->peran_atau_jabatan) }}">
                        @error('peran_atau_jabatan', 'pendiri_update_' . $pendiri->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_tp_deskripsi_kontribusi_{{ $pendiri->id }}" class="form-label">Deskripsi Kontribusi</label>
                        <textarea class="form-control @error('deskripsi_kontribusi', 'pendiri_update_' . $pendiri->id) is-invalid @enderror" id="edit_tp_deskripsi_kontribusi_{{ $pendiri->id }}" name="deskripsi_kontribusi" rows="3">{{ old('deskripsi_kontribusi', $pendiri->deskripsi_kontribusi) }}</textarea>
                        @error('deskripsi_kontribusi', 'pendiri_update_' . $pendiri->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_tp_foto_pendiri_{{ $pendiri->id }}" class="form-label">Foto Pendiri (Opsional: Ganti)</label>
                        <input type="file" class="form-control @error('foto_pendiri', 'pendiri_update_' . $pendiri->id) is-invalid @enderror" id="edit_tp_foto_pendiri_{{ $pendiri->id }}" name="foto_pendiri" accept="image/jpeg,image/png,image/webp">
                        @if($pendiri->foto_pendiri)
                            <div class="mt-2">
                                <img src="{{ Storage::url($pendiri->foto_pendiri) }}" alt="Foto Saat Ini" width="100" class="img-thumbnail">
                                <div class="form-check form-check-inline ms-2">
                                    <input class="form-check-input" type="checkbox" id="remove_foto_pendiri_{{ $pendiri->id }}" name="remove_foto_pendiri" value="1">
                                    <label class="form-check-label" for="remove_foto_pendiri_{{ $pendiri->id }}">Hapus foto saat ini</label>
                                </div>
                            </div>
                        @endif
                        <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                        @error('foto_pendiri', 'pendiri_update_' . $pendiri->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_tp_urutan_{{ $pendiri->id }}" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control @error('urutan', 'pendiri_update_' . $pendiri->id) is-invalid @enderror" id="edit_tp_urutan_{{ $pendiri->id }}" name="urutan" value="{{ old('urutan', $pendiri->urutan) }}" min="0">
                        @error('urutan', 'pendiri_update_' . $pendiri->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(isset($is_editing_active) && $is_editing_active === true)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModalEl = document.getElementById('editTimPendiriModal-{{ $pendiri->id }}');
        if (editModalEl) {
            var editModal = new bootstrap.Modal(editModalEl);
            editModal.show();
        }
    });
</script>
@endif