{{-- resources/views/admin/operasional/khusus/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Jadwal Khusus')
@section('page-title', 'Tambah Jadwal Khusus')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Jadwal Operasional Khusus</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.operasional.khusus.store') }}" method="POST">
                        @csrf
                        @include('admin.operasional.khusus.partials._form', [
                            'jadwal' => null,
                            'buttonText' => 'Simpan Jadwal Khusus'
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