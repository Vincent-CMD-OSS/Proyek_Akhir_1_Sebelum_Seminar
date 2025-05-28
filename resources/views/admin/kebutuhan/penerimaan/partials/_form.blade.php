{{-- resources/views/admin/kebutuhan/penerimaan/partials/_form.blade.php --}}
{{--
    Variables:
    $kebutuhan (instance of Kebutuhan)
    $penerimaan (optional, instance of PenerimaanDanaKebutuhan)
    $buttonText (string)
--}}

@csrf

<div class="mb-3">
    <label for="jumlah_dana_diterima" class="form-label">Jumlah Dana Diterima (Rp) <span class="text-danger">*</span></label>
    <input type="number" class="form-control @error('jumlah_dana_diterima') is-invalid @enderror" id="jumlah_dana_diterima" name="jumlah_dana_diterima"
           value="{{ old('jumlah_dana_diterima', $penerimaan->jumlah_dana_diterima ?? '') }}" required min="0.01" step="any">
    @error('jumlah_dana_diterima')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nama_pemberi" class="form-label">Nama Pemberi/Donatur <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('nama_pemberi') is-invalid @enderror" id="nama_pemberi" name="nama_pemberi"
           value="{{ old('nama_pemberi', $penerimaan->nama_pemberi ?? 'Hamba Allah') }}" required>
    @error('nama_pemberi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="tanggal_diterima" class="form-label">Tanggal Diterima <span class="text-danger">*</span></label>
    <input type="date" class="form-control @error('tanggal_diterima') is-invalid @enderror" id="tanggal_diterima" name="tanggal_diterima"
           value="{{ old('tanggal_diterima', isset($penerimaan) && $penerimaan->tanggal_diterima ? $penerimaan->tanggal_diterima->format('Y-m-d') : date('Y-m-d')) }}" required>
    @error('tanggal_diterima')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="metode_pembayaran" class="form-label">Metode Pembayaran (Opsional)</label>
    <input type="text" class="form-control @error('metode_pembayaran') is-invalid @enderror" id="metode_pembayaran" name="metode_pembayaran"
           value="{{ old('metode_pembayaran', $penerimaan->metode_pembayaran ?? '') }}" placeholder="Contoh: Tunai, Transfer BCA, dll.">
    @error('metode_pembayaran')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="catatan_penerimaan" class="form-label">Catatan Tambahan (Opsional)</label>
    <textarea class="form-control @error('catatan_penerimaan') is-invalid @enderror" id="catatan_penerimaan" name="catatan_penerimaan" rows="3">{{ old('catatan_penerimaan', $penerimaan->catatan_penerimaan ?? '') }}</textarea>
    @error('catatan_penerimaan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Simpan Catatan' }}</button>
    <a href="{{ route('admin.kebutuhan.show', $kebutuhan->id) }}" class="btn btn-secondary">Batal</a>
</div>