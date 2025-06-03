{{-- resources/views/admin/operasional/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Jadwal Operasional')
@section('page-title', 'Jadwal Operasional')

@push('styles')
    <style>
        .table-actions form {
            display: inline-block;
            margin-left: 5px;
        }
        .jadwal-hari-blok + .jadwal-hari-blok {
            margin-top: 1.5rem;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Pesan Sukses/Error Global --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Navigasi Tab (Opsional, bisa juga dua card terpisah) --}}
    <ul class="nav nav-tabs mb-3" id="operasionalTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="harian-tab" data-bs-toggle="tab" data-bs-target="#harian-tab-pane" type="button" role="tab" aria-controls="harian-tab-pane" aria-selected="true">Jadwal Harian</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="khusus-tab" data-bs-toggle="tab" data-bs-target="#khusus-tab-pane" type="button" role="tab" aria-controls="khusus-tab-pane" aria-selected="false">Jadwal Khusus</button>
        </li>
    </ul>

    <div class="tab-content" id="operasionalTabContent" data-active-tab-session="{{ session('active_tab') }}">
        {{-- Tab Pane untuk Jadwal Harian --}}

        <div class="tab-pane fade show active" id="harian-tab-pane" role="tabpanel" aria-labelledby="harian-tab"> {{-- <--- PEMBUKA DIV UNTUK TAB HARIAN --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Jadwal Operasional Harian</h5>
                    {{-- Tombol tambah per slot mungkin tidak diperlukan lagi di sini --}}
                </div>
                <div class="card-body">
                    @if(session('success_harian'))
                        <div class="alert alert-success">{{ session('success_harian') }}</div>
                    @endif

                    {{-- Di dalam tab Jadwal Harian di admin.operasional.index.blade.php --}}
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam Buka Kunjungan</th>
                <th>Jam Tutup Kunjungan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daysOrder as $hari)
                @php
                    $jadwalEntry = $jadwalHarian[$hari] ?? null;
                    $isBuka = $jadwalEntry && $jadwalEntry->status_operasional === 'Buka';
                @endphp
                <tr>
                    <td><strong>{{ $hari }}</strong></td>
                    <td>{{ $isBuka && $jadwalEntry->jam_buka ? \Carbon\Carbon::parse($jadwalEntry->jam_buka)->format('H:i') : '-' }}</td>
                    <td>{{ $isBuka && $jadwalEntry->jam_tutup ? \Carbon\Carbon::parse($jadwalEntry->jam_tutup)->format('H:i') : '-' }}</td>
                    <td>
                        @if($isBuka)
                            <span class="badge bg-success">Buka</span>
                        @else
                            <span class="badge bg-danger">Tutup</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.operasional.harian.edit_or_create', ['hari' => strtolower($hari)]) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i> Atur
                        </a>
                        @if($jadwalEntry) {{-- Tampilkan tombol hapus hanya jika ada entri --}}
                        <form action="{{ route('admin.operasional.harian.destroy_by_day', ['hari' => strtolower($hari)]) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin mereset jadwal hari {{ $hari }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Reset
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
                </div>
            </div>
        </div>

        {{-- Tab Pane untuk Jadwal Khusus --}}
        <div class="tab-pane fade" id="khusus-tab-pane" role="tabpanel" aria-labelledby="khusus-tab">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Jadwal Operasional Khusus</h5>
                        <a href="{{ route('admin.operasional.khusus.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Jadwal Khusus
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($jadwalKhusus->isEmpty())
                        <div class="alert alert-info">Belum ada jadwal khusus yang ditambahkan.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Acara/Libur</th>
                                        <th>Status</th>
                                        <th>Jam Khusus</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwalKhusus as $khusus)
                                    <tr>
                                        <td>{{ $khusus->tanggal->format('d M Y') }} ({{ $khusus->tanggal->isoFormat('dddd') }})</td>
                                        <td>{{ $khusus->nama_acara_libur }}</td>
                                        <td>
                                            @if($khusus->status_operasional == 'Buka')
                                                <span class="badge bg-success">Buka</span>
                                            @elseif($khusus->status_operasional == 'Tutup')
                                                <span class="badge bg-danger">Tutup</span>
                                            @elseif($khusus->status_operasional == 'Jam Khusus')
                                                <span class="badge bg-info text-dark">Jam Khusus</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($khusus->status_operasional == 'Jam Khusus' && $khusus->jam_buka_khusus && $khusus->jam_tutup_khusus)
                                                {{ \Carbon\Carbon::parse($khusus->jam_buka_khusus)->format('H:i') }} - {{ \Carbon\Carbon::parse($khusus->jam_tutup_khusus)->format('H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $khusus->keterangan ?: '-' }}</td>
                                        <td class="table-actions">
                                            <a href="{{ route('admin.operasional.khusus.edit', $khusus->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.operasional.khusus.destroy', $khusus->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal khusus ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Pagination Links untuk Jadwal Khusus --}}
                        <div class="mt-3">
                            {{ $jadwalKhusus->appends(request()->except('khusus_page'))->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const operasionalTabContent = document.getElementById('operasionalTabContent'); // Ambil elemen dengan data-attribute
            var triggerTabList = [].slice.call(document.querySelectorAll('#operasionalTab button[data-bs-toggle="tab"]'));

            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl);
                triggerEl.addEventListener('click', function (event) {
                    localStorage.setItem('activeOperasionalTab', this.getAttribute('data-bs-target'));
                });
            });

            // Baca nilai dari atribut data-*
            const activeTabTargetFromSession = operasionalTabContent ? operasionalTabContent.dataset.activeTabSession : null;

            if (activeTabTargetFromSession && activeTabTargetFromSession !== '') { // Pastikan tidak string kosong juga
                const tabToActivate = document.querySelector('button[data-bs-target="' + activeTabTargetFromSession + '"]');
                if (tabToActivate) {
                    const tab = new bootstrap.Tab(tabToActivate);
                    tab.show();
                    localStorage.setItem('activeOperasionalTab', activeTabTargetFromSession);
                }
            } else {
                const activeTabFromStorage = localStorage.getItem('activeOperasionalTab');
                if (activeTabFromStorage) {
                    const someTabTriggerEl = document.querySelector('button[data-bs-target="' + activeTabFromStorage + '"]');
                    if (someTabTriggerEl) {
                        const tab = new bootstrap.Tab(someTabTriggerEl);
                        tab.show();
                    }
                }
            }
        });
    </script>
@endpush