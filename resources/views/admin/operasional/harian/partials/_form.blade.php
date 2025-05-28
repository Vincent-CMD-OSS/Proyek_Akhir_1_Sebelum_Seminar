{{-- resources/views/admin/operasional/harian/partials/_form.blade.php --}}
{{--
    Variables:
    $jadwal (optional, instance of JadwalOperasionalHarian)
    $buttonText (string)
--}}

@csrf {{-- Akan di-include oleh form utama --}}

<div class="row">
    <div class="col-md-6">
        {{-- Hari --}}
        <div class="mb-3">
            <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
            <select class="form-select @error('hari') is-invalid @enderror" id="hari" name="hari" required>
                <option value="">Pilih Hari</option>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                    <option value="{{ $h }}" {{ old('hari', $jadwal->hari ?? '') == $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
            @error('hari')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Jam Buka --}}
        <div class="mb-3">
            <label for="jam_buka" class="form-label">Jam Buka <span class="text-danger">*</span></label>
            <input type="time" class="form-control @error('jam_buka') is-invalid @enderror" id="jam_buka" name="jam_buka" value="{{ old('jam_buka', $jadwal->jam_buka ?? '') }}" required>
            @error('jam_buka')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Jam Tutup --}}
        <div class="mb-3">
            <label for="jam_tutup" class="form-label">Jam Tutup <span class="text-danger">*</span></label>
            <input type="time" class="form-control @error('jam_tutup') is-invalid @enderror" id="jam_tutup" name="jam_tutup" value="{{ old('jam_tutup', $jadwal->jam_tutup ?? '') }}" required>
            @error('jam_tutup')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        {{-- Status Operasional --}}
        <div class="mb-3">
            <label for="status_operasional" class="form-label">Status Operasional <span class="text-danger">*</span></label>
            <select class="form-select @error('status_operasional') is-invalid @enderror" id="status_operasional" name="status_operasional" required>
                <option value="Buka" {{ old('status_operasional', $jadwal->status_operasional ?? 'Buka') == 'Buka' ? 'selected' : '' }}>Buka (Kunjungan Diperbolehkan)</option>
                <option value="Tutup" {{ old('status_operasional', $jadwal->status_operasional ?? '') == 'Tutup' ? 'selected' : '' }}>Tutup (Kunjungan Tidak Diperbolehkan)</option>
            </select>
            @error('status_operasional')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Keterangan --}}
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan', $jadwal->keterangan ?? '') }}" placeholder="Contoh: Istirahat Siang">
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Urutan --}}
        <div class="mb-3">
            <label for="urutan" class="form-label">Urutan Slot (dalam satu hari)</label>
            <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan', $jadwal->urutan ?? 0) }}" min="0">
            <small class="form-text text-muted">Gunakan untuk mengurutkan beberapa slot dalam satu hari (0, 1, 2, ...).</small>
            @error('urutan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Simpan' }}</button>
    <a href="{{ route('admin.operasional.index') }}" class="btn btn-secondary">Batal</a>
</div>