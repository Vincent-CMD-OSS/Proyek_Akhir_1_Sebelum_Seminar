{{-- resources/views/public/donasi_public.blade.php --}}
@extends('layouts.user') {{-- Sesuaikan dengan nama layout utamamu --}}

@section('title', 'Donasi - ' . ($identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan'))

@push('styles')
<style>
    body {
        background-color: #fff;
        font-family: 'Arial', sans-serif;
        color: #333;
        line-height: 1.6;
    }
    .donasi-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
    }
    .page-header-donasi {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .page-header-donasi h1 {
        font-size: 2.5rem;
        color: #28a745; /* Warna hijau untuk donasi */
        margin-bottom: 0.5rem;
    }
    .page-header-donasi p {
        font-size: 1.1rem;
        color: #666;
    }
    .donasi-section {
        margin-bottom: 30px;
        padding: 25px;
        background-color: #f8f9fa;
        border-left: 5px solid #28a745;
        border-radius: 5px;
    }
    .donasi-section h2 {
        font-size: 1.6rem;
        color: #1e7e34; /* Hijau lebih tua */
        margin-top: 0;
        margin-bottom: 15px;
    }
    .donasi-section ul {
        list-style-type: disc;
        padding-left: 20px;
        margin-bottom: 0;
    }
    .donasi-section li {
        margin-bottom: 8px;
    }
    .donasi-form-section {
        margin-top: 40px;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .donasi-form-section h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #28a745;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: .5rem;
        display: block;
    }
    .form-control, .form-select {
        width: 100%;
        padding: .75rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        margin-bottom: 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 .2rem rgba(0,123,255,.25);
    }
    textarea.form-control {
        min-height: 100px;
    }
    .btn-donasi-submit {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        padding: .75rem 1.5rem;
        font-size: 1.1rem;
        border-radius: .3rem;
        cursor: pointer;
        transition: background-color .15s ease-in-out;
        width: 100%;
        text-align: center;
    }
    .btn-donasi-submit:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .alert-info {
        background-color: #e2f3ff;
        border-color: #b6d4fe;
        color: #004085;
        padding: 1rem;
        border-radius: .25rem;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="donasi-container">
    <div class="page-header-donasi">
        <h1>Mari Berbagi Kebaikan</h1>
        <p>Setiap donasi Anda sangat berarti untuk menunjang kehidupan dan pendidikan anak-anak di Panti Asuhan {{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }}.</p>
    </div>

    <section class="donasi-section">
        <h2>Mengapa Berdonasi?</h2>
        <p>Donasi Anda akan digunakan untuk:</p>
        <ul>
            <li>Memenuhi kebutuhan pangan, sandang, dan papan anak-anak.</li>
            <li>Menyediakan fasilitas pendidikan yang layak.</li>
            <li>Mendukung kegiatan pengembangan diri dan kreativitas.</li>
            <li>Menjamin kesehatan dan kesejahteraan mereka.</li>
            <li>Operasional dan pemeliharaan fasilitas panti.</li>
        </ul>
    </section>

    <section class="donasi-section">
        <h2>Jenis Donasi yang Kami Terima</h2>
        <p>Kami menerima donasi dalam bentuk:</p>
        <ul>
            <li><strong>Dana Tunai:</strong> Dapat ditransfer ke rekening resmi kami (informasi rekening akan diberikan setelah konfirmasi via WhatsApp).</li>
            <li><strong>Barang:</strong> Seperti sembako, alat tulis, pakaian layak pakai, buku-buku, mainan edukatif, dll.</li>
            <li><strong>Kebutuhan Spesifik:</strong> Anda dapat memilih untuk mendukung kebutuhan spesifik yang sedang kami publikasikan (lihat pilihan di form konfirmasi).</li>
        </ul>
    </section>

    <section class="donasi-section">
        <h2>Tahapan Berdonasi</h2>
        <ol style="padding-left: 20px;">
            <li><strong>Isi Form Konfirmasi:</strong> Lengkapi form di bawah ini dengan data diri Anda dan detail donasi yang ingin diberikan.</li>
            <li><strong>Kirim Konfirmasi:</strong> Setelah mengisi form, klik tombol "Konfirmasi Donasi via WhatsApp". Anda akan diarahkan ke WhatsApp kami dengan pesan yang sudah terisi.</li>
            <li><strong>Kirim Pesan WhatsApp:</strong> Kirim pesan tersebut kepada kami.</li>
            <li><strong>Tunggu Balasan Admin:</strong> Tim kami akan segera merespons dan memberikan informasi lebih lanjut mengenai proses penyaluran donasi Anda (misalnya nomor rekening untuk transfer dana atau alamat untuk pengiriman barang).</li>
            <li><strong>Selesaikan Donasi:</strong> Lakukan transfer dana atau kirim barang sesuai instruksi dari admin.</li>
            <li><strong>Konfirmasi Penerimaan:</strong> Kami akan memberikan konfirmasi setelah donasi Anda kami terima.</li>
        </ol>
        <div class="alert alert-info mt-3">
            <strong>Penting:</strong> Untuk keamanan dan transparansi, mohon untuk tidak melakukan transfer dana sebelum mendapatkan konfirmasi nomor rekening resmi dari admin kami melalui WhatsApp.
        </div>
    </section>

    {{-- FORM KONFIRMASI DONASI --}}
    <section class="donasi-form-section">
        <h2>Form Konfirmasi Donasi</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('public.donasi.kirim') }}" method="POST" id="formDonasiWA">
            @csrf
            <div class="mb-3">
                <label for="nama_donatur" class="form-label">Nama Lengkap Donatur <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_donatur" name="nama_donatur" value="{{ old('nama_donatur') }}" required>
            </div>
            <div class="mb-3">
                <label for="email_donatur" class="form-label">Alamat Email (Opsional)</label>
                <input type="email" class="form-control" id="email_donatur" name="email_donatur" value="{{ old('email_donatur') }}">
            </div>
            <div class="mb-3">
                <label for="telepon_donatur" class="form-label">Nomor Telepon/WhatsApp Aktif <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="telepon_donatur" name="telepon_donatur" value="{{ old('telepon_donatur') }}" placeholder="Contoh: 08123456789" required>
            </div>
            <div class="mb-3">
                <label for="donasi_untuk" class="form-label">Donasi Ini Ditujukan Untuk? <span class="text-danger">*</span></label>
                <select class="form-select" id="donasi_untuk" name="donasi_untuk" required>
                    <option value="" disabled {{ old('donasi_untuk') ? '' : 'selected' }}>-- Pilih Tujuan Donasi --</option>
                    <option value="Umum" {{ old('donasi_untuk') == 'Umum' ? 'selected' : '' }}>Donasi Umum (Kebutuhan Operasional Panti)</option>
                    @if($kebutuhanAktif->isNotEmpty())
                        <optgroup label="Kebutuhan Mendesak Saat Ini:">
                            @foreach($kebutuhanAktif as $kebutuhan)
                                <option value="kebutuhan_{{ $kebutuhan->id }}" {{ old('donasi_untuk') == 'kebutuhan_'.$kebutuhan->id ? 'selected' : '' }}>
                                    {{ $kebutuhan->nama_kebutuhan }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                    {{-- Anda bisa menambahkan opsi custom lain jika perlu --}}
                    {{-- <option value="Lainnya">Lainnya (isi di keterangan)</option> --}}
                </select>
            </div>
            <div class="mb-3">
                <label for="keterangan_tambahan" class="form-label">Keterangan Tambahan (Opsional)</label>
                <textarea class="form-control" id="keterangan_tambahan" name="keterangan_tambahan" rows="4">{{ old('keterangan_tambahan') }}</textarea>
                <small class="form-text text-muted">Misalnya: detail barang yang ingin didonasikan, preferensi penggunaan dana, dll.</small>
            </div>

            <button type="submit" class="btn-donasi-submit">
                <i class="fab fa-whatsapp"></i> Konfirmasi Donasi via WhatsApp
            </button>
        </form>
    </section>

    <section class="donasi-section mt-4">
        <h2>Kontak Kami</h2>
        <p>Jika Anda memiliki pertanyaan lebih lanjut mengenai donasi atau ingin berkunjung, jangan ragu untuk menghubungi kami melalui:</p>
        <ul>
            @if(isset($identitasPanti->telepon) && $identitasPanti->telepon)
            <li>Telepon/WhatsApp: <a href="https://wa.me/{{ $nomorWaPanti }}" target="_blank">{{ $identitasPanti->telepon }}</a></li>
            @endif
            @if(isset($identitasPanti->email) && $identitasPanti->email)
            <li>Email: <a href="mailto:{{ $identitasPanti->email }}">{{ $identitasPanti->email }}</a></li>
            @endif
            @if(isset($identitasPanti->alamat_lengkap) && $identitasPanti->alamat_lengkap)
            <li>Alamat: {{ $identitasPanti->alamat_lengkap }}</li>
            @endif
        </ul>
    </section>

</div>
@endsection

@push('scripts')
{{-- Font Awesome untuk ikon WhatsApp, jika belum ada di layout utama --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}
<script>
    // Jika kamu ingin validasi nomor telepon sebelum submit (opsional)
    // document.getElementById('formDonasiWA').addEventListener('submit', function(event) {
    //     const teleponInput = document.getElementById('telepon_donatur');
    //     const teleponValue = teleponInput.value;
    //     // Contoh validasi sederhana: harus angka dan minimal 10 digit
    //     if (!/^\d{10,}$/.test(teleponValue.replace(/[\s-()+]/g, ''))) {
    //         alert('Mohon masukkan nomor telepon yang valid (minimal 10 digit angka).');
    //         event.preventDefault(); // Mencegah form submit
    //         teleponInput.focus();
    //     }
    // });
</script>
@endpush