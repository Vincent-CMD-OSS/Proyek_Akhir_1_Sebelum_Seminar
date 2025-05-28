{{-- resources/views/admin/operasional/khusus/partials/_form.blade.php --}}
{{--
    Variables:
    $jadwal (optional, instance of JadwalOperasionalKhusus)
    $buttonText (string)
--}}

@csrf

<div class="row">
    <div class="col-md-6">
        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal"
                   value="{{ old('tanggal', isset($jadwal) && $jadwal->tanggal ? $jadwal->tanggal->format('Y-m-d') : '') }}" required>
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nama Acara/Libur --}}
        <div class="mb-3">
            <label for="nama_acara_libur" class="form-label">Nama Acara / Libur <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_acara_libur') is-invalid @enderror" id="nama_acara_libur" name="nama_acara_libur"
                   value="{{ old('nama_acara_libur', $jadwal->nama_acara_libur ?? '') }}" placeholder="Contoh: Libur Idul Fitri, Acara Panti" required>
            @error('nama_acara_libur')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status Operasional --}}
        <div class="mb-3">
            <label for="status_operasional_khusus" class="form-label">Status Operasional <span class="text-danger">*</span></label>
            <select class="form-select @error('status_operasional') is-invalid @enderror" id="status_operasional_khusus" name="status_operasional" required>
                <option value="">Pilih Status</option>
                <option value="Buka" {{ old('status_operasional', $jadwal->status_operasional ?? '') == 'Buka' ? 'selected' : '' }}>Buka (Sesuai Jadwal Harian / Jam Khusus)</option>
                <option value="Tutup" {{ old('status_operasional', $jadwal->status_operasional ?? '') == 'Tutup' ? 'selected' : '' }}>Tutup Total</option>
                <option value="Jam Khusus" {{ old('status_operasional', $jadwal->status_operasional ?? '') == 'Jam Khusus' ? 'selected' : '' }}>Jam Khusus</option>
            </select>
            @error('status_operasional')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        @php
            // Tentukan apakah field jam khusus harus visible secara default
            $isJamKhususVisible = (old('status_operasional', $jadwal->status_operasional ?? '') == 'Jam Khusus');
        @endphp

        {{-- Jam Buka Khusus (conditional) --}}
        {{-- Atribut style inline dihilangkan, visibilitas diatur JS --}}
        <div class="mb-3" id="jam-buka-khusus-group" data-initial-visible="{{ $isJamKhususVisible ? 'true' : 'false' }}" style="display: none;"> {{-- Default display none, JS akan atur --}}
            <label for="jam_buka_khusus" class="form-label">Jam Buka (Khusus)</label>
            <input type="time" class="form-control @error('jam_buka_khusus') is-invalid @enderror" id="jam_buka_khusus" name="jam_buka_khusus"
                   value="{{ old('jam_buka_khusus', $jadwal->jam_buka_khusus ?? '') }}">
            @error('jam_buka_khusus')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Jam Tutup Khusus (conditional) --}}
        {{-- Atribut style inline dihilangkan, visibilitas diatur JS --}}
        <div class="mb-3" id="jam-tutup-khusus-group" data-initial-visible="{{ $isJamKhususVisible ? 'true' : 'false' }}" style="display: none;"> {{-- Default display none, JS akan atur --}}
            <label for="jam_tutup_khusus" class="form-label">Jam Tutup (Khusus)</label>
            <input type="time" class="form-control @error('jam_tutup_khusus') is-invalid @enderror" id="jam_tutup_khusus" name="jam_tutup_khusus"
                   value="{{ old('jam_tutup_khusus', $jadwal->jam_tutup_khusus ?? '') }}">
            @error('jam_tutup_khusus')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Keterangan --}}
        <div class="mb-3">
            <label for="keterangan_khusus" class="form-label">Keterangan Tambahan</label>
            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan_khusus" name="keterangan" rows="3">{{ old('keterangan', $jadwal->keterangan ?? '') }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Simpan' }}</button>
    <a href="{{ route('admin.operasional.index') }}" class="btn btn-secondary">Batal</a>
</div>