{{--
    Variables expected:
    None, ini untuk form tambah baru
--}}
<div class="modal fade" id="tambahTimPendiriModal" tabindex="-1" aria-labelledby="tambahTimPendiriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.profil.panti.pendiri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahTimPendiriModalLabel">Tambah Anggota Tim Pendiri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Pesan error validasi (jika ada dan menggunakan error bag 'pendiri_store') --}}
                    @if ($errors->pendiri_store->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->pendiri_store->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="tp_nama_pendiri" class="form-label">Nama Pendiri <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_pendiri', 'pendiri_store') is-invalid @enderror" id="tp_nama_pendiri" name="nama_pendiri" value="{{ old('nama_pendiri') }}" required>
                        @error('nama_pendiri', 'pendiri_store')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tp_peran_atau_jabatan" class="form-label">Peran/Jabatan</label>
                        <input type="text" class="form-control @error('peran_atau_jabatan', 'pendiri_store') is-invalid @enderror" id="tp_peran_atau_jabatan" name="peran_atau_jabatan" value="{{ old('peran_atau_jabatan') }}">
                        @error('peran_atau_jabatan', 'pendiri_store')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tp_deskripsi_kontribusi" class="form-label">Deskripsi Kontribusi</label>
                        <textarea class="form-control @error('deskripsi_kontribusi', 'pendiri_store') is-invalid @enderror" id="tp_deskripsi_kontribusi" name="deskripsi_kontribusi" rows="3">{{ old('deskripsi_kontribusi') }}</textarea>
                        @error('deskripsi_kontribusi', 'pendiri_store')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tp_foto_pendiri" class="form-label">Foto Pendiri</label>
                        <input type="file" class="form-control @error('foto_pendiri', 'pendiri_store') is-invalid @enderror" id="tp_foto_pendiri" name="foto_pendiri" accept="image/jpeg,image/png,image/webp">
                        <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                        @error('foto_pendiri', 'pendiri_store')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tp_urutan" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control @error('urutan', 'pendiri_store') is-invalid @enderror" id="tp_urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0">
                        @error('urutan', 'pendiri_store')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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