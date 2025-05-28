<div class="modal fade" id="tambahStrukturAnggotaModal" tabindex="-1" aria-labelledby="tambahStrukturAnggotaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.profil.panti.struktur.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahStrukturAnggotaModalLabel">Tambah Anggota Struktur Organisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sa_nama_anggota" class="form-label">Nama Anggota <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sa_nama_anggota" name="nama_anggota" value="{{ old('nama_anggota') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="sa_jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sa_jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="sa_deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
                        <textarea class="form-control" id="sa_deskripsi_singkat" name="deskripsi_singkat" rows="3">{{ old('deskripsi_singkat') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sa_foto_anggota" class="form-label">Foto Anggota</label>
                        <input type="file" class="form-control" id="sa_foto_anggota" name="foto_anggota" accept="image/jpeg,image/png,image/webp">
                        <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                    </div>
                    <div class="mb-3">
                        <label for="sa_urutan" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control" id="sa_urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>
</div>