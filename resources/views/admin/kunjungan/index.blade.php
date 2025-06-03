@extends('layouts.admin')
@section('title', 'Kelola Permintaan Kunjungan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Permintaan Kunjungan</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    @if(session('link_whatsapp_konfirmasi'))
                        <br>
                        <a href="{{ session('link_whatsapp_konfirmasi') }}" target="_blank" class="btn btn-sm btn-success mt-2">
                            <i class="fab fa-whatsapp"></i> Kirim Konfirmasi via WhatsApp ke Pengunjung
                        </a>
                    @endif
                    {{-- Tambahkan tombol/info untuk email jika ada --}}
                    @if(session('email_info') && session('email_info')['tujuan'])
                        <div class="mt-2">
                            <p class="mb-1"><strong>Informasi Email untuk Pengunjung:</strong></p>
                            <p class="mb-0"><small><strong>Tujuan:</strong> {{ session('email_info')['tujuan'] }}</small></p>
                            <p class="mb-0"><small><strong>Subjek:</strong> {{ session('email_info')['subjek'] }}</small></p>
                            {{-- <p><small><strong>Isi Pesan (klik untuk salin):</strong> <br> <textarea readonly onclick="this.select(); document.execCommand('copy'); alert('Teks disalin!');" style="width:100%; height: 80px;">{{ strip_tags(str_replace('<br />', "\n", session('email_info')['isi'])) }}</textarea></small></p> --}}
                            {{-- Atau jika sudah kirim otomatis, beri pesan "Email notifikasi telah dikirim" --}}
                        </div>
                    @endif
                </div>
            @endif

            {{-- Form Filter --}}
            <form method="GET" action="{{ route('admin.kunjungan.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search_kunjungan" class="form-control form-control-sm" placeholder="Cari nama, WA, email..." value="{{ request('search_kunjungan') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status_filter" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status_filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status_filter') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status_filter') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="selesai" {{ request('status_filter') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                    </div>
                     <div class="col-md-2">
                        <a href="{{ route('admin.kunjungan.index') }}" class="btn btn-secondary btn-sm w-100">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengunjung</th>
                            <th>Kontak</th>
                            <th>Rencana Kunjungan</th>
                            <th>Status</th>
                            <th>Diproses Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permintaanKunjungan as $index => $permintaan)
                            <tr>
                                <td>{{ $permintaanKunjungan->firstItem() + $index }}</td>
                                <td>{{ $permintaan->nama_pengunjung }}</td>
                                <td>
                                    @if($permintaan->kontak_whatsapp)
                                        WA: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $permintaan->kontak_whatsapp) }}" target="_blank">{{ $permintaan->kontak_whatsapp }}</a><br>
                                    @endif
                                    @if($permintaan->email_pengunjung)
                                        Email: <a href="mailto:{{ $permintaan->email_pengunjung }}">{{ $permintaan->email_pengunjung }}</a>
                                    @endif
                                </td>
                                <td>
                                    {{ $permintaan->tanggal_rencana_kunjungan->isoFormat('dddd, D MMMM YYYY') }}
                                    <br>
                                    Jam: {{ \Carbon\Carbon::parse($permintaan->jam_rencana_kunjungan)->format('H:i') }}
                                </td>
                                <td>
                                    @if($permintaan->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($permintaan->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($permintaan->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($permintaan->status == 'selesai')
                                        <span class="badge bg-info">Selesai</span>
                                    @endif
                                </td>
                                <td>{{ $permintaan->diproses_pada ? $permintaan->diproses_pada->isoFormat('D MMM YYYY, HH:mm') : '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailKunjunganModal-{{ $permintaan->id }}">
                                        <i class="fas fa-eye"></i> Detail & Proses
                                    </button>
                                    {{-- Form Hapus --}}
                                    <form action="{{ route('admin.kunjungan.destroy', $permintaan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus permintaan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Detail & Proses untuk setiap item --}}
                            <div class="modal fade" id="detailKunjunganModal-{{ $permintaan->id }}" tabindex="-1" aria-labelledby="detailKunjunganModalLabel-{{ $permintaan->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailKunjunganModalLabel-{{ $permintaan->id }}">Detail Permintaan Kunjungan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.kunjungan.proses', $permintaan->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p><strong>Nama:</strong> {{ $permintaan->nama_pengunjung }}</p>
                                                <p><strong>WhatsApp:</strong> {{ $permintaan->kontak_whatsapp ?: '-' }}</p>
                                                <p><strong>Email:</strong> {{ $permintaan->email_pengunjung ?: '-' }}</p>
                                                <p><strong>Rencana Kunjungan:</strong> {{ $permintaan->tanggal_rencana_kunjungan->isoFormat('dddd, D MMMM YYYY') }} pukul {{ \Carbon\Carbon::parse($permintaan->jam_rencana_kunjungan)->format('H:i') }}</p>
                                                <p><strong>Catatan Pengunjung:</strong><br> {!! nl2br(e($permintaan->catatan_pengunjung ?: '-')) !!}</p>
                                                <hr>
                                                <p><strong>Status Saat Ini:</strong> <span class="fw-bold">{{ ucfirst($permintaan->status) }}</span></p>
                                                @if($permintaan->status === 'ditolak' && $permintaan->alasan_penolakan)
                                                    <p><strong>Alasan Penolakan Sebelumnya:</strong><br> {!! nl2br(e($permintaan->alasan_penolakan)) !!}</p>
                                                @endif
                                                @if($permintaan->catatan_admin)
                                                    <p><strong>Catatan Admin Sebelumnya:</strong><br> {!! nl2br(e($permintaan->catatan_admin)) !!}</p>
                                                @endif
                                                <hr>
                                                <h5>Tindakan:</h5>
                                                <div class="mb-3">
                                                    <label for="aksi-{{ $permintaan->id }}" class="form-label">Pilih Aksi <span class="text-danger">*</span></label>
                                                    <select name="aksi" id="aksi-{{ $permintaan->id }}" class="form-select" required onchange="toggleAlasanPenolakan(this, 'alasan_penolakan_group_{{ $permintaan->id }}')">
                                                        <option value="setujui" {{ $permintaan->status == 'disetujui' ? 'selected' : '' }}>Setujui Permintaan</option>
                                                        <option value="tolak" {{ $permintaan->status == 'ditolak' ? 'selected' : '' }}>Tolak Permintaan</option>
                                                        {{-- <option value="selesai">Tandai Selesai</option> --}}
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="alasan_penolakan_group_{{ $permintaan->id }}" style="{{ $permintaan->status == 'ditolak' || old('aksi') == 'tolak' ? '' : 'display: none;' }}">
                                                    <label for="alasan_penolakan-{{ $permintaan->id }}" class="form-label">Alasan Penolakan (jika ditolak) <span class="text-danger">*</span></label>
                                                    <textarea name="alasan_penolakan" id="alasan_penolakan-{{ $permintaan->id }}" class="form-control" rows="3">{{ old('alasan_penolakan', $permintaan->alasan_penolakan) }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="catatan_admin-{{ $permintaan->id }}" class="form-label">Catatan Admin (Opsional, akan disertakan di pesan)</label>
                                                    <textarea name="catatan_admin" id="catatan_admin-{{ $permintaan->id }}" class="form-control" rows="3">{{ old('catatan_admin', $permintaan->catatan_admin) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan & Proses</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada permintaan kunjungan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $permintaanKunjungan->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleAlasanPenolakan(selectElement, groupId) {
        const alasanGroup = document.getElementById(groupId);
        const alasanTextarea = alasanGroup.querySelector('textarea');
        if (selectElement.value === 'tolak') {
            alasanGroup.style.display = 'block';
            alasanTextarea.required = true;
        } else {
            alasanGroup.style.display = 'none';
            alasanTextarea.required = false;
        }
    }
     // Panggil saat load untuk old input
    document.querySelectorAll('select[name="aksi"]').forEach(select => {
         if(select.value === 'tolak'){
            toggleAlasanPenolakan(select, 'alasan_penolakan_group_' + select.id.split('-')[1] );
         }
    });
</script>
@endpush