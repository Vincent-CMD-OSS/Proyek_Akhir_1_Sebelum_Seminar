{{-- resources/views/admin/operasional/khusus/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Jadwal Khusus')
@section('page-title', 'Edit Jadwal Khusus')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Jadwal Operasional Khusus: {{ $jadwalOperasionalKhusus->nama_acara_libur }} ({{ $jadwalOperasionalKhusus->tanggal->format('d M Y') }})</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.operasional.khusus.update', $jadwalOperasionalKhusus->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.operasional.khusus.partials._form', [
                            'jadwal' => $jadwalOperasionalKhusus,
                            'buttonText' => 'Update Jadwal Khusus'
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status_operasional_khusus');
    const jamBukaGroup = document.getElementById('jam-buka-khusus-group');
    const jamTutupGroup = document.getElementById('jam-tutup-khusus-group');

    function setVisibility(element, isVisible) {
        if (element) {
            element.style.display = isVisible ? 'block' : 'none';
        }
    }

    function toggleJamKhususFieldsBasedOnSelect() {
        const show = statusSelect ? statusSelect.value === 'Jam Khusus' : false;
        setVisibility(jamBukaGroup, show);
        setVisibility(jamTutupGroup, show);
    }

    // Atur visibilitas awal berdasarkan atribut data-*
    if (jamBukaGroup) {
        const initialVisibleBuka = jamBukaGroup.dataset.initialVisible === 'true';
        setVisibility(jamBukaGroup, initialVisibleBuka);
    }
    if (jamTutupGroup) {
        const initialVisibleTutup = jamTutupGroup.dataset.initialVisible === 'true';
        setVisibility(jamTutupGroup, initialVisibleTutup);
    }

    // Jika select ada, tambahkan event listener dan panggil toggle
    // untuk memastikan konsistensi jika nilai select berbeda dengan data-initial-visible (misal karena old input)
    if (statusSelect) {
        toggleJamKhususFieldsBasedOnSelect(); // Panggil sekali lagi untuk sinkronisasi dengan nilai select saat ini
        statusSelect.addEventListener('change', toggleJamKhususFieldsBasedOnSelect);
    }
});
</script>
@endpush