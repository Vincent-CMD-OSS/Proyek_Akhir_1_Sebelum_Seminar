{{--
    Variables expected:
    $anggota (StrukturOrganisasiAnggota model instance)
    $is_editing_active (boolean, true if this modal should be shown directly from controller)
--}}
<div class="modal fade" id="editStrukturAnggotaModal-{{ $anggota->id }}" tabindex="-1" aria-labelledby="editStrukturAnggotaModalLabel-{{ $anggota->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.profil.panti.struktur.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editStrukturAnggotaModalLabel-{{ $anggota->id }}">Edit Anggota Struktur: {{ $anggota->nama_anggota }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_sa_nama_anggota_{{ $anggota->id }}" class="form-label">Nama Anggota <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_sa_nama_anggota_{{ $anggota->id }}" name="nama_anggota" value="{{ old('nama_anggota', $anggota->nama_anggota) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_sa_jabatan_{{ $anggota->id }}" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_sa_jabatan_{{ $anggota->id }}" name="jabatan" value="{{ old('jabatan', $anggota->jabatan) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_sa_deskripsi_singkat_{{ $anggota->id }}" class="form-label">Deskripsi Singkat</label>
                        <textarea class="form-control" id="edit_sa_deskripsi_singkat_{{ $anggota->id }}" name="deskripsi_singkat" rows="3">{{ old('deskripsi_singkat', $anggota->deskripsi_singkat) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_sa_foto_anggota_{{ $anggota->id }}" class="form-label">Foto Anggota (Opsional: Ganti)</label>
                        <input type="file" class="form-control" id="edit_sa_foto_anggota_{{ $anggota->id }}" name="foto_anggota" accept="image/jpeg,image/png,image/webp">
                        @if($anggota->foto_anggota)
                            <div class="mt-2">
                                <img src="{{ Storage::url($anggota->foto_anggota) }}" alt="Foto Saat Ini" width="100" class="img-thumbnail">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="remove_foto_anggota_{{ $anggota->id }}" name="remove_foto_anggota" value="1">
                                    <label class="form-check-label" for="remove_foto_anggota_{{ $anggota->id }}">Hapus foto saat ini</label>
                                </div>
                            </div>
                        @endif
                        <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_sa_urutan_{{ $anggota->id }}" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control" id="edit_sa_urutan_{{ $anggota->id }}" name="urutan" value="{{ old('urutan', $anggota->urutan) }}" min="0">
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
        var editModalEl = document.getElementById('editStrukturAnggotaModal-{{ $anggota->id }}');
        if (editModalEl) {
            var editModal = new bootstrap.Modal(editModalEl);
            editModal.show();
        }
    });
</script>
@endif