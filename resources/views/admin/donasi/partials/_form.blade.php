{{-- resources/views/admin/donasi/partials/_form.blade.php --}}
{{--
    Variables:
    $donasi (optional, instance of Donasi)
    $kebutuhanList (collection of Kebutuhan for select)
    $selectedKebutuhanId (optional, ID for pre-selecting kebutuhan)
    $buttonText (string)
--}}

@csrf

<div class="row">
    <div class="col-md-7">
        {{-- Nama Donatur --}}
        <div class="mb-3">
            <label for="nama_donatur" class="form-label">Nama Donatur <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_donatur') is-invalid @enderror" id="nama_donatur" name="nama_donatur"
                   value="{{ old('nama_donatur', $donasi->nama_donatur ?? 'Hamba Allah') }}" required>
            @error('nama_donatur') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Untuk Kebutuhan (Opsional) --}}
        <div class="mb-3">
            <label for="kebutuhan_id" class="form-label">Untuk Kebutuhan Spesifik (Opsional)</label>
            <select class="form-select @error('kebutuhan_id') is-invalid @enderror" id="kebutuhan_id" name="kebutuhan_id">
                <option value="">-- Donasi Umum (Tidak untuk kebutuhan spesifik) --</option>
                @foreach($kebutuhanList as $id => $nama)
                    <option value="{{ $id }}"
                            {{ old('kebutuhan_id', $donasi->kebutuhan_id ?? $selectedKebutuhanId ?? '') == $id ? 'selected' : '' }}>
                        {{ $nama }}
                    </option>
                @endforeach
            </select>
            @error('kebutuhan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>


        {{-- Jumlah Donasi --}}
        <div class="mb-3">
            <label for="jumlah_donasi" class="form-label">Jumlah Donasi (Rp) <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('jumlah_donasi') is-invalid @enderror" id="jumlah_donasi" name="jumlah_donasi"
                   value="{{ old('jumlah_donasi', $donasi->jumlah_donasi ?? '') }}" required min="1" step="any">
            @error('jumlah_donasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Tanggal Donasi --}}
        <div class="mb-3">
            <label for="tanggal_donasi" class="form-label">Tanggal Donasi Diterima <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('tanggal_donasi') is-invalid @enderror" id="tanggal_donasi" name="tanggal_donasi"
                   value="{{ old('tanggal_donasi', isset($donasi) && $donasi->tanggal_donasi ? $donasi->tanggal_donasi->format('Y-m-d') : date('Y-m-d')) }}" required>
            @error('tanggal_donasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Catatan Donasi --}}
        <div class="mb-3">
            <label for="catatan_donasi" class="form-label">Catatan (Opsional)</label>
            <textarea class="form-control @error('catatan_donasi') is-invalid @enderror" id="catatan_donasi" name="catatan_donasi" rows="3">{{ old('catatan_donasi', $donasi->catatan_donasi ?? '') }}</textarea>
            @error('catatan_donasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-md-5">
        {{-- Nomor Telepon Donatur --}}
        <div class="mb-3">
            <label for="nomor_telepon_donatur" class="form-label">Nomor Telepon Donatur (Opsional)</label>
            <input type="text" class="form-control @error('nomor_telepon_donatur') is-invalid @enderror" id="nomor_telepon_donatur" name="nomor_telepon_donatur"
                   value="{{ old('nomor_telepon_donatur', $donasi->nomor_telepon_donatur ?? '') }}">
            @error('nomor_telepon_donatur') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Email Donatur --}}
        <div class="mb-3">
            <label for="email_donatur" class="form-label">Email Donatur (Opsional)</label>
            <input type="email" class="form-control @error('email_donatur') is-invalid @enderror" id="email_donatur" name="email_donatur"
                   value="{{ old('email_donatur', $donasi->email_donatur ?? '') }}">
            @error('email_donatur') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Metode Pembayaran --}}
        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran (Opsional)</label>
            <input type="text" class="form-control @error('metode_pembayaran') is-invalid @enderror" id="metode_pembayaran" name="metode_pembayaran"
                   value="{{ old('metode_pembayaran', $donasi->metode_pembayaran ?? '') }}" placeholder="Transfer BCA, Tunai, dll.">
            @error('metode_pembayaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Nomor Rekening Pengirim --}}
        <div class="mb-3">
            <label for="nomor_rekening_pengirim" class="form-label">Nomor Rekening Pengirim (Opsional)</label>
            <input type="text" class="form-control @error('nomor_rekening_pengirim') is-invalid @enderror" id="nomor_rekening_pengirim" name="nomor_rekening_pengirim"
                   value="{{ old('nomor_rekening_pengirim', $donasi->nomor_rekening_pengirim ?? '') }}">
            @error('nomor_rekening_pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
         <div class="mb-3">
            <label for="bank_pengirim" class="form-label">Bank Pengirim (Opsional)</label>
            <input type="text" class="form-control @error('bank_pengirim') is-invalid @enderror" id="bank_pengirim" name="bank_pengirim"
                   value="{{ old('bank_pengirim', $donasi->bank_pengirim ?? '') }}">
            @error('bank_pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Bukti Pembayaran --}}
        <div class="mb-3">
            <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran (Opsional)</label>
            @if (isset($donasi) && $donasi->bukti_pembayaran)
                <div class="mb-2">
                    <a href="{{ Storage::url($donasi->bukti_pembayaran) }}" target="_blank">
                        <img src="{{ Storage::url($donasi->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-thumbnail" width="150" id="bukti-preview">
                    </a>
                     <div class="form-check mt-1">
                        <input class="form-check-input" type="checkbox" name="remove_bukti_pembayaran" id="remove_bukti_pembayaran" value="1">
                        <label class="form-check-label" for="remove_bukti_pembayaran">
                            Hapus bukti saat ini
                        </label>
                    </div>
                </div>
            @else
                <img src="#" alt="Preview Bukti" class="img-thumbnail mb-2" width="150" id="bukti-preview" style="display: none;">
            @endif
            <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror" id="bukti_pembayaran_input" name="bukti_pembayaran" accept="image/jpeg,image/png,image/jpg,image/webp">
            @error('bukti_pembayaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Status Verifikasi --}}
        <div class="mb-3">
            <label for="status_verifikasi" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
            <select class="form-select @error('status_verifikasi') is-invalid @enderror" id="status_verifikasi" name="status_verifikasi" required>
                <option value="Pending" {{ old('status_verifikasi', $donasi->status_verifikasi ?? 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Terverifikasi" {{ old('status_verifikasi', $donasi->status_verifikasi ?? '') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="Ditolak" {{ old('status_verifikasi', $donasi->status_verifikasi ?? '') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            @error('status_verifikasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

    </div>
</div>


<div class="mt-4">
    <button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Simpan Donasi' }}</button>
    @if(isset($donasi) && $donasi->kebutuhan_id)
        <a href="{{ route('admin.kebutuhan.show', $donasi->kebutuhan_id) }}" class="btn btn-secondary">Batal</a>
    @else
        <a href="{{ route('admin.donasi.index') }}" class="btn btn-secondary">Batal</a>
    @endif
</div>