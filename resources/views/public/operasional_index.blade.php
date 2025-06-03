{{-- resources/views/public/operasional_public.blade.php --}}
@extends('layouts.user')

@php
    function formatJam(string $jam = null): string {
        if (!$jam) return '-';
        try {
            return \Carbon\Carbon::createFromFormat('H:i:s', $jam)->format('H:i');
        } catch (\Exception $e) {
            try {
                return \Carbon\Carbon::createFromFormat('H:i', $jam)->format('H:i');
            } catch (\Exception $e) {
                return $jam;
            }
        }
    }
@endphp

@section('title', 'Jadwal Operasional - ' . ($identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan'))

@push('styles')
<style>
    /* ... (CSS dari respons sebelumnya, sudah bagus) ... */
    :root {
        --color-bg-light: #f8fafc;
        --color-bg-white: #ffffff;
        --color-primary-blue: #87CEEB;
        --color-primary-blue-darker: #5aa8c7;
        --color-accent-yellow: #FFDE59;
        --color-text-header: #1e293b;
        --color-text-body: #475569;
        --color-text-muted: #64748b;
        --color-border-light: #e2e8f0;
        --color-success-green: #4CAF50;
        --font-family-sans: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.08);
        --border-radius-sm: 0.375rem;
        --border-radius-md: 0.5rem;
        --border-radius-lg: 0.75rem;
    }
    body { font-family: var(--font-family-sans); background-color: var(--color-bg-white); color: var(--color-text-body); line-height: 1.7; margin: 0; }
    .operasional-page-section { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 4rem 1.5rem; box-sizing: border-box; opacity: 0; transform: translateY(20px); transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
    .operasional-page-section.is-visible { opacity: 1; transform: translateY(0); }
    .section-container { width: 100%; max-width: 960px; text-align: center; }
    .hero-operasional-section { background-color: var(--color-bg-light); }
    .hero-operasional-icon { font-size: 4.5rem; color: var(--color-primary-blue); margin-bottom: 1.5rem; display: inline-block; }
    .hero-operasional-title { font-size: 2.8rem; font-weight: 700; color: var(--color-text-header); margin-bottom: 1rem; line-height: 1.3; }
    .hero-operasional-subtitle { font-size: 1.15rem; color: var(--color-text-muted); max-width: 650px; margin: 0 auto 2rem auto; }
    .hero-accent-bar { width: 70px; height: 4px; background-color: var(--color-accent-yellow); border-radius: 2px; margin: 0 auto; }
    .content-section-title { font-size: 2.2rem; font-weight: 600; color: var(--color-text-header); margin-bottom: 0.75rem; }
    .content-section-subtitle { font-size: 1.1rem; color: var(--color-text-muted); margin-bottom: 3rem; max-width: 700px; margin-left: auto; margin-right: auto; }
    .title-accent-line { width: 50px; height: 3px; background-color: var(--color-primary-blue); border-radius: 1.5px; margin: 0 auto 2.5rem auto; }
    .jadwal-harian-wrapper { background-color: var(--color-bg-white); border-radius: var(--border-radius-lg); box-shadow: var(--shadow-lg); padding: 1.5rem; overflow-x: auto; }
    .jadwal-harian-table { width: 100%; border-collapse: collapse; }
    .jadwal-harian-table th, .jadwal-harian-table td { padding: 0.9rem 1rem; text-align: center; border-bottom: 1px solid var(--color-border-light); }
    .jadwal-harian-table thead th { font-weight: 600; color: var(--color-text-body); font-size: 0.9rem; text-transform: uppercase; background-color: var(--color-bg-light); }
    .jadwal-harian-table tbody tr:last-child td { border-bottom: none; }
    .jadwal-harian-table .day-name { font-weight: 500; color: var(--color-text-header); text-align: left; }
    .jadwal-harian-table .time-text { color: var(--color-text-body); }
    .status-badge { padding: 0.4em 0.9em; border-radius: 100px; font-weight: 500; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
    .status-open { background-color: #e6fffa; color: #008080; }
    .status-closed { background-color: #ffebee; color: #c62828; }
    .btn-ajukan-kunjungan { background-color: var(--color-primary-blue); color: white !important; border: none; padding: 0.4rem 0.8rem; border-radius: var(--border-radius-sm); font-size: 0.85rem; font-weight: 500; transition: background-color 0.2s ease; text-decoration: none; cursor: pointer; }
    .btn-ajukan-kunjungan:hover { background-color: var(--color-primary-blue-darker); color: white !important; }
    .btn-ajukan-kunjungan i { margin-right: 0.35rem; }
    .jadwal-khusus-section { background-color: var(--color-bg-light); }
    .special-schedule-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
    .special-card { background-color: var(--color-bg-white); border-radius: var(--border-radius-md); box-shadow: var(--shadow-md); padding: 1.5rem; display: flex; flex-direction: column; text-align: left; border-top: 4px solid var(--color-primary-blue); }
    .special-card-header { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem; }
    .special-date-info .date-display { font-size: 1.8rem; font-weight: 600; color: var(--color-primary-blue); line-height: 1; }
    .special-date-info .month-year-display { font-size: 0.85rem; color: var(--color-text-muted); text-transform: uppercase; }
    .special-event-details { flex-grow: 1; }
    .special-event-name { font-size: 1.1rem; font-weight: 600; color: var(--color-text-header); margin-bottom: 0.25rem; }
    .special-event-day { font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 1rem; }
    .special-info-item { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; font-size: 0.9rem; border-top: 1px solid var(--color-border-light); }
    .special-info-item:first-of-type { border-top: none; padding-top:0; }
    .special-info-item.keterangan-item { flex-direction: column; align-items: flex-start; }
    .special-info-label { color: var(--color-text-muted); font-weight: 500; }
    .special-info-value { color: var(--color-text-body); font-weight: 500; text-align: right; }
    .special-info-value.keterangan-text { text-align: left; margin-top: 0.25rem; font-size: 0.85rem; line-height: 1.5; width: 100%; }
    .status-special { background-color: #fff8e1; color: #f57f17; }
    .empty-state-container { background-color: var(--color-bg-white); padding: 2.5rem; border-radius: var(--border-radius-lg); text-align: center; color: var(--color-text-muted); box-shadow: var(--shadow-md); }
    .empty-state-container .icon { font-size: 3rem; margin-bottom: 1rem; color: var(--color-primary-blue); }
    .empty-state-container h3 { font-size: 1.4rem; color: var(--color-text-header); margin-bottom: 0.5rem; }
    .modal-content { border-radius: var(--border-radius-lg); font-family: var(--font-family-sans); }
    .modal-header { background-color: var(--color-bg-light); border-bottom: 1px solid var(--color-border-light); }
    .modal-title { color: var(--color-text-header); font-weight: 600; }
    .modal-body .form-label { font-weight: 500; color: var(--color-text-header); font-size: 0.9rem; }
    .modal-body .form-control { border-radius: var(--border-radius-sm); border-color: var(--color-border-light); padding: 0.65rem 0.9rem; font-size: 0.95rem; }
    .modal-body .form-control:focus { border-color: var(--color-primary-blue); box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.25); }
    .modal-footer { border-top: 1px solid var(--color-border-light); }
    .btn-submit-kunjungan { background-color: var(--color-success-green); border-color: var(--color-success-green); color: white; font-weight: 500; }
    .btn-submit-kunjungan:hover { background-color: #3e8e41; border-color: #3e8e41; }
    .alert-danger { font-size: 0.9rem; }
    @media (max-width: 768px) {
        .operasional-page-section { padding: 3rem 1rem; min-height: auto; }
        .hero-operasional-icon { font-size: 3.5rem; }
        .hero-operasional-title { font-size: 2.2rem; }
        .hero-operasional-subtitle { font-size: 1rem; }
        .content-section-title { font-size: 1.8rem; }
        .content-section-subtitle { font-size: 0.95rem; margin-bottom: 2rem; }
        .jadwal-harian-table th, .jadwal-harian-table td { padding: 0.75rem; font-size: 0.85rem; }
        .special-schedule-grid { grid-template-columns: 1fr; }
        .btn-ajukan-kunjungan { width: 100%; margin-top: 0.5rem; }
    }
</style>
@endpush

@section('content')

<!-- HERO SECTION -->
<section class="operasional-page-section hero-operasional-section">
    <div class="section-container">
        <span class="hero-operasional-icon">🗓️</span>
        <h1 class="hero-operasional-title">Jadwal Operasional</h1>
        <p class="hero-operasional-subtitle">
            Informasi jam layanan dan kunjungan di {{ $identitasPanti->nama_panti ?? 'Panti Asuhan Rumah Harapan' }}.
        </p>
        <div class="hero-accent-bar"></div>
    </div>
</section>

<!-- JADWAL HARIAN SECTION -->
<section class="operasional-page-section">
    <div class="section-container">
        <h2 class="content-section-title">Jadwal Kunjungan Harian</h2>
        <div class="title-accent-line"></div>
        <p class="content-section-subtitle">
            Pilih hari dan waktu yang tersedia untuk mengajukan permintaan kunjungan Anda.
        </p>

        @if(session('success_kunjungan'))
            <div class="alert alert-success alert-dismissible fade show mb-4 mx-auto" role="alert" style="max-width: 600px;">
                {{ session('success_kunjungan') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any() && !session('open_modal_kunjungan_error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 mx-auto" role="alert" style="max-width: 600px;">
                Terdapat kesalahan pada input Anda. Silakan periksa kembali form permintaan kunjungan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="jadwal-harian-wrapper">
            <table class="jadwal-harian-table">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Buka</th>
                        <th>Jam Tutup</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daysOrder as $hariLoop)
                        @php
                            $jadwal = $jadwalHarianTampil[$hariLoop] ?? ['status' => 'Tutup', 'jam_buka' => '-', 'jam_tutup' => '-'];
                            $namaHariInggris = '';
                            switch (strtolower($hariLoop)) {
                                case 'senin': $namaHariInggris = 'Monday'; break;
                                case 'selasa': $namaHariInggris = 'Tuesday'; break;
                                case 'rabu': $namaHariInggris = 'Wednesday'; break;
                                case 'kamis': $namaHariInggris = 'Thursday'; break;
                                case 'jumat': $namaHariInggris = 'Friday'; break;
                                case 'sabtu': $namaHariInggris = 'Saturday'; break;
                                case 'minggu': $namaHariInggris = 'Sunday'; break;
                                default: $namaHariInggris = 'Monday'; // Fallback
                            }

                            $carbonHariIni = \Carbon\Carbon::now(config('app.timezone'));
                            // Mulai minggu dari Senin
                            $carbonTargetHari = \Carbon\Carbon::now(config('app.timezone'))->startOfWeek(\Carbon\Carbon::MONDAY)->modify('this ' . $namaHariInggris);

                            // Jika hari target sudah lewat di minggu ini (dan bukan hari ini), atau jika hari ini adalah hari target tapi sudah lewat jam tutupnya
                            if ( ($carbonTargetHari->lt($carbonHariIni->copy()->startOfDay()) && !$carbonTargetHari->isSameDay($carbonHariIni)) ||
                                 ($carbonTargetHari->isSameDay($carbonHariIni) && $jadwal['jam_tutup'] != '-' && $carbonHariIni->gt(\Carbon\Carbon::parse($jadwal['jam_tutup'], config('app.timezone'))))
                               ) {
                                $carbonTargetHari->addWeek();
                            }
                            $tanggalUntukForm = $carbonTargetHari->toDateString();
                        @endphp
                        <tr>
                            <td class="day-name">{{ $hariLoop }}</td>
                            <td class="time-text">{{ $jadwal['jam_buka'] }}</td>
                            <td class="time-text">{{ $jadwal['jam_tutup'] }}</td>
                            <td>
                                @if($jadwal['status'] === 'Buka')
                                    <span class="status-badge status-open">Buka</span>
                                @else
                                    <span class="status-badge status-closed">Tutup</span>
                                @endif
                            </td>
                            <td>
                                @if($jadwal['status'] === 'Buka')
                                    <button type="button" class="btn btn-ajukan-kunjungan"
                                            data-bs-toggle="modal" data-bs-target="#modalPermintaanKunjungan"
                                            data-hari="{{ $hariLoop }}"
                                            data-tanggal="{{ $tanggalUntukForm }}"
                                            data-jam-buka="{{ $jadwal['jam_buka'] }}"
                                            data-jam-tutup="{{ $jadwal['jam_tutup'] }}">
                                        <i class="fas fa-calendar-plus"></i> Ajukan
                                    </button>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- JADWAL KHUSUS SECTION -->
<section class="operasional-page-section jadwal-khusus-section">
    <div class="section-container">
        <h2 class="content-section-title">Informasi Jadwal Khusus</h2>
        <div class="title-accent-line"></div>
        <p class="content-section-subtitle">
            Perhatikan adanya perubahan jadwal pada hari-hari tertentu atau selama acara khusus berlangsung.
        </p>

        @if(isset($jadwalKhusus) && $jadwalKhusus->isNotEmpty())
            <div class="special-schedule-grid">
                @foreach($jadwalKhusus as $khusus)
                    <div class="special-card">
                        <div class="special-card-header">
                            <div class="special-date-info">
                                <div class="date-display">{{ \Carbon\Carbon::parse($khusus->tanggal)->format('d') }}</div>
                                <div class="month-year-display">{{ \Carbon\Carbon::parse($khusus->tanggal)->isoFormat('MMMM YYYY') }}</div>
                            </div>
                            <div class="special-event-details">
                                <h3 class="special-event-name">{{ $khusus->nama_acara_libur }}</h3>
                                <p class="special-event-day">{{ \Carbon\Carbon::parse($khusus->tanggal)->isoFormat('dddd') }}</p>
                            </div>
                        </div>
                        <div class="special-info-item">
                            <span class="special-info-label">Status</span>
                            <span class="special-info-value">
                                <span class="status-badge
                                    {{ $khusus->status_operasional == 'Buka' ? 'status-open' :
                                      ($khusus->status_operasional == 'Tutup' ? 'status-closed' : 'status-special') }}">
                                    {{ $khusus->status_operasional }}
                                </span>
                            </span>
                        </div>
                        @if($khusus->status_operasional == 'Jam Khusus' && $khusus->jam_buka_khusus && $khusus->jam_tutup_khusus)
                            <div class="special-info-item">
                                <span class="special-info-label">Waktu Khusus</span>
                                <span class="special-info-value">
                                    {{ formatJam($khusus->jam_buka_khusus) }} - {{ formatJam($khusus->jam_tutup_khusus) }}
                                </span>
                            </div>
                        @endif
                        @if($khusus->keterangan)
                            <div class="special-info-item keterangan-item">
                                <span class="special-info-label">Keterangan:</span>
                                <p class="special-info-value keterangan-text">{{ $khusus->keterangan }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state-container">
                <div class="icon">🎉</div>
                <h3>Tidak Ada Jadwal Khusus</h3>
                <p>Saat ini, semua layanan berjalan sesuai jadwal harian reguler.</p>
            </div>
        @endif
    </div>
</section>

{{-- MODAL UNTUK FORM PERMINTAAN KUNJUNGAN --}}
<div class="modal fade" id="modalPermintaanKunjungan" tabindex="-1" aria-labelledby="modalPermintaanKunjunganLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('public.kunjungan.store') }}" method="POST" id="formPermintaanKunjungan">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPermintaanKunjunganLabel">Formulir Permintaan Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any() && session('open_modal_kunjungan_error'))
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="mb-3">Anda mengajukan kunjungan untuk hari: <strong id="detailHariKunjungan"></strong>
                        <br><small class="text-muted">(Estimasi tanggal: <strong id="detailTanggalKunjungan"></strong>)</small>
                    </p>

                    <input type="hidden" name="hari_kunjungan_pilihan" id="formHariKunjungan">
                    {{-- <input type="hidden" name="tanggal_rencana_kunjungan_default" id="formTanggalKunjunganDefault"> --}}
                    <input type="hidden" name="jam_buka_pilihan" id="formJamBukaPilihan">
                    <input type="hidden" name="jam_tutup_pilihan" id="formJamTutupPilihan">

                    <div class="mb-3">
                        <label for="nama_pengunjung_modal" class="form-label">Nama Lengkap Anda <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_pengunjung') is-invalid @enderror" id="nama_pengunjung_modal" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" required>
                        @error('nama_pengunjung') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kontak_whatsapp_modal" class="form-label">Nomor WhatsApp</label>
                            <input type="tel" class="form-control @error('kontak_whatsapp') is-invalid @enderror" id="kontak_whatsapp_modal" name="kontak_whatsapp" value="{{ old('kontak_whatsapp') }}" placeholder="Contoh: 08123xxxx">
                             @error('kontak_whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email_pengunjung_modal" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control @error('email_pengunjung') is-invalid @enderror" id="email_pengunjung_modal" name="email_pengunjung" value="{{ old('email_pengunjung') }}" placeholder="Contoh: nama@email.com">
                            @error('email_pengunjung') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <small class="form-text text-muted d-block mb-3">Mohon isi salah satu kontak (WhatsApp atau Email) agar kami dapat menghubungi Anda.</small>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_rencana_kunjungan_modal" class="form-label">Pilih Tanggal Kunjungan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_rencana_kunjungan') is-invalid @enderror" id="tanggal_rencana_kunjungan_modal" name="tanggal_rencana_kunjungan" value="{{ old('tanggal_rencana_kunjungan') }}" required>
                            @error('tanggal_rencana_kunjungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted">Pastikan tanggal sesuai dengan hari yang Anda pilih.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jam_rencana_kunjungan_modal" class="form-label">Perkiraan Jam Kunjungan <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('jam_rencana_kunjungan') is-invalid @enderror" id="jam_rencana_kunjungan_modal" name="jam_rencana_kunjungan" value="{{ old('jam_rencana_kunjungan') }}" required>
                            @error('jam_rencana_kunjungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted">Pilih jam antara <strong id="rentangJamBukaModal"></strong> - <strong id="rentangJamTutupModal"></strong>.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan_pengunjung_modal" class="form-label">Catatan Tambahan (Opsional)</label>
                        <textarea class="form-control @error('catatan_pengunjung') is-invalid @enderror" id="catatan_pengunjung_modal" name="catatan_pengunjung" rows="3" placeholder="Misal: Tujuan kunjungan, jumlah orang, dll.">{{ old('catatan_pengunjung') }}</textarea>
                        @error('catatan_pengunjung') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div id="kontakFormErrorMessageModal" class="alert alert-danger" style="display: none;">
                        Mohon isi Nomor WhatsApp atau Alamat Email.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-submit-kunjungan">
                        <i class="fas fa-paper-plane"></i> Kirim Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Variabel ini akan di-set oleh PHP Blade untuk menandakan apakah modal harus terbuka karena error
const openModalOnError = {{ (session('open_modal_kunjungan_error') && $errors->any()) ? 'true' : 'false' }};
// const openModalOnError = false;


document.addEventListener('DOMContentLoaded', function() {
    // --- Script untuk efek fade-in section (sudah bagus) ---
    const observerOptions = { threshold: 0.1 };
    const sectionObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('is-visible');
        });
    }, observerOptions);
    document.querySelectorAll('.operasional-page-section').forEach(section => sectionObserver.observe(section));

    // --- Script untuk Modal Permintaan Kunjungan ---
    const modalPermintaanKunjunganEl = document.getElementById('modalPermintaanKunjungan');
    const formPermintaanKunjungan = document.getElementById('formPermintaanKunjungan');

    if (modalPermintaanKunjunganEl && formPermintaanKunjungan) {
        const modalInstance = new bootstrap.Modal(modalPermintaanKunjunganEl);

        modalPermintaanKunjunganEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Tombol yang memicu modal

            // 1. Reset form dan error JIKA modal dibuka oleh klik tombol baru (bukan karena error server)
            // Jika 'openModalOnError' true, berarti kita tidak boleh reset karena ada error server & old values.
            if (button && !openModalOnError) {
                formPermintaanKunjungan.reset(); // Reset nilai input standar
                formPermintaanKunjungan.querySelectorAll('.form-control.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                formPermintaanKunjungan.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

                const kontakErrorMsg = document.getElementById('kontakFormErrorMessageModal');
                if (kontakErrorMsg) kontakErrorMsg.style.display = 'none';

                // Hapus alert error dari server yang mungkin masih ada dari load sebelumnya (jika ada)
                const serverErrorAlertInModal = modalPermintaanKunjunganEl.querySelector('.modal-body > .alert.alert-danger:not(#kontakFormErrorMessageModal)');
                if (serverErrorAlertInModal) {
                    serverErrorAlertInModal.remove();
                }
            }

            // 2. Isi data ke modal JIKA dibuka oleh klik tombol
            if (button) {
                const hari = button.dataset.hari;
                const tanggalDefault = button.dataset.tanggal;
                const jamBuka = button.dataset.jamBuka;
                const jamTutup = button.dataset.jamTutup;

                document.getElementById('detailHariKunjungan').textContent = hari;
                document.getElementById('detailTanggalKunjungan').textContent = formatDateReadable(tanggalDefault);
                document.getElementById('formHariKunjungan').value = hari;
                document.getElementById('formJamBukaPilihan').value = jamBuka;
                document.getElementById('formJamTutupPilihan').value = jamTutup;

                const inputTanggalRencana = document.getElementById('tanggal_rencana_kunjungan_modal');
                // Hanya set tanggal default jika tidak ada old value (dari error server)
                // Jika ada old('tanggal_rencana_kunjungan'), Laravel sudah mengisinya.
                if (!inputTanggalRencana.value && tanggalDefault) {
                    inputTanggalRencana.value = tanggalDefault;
                }

                const todayForMinDate = new Date();
                todayForMinDate.setHours(0, 0, 0, 0);
                inputTanggalRencana.min = todayForMinDate.toISOString().split('T')[0];

                document.getElementById('rentangJamBukaModal').textContent = jamBuka;
                document.getElementById('rentangJamTutupModal').textContent = jamTutup;

                const inputJamRencana = document.getElementById('jam_rencana_kunjungan_modal');
                if (jamBuka) inputJamRencana.min = jamBuka;
                if (jamTutup) inputJamRencana.max = jamTutup;
            }

            // 3. Jika modal dibuka karena error server (openModalOnError === true)
            // Laravel `old()` akan mengisi field input utama.
            // Kita mungkin perlu mengisi ulang field non-input seperti 'detailHariKunjungan', 'rentangJamBukaModal', dll.
            // berdasarkan nilai `old()` dari field hidden.
            if (openModalOnError) {
                const oldHari = document.getElementById('formHariKunjungan').value; // Diisi oleh old()
                const oldJamBuka = document.getElementById('formJamBukaPilihan').value; // Diisi oleh old()
                const oldJamTutup = document.getElementById('formJamTutupPilihan').value; // Diisi oleh old()
                const oldTanggalRencana = document.getElementById('tanggal_rencana_kunjungan_modal').value; // Diisi oleh old()

                if(oldHari) document.getElementById('detailHariKunjungan').textContent = oldHari;
                if(oldTanggalRencana) document.getElementById('detailTanggalKunjungan').textContent = formatDateReadable(oldTanggalRencana);

                if(oldJamBuka) document.getElementById('rentangJamBukaModal').textContent = oldJamBuka;
                if(oldJamTutup) document.getElementById('rentangJamTutupModal').textContent = oldJamTutup;

                // Set ulang batasan min/max untuk tanggal dan jam jika ada old values
                const inputTanggalRencana = document.getElementById('tanggal_rencana_kunjungan_modal');
                const todayForMinDate = new Date();
                todayForMinDate.setHours(0, 0, 0, 0);
                inputTanggalRencana.min = todayForMinDate.toISOString().split('T')[0];

                const inputJamRencana = document.getElementById('jam_rencana_kunjungan_modal');
                if (oldJamBuka) inputJamRencana.min = oldJamBuka;
                if (oldJamTutup) inputJamRencana.max = oldJamTutup;
            }
        });

        modalPermintaanKunjunganEl.addEventListener('hidden.bs.modal', function () {
            // Saat modal ditutup, pastikan pesan error kontak custom JS disembunyikan.
            const kontakErrorMsg = document.getElementById('kontakFormErrorMessageModal');
            if (kontakErrorMsg) kontakErrorMsg.style.display = 'none';

            // Jika modal ditutup dan ada error dari server (openModalOnError = true),
            // kita ingin menghapus alert error Laravel agar tidak muncul lagi jika modal dibuka untuk entri baru
            // sebelum halaman di-refresh.
            // Namun, ini akan dihapus di 'show.bs.modal' jika `!openModalOnError` jadi tidak perlu di sini.

            // Penting: Setelah modal ditutup, jika sebelumnya ada error server (openModalOnError true),
            // kita perlu "menonaktifkan" flag openModalOnError di sisi klien, karena
            // error tersebut sudah "dikonsumsi". Jika tidak, pembukaan modal berikutnya (tanpa error baru)
            // akan salah mengira masih ada error.
            // Ini HANYA JIKA Anda tidak melakukan full page reload setelah submit.
            // Jika ada redirect (seperti pada error Laravel), variabel PHP akan di-reset. Jadi ini tidak selalu perlu.
            // openModalOnError = false; // Komentari jika tidak yakin, karena redirect Laravel akan menangani ini.
        });

        // Logika untuk membuka modal jika ada error dari backend (setelah redirect)
        if (openModalOnError) {
            modalInstance.show();
        }

        // --- Validasi Frontend untuk Kontak WA/Email sebelum Submit ---
        formPermintaanKunjungan.addEventListener('submit', function(event) {
            const kontakWaInput = document.getElementById('kontak_whatsapp_modal');
            const emailInput = document.getElementById('email_pengunjung_modal');
            const kontakErrorMsg = document.getElementById('kontakFormErrorMessageModal');

            const kontakWa = kontakWaInput ? kontakWaInput.value.trim() : '';
            const email = emailInput ? emailInput.value.trim() : '';

            let isClientValid = true;
            // Reset custom validation states
            if(kontakWaInput) kontakWaInput.classList.remove('is-invalid');
            if(emailInput) emailInput.classList.remove('is-invalid');
            if(kontakErrorMsg) kontakErrorMsg.style.display = 'none';

            if (kontakWa === '' && email === '') {
                if (kontakErrorMsg) kontakErrorMsg.style.display = 'block';
                if (kontakWaInput) kontakWaInput.classList.add('is-invalid');
                if (emailInput) emailInput.classList.add('is-invalid');
                isClientValid = false;
            }

            if (!isClientValid) {
                event.preventDefault(); // Hentikan submit form
                event.stopPropagation(); // Hentikan event bubbling lebih lanjut
            }
            // Validasi lain (required, format) akan ditangani oleh HTML5 dan validasi server.
        });
    }

    // --- Fungsi utilitas untuk format tanggal ---
    function formatDateReadable(dateString) {
        if (!dateString) return ''; // Kembalikan string kosong jika tidak ada
        try {
            // Asumsi dateString adalah YYYY-MM-DD dari PHP
            const dateParts = dateString.split('-');
            if (dateParts.length !== 3) { // Basic check
                console.warn("Invalid dateString format for formatDateReadable:", dateString);
                return dateString;
            }
            // Buat objek Date. Menggunakan Date.UTC untuk menghindari masalah timezone saat parsing YYYY-MM-DD.
            // Bulan di JS adalah 0-indexed.
            const date = new Date(Date.UTC(parseInt(dateParts[0]), parseInt(dateParts[1]) - 1, parseInt(dateParts[2])));

            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Asia/Jakarta' };
            return date.toLocaleDateString('id-ID', options);
        } catch (e) {
            console.error("Error formatting date:", dateString, e);
            return dateString; // Kembalikan string asli jika ada error
        }
    }
});
</script>
@endpush