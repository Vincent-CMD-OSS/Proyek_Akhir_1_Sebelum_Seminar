{{-- resources/views/admin/operasional/harian/atur.blade.php --}}
@extends('layouts.admin')

@section('title', 'Atur Jadwal Operasional Hari ' . $namaHariProper)
@section('page-title', 'Atur Jadwal Hari ' . $namaHariProper)

@push('styles')
<style>
    .slot-jadwal {
        border: 1px solid #eee;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .slot-jadwal .row > div {
        margin-bottom: 0.5rem; /* Sedikit spasi antar field dalam satu slot */
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Atur Slot Waktu untuk Hari: {{ $namaHariProper }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.operasional.harian.update.perhari', ['hari' => strtolower($namaHariProper)]) }}" method="POST">
                        @csrf

                        @php
                            $initialSlotCount = 0;
                            if (old('slots') && is_array(old('slots'))) {
                                $initialSlotCount = count(old('slots'));
                            } elseif (isset($jadwalSlots) && $jadwalSlots->isNotEmpty()) {
                                $initialSlotCount = $jadwalSlots->count();
                            } else {
                                // Jika tidak ada old input dan tidak ada data dari DB,
                                // berarti halaman ini akan merender 1 slot dari @include di @else.
                                // Maka, jumlah slot yang sudah ada adalah 1.
                                $initialSlotCount = 1;
                            }
                        @endphp

                        {{-- Simpan initialSlotCount sebagai data atribut --}}
                        <div id="slot-jadwal-container" data-initial-slot-count="{{ $initialSlotCount }}">
                            @if(old('slots') && is_array(old('slots')))
                                @foreach(old('slots') as $index => $slotData)
                                    @include('admin.operasional.harian.partials._slot_jadwal_item', [
                                        'index' => $index,
                                        'slot' => (object) $slotData
                                    ])
                                @endforeach
                            @elseif($jadwalSlots->isNotEmpty())
                                @foreach($jadwalSlots as $index => $slot)
                                    @include('admin.operasional.harian.partials._slot_jadwal_item', ['index' => $index, 'slot' => $slot])
                                @endforeach
                            @else
                                {{-- Render satu slot kosong jika tidak ada data & tidak ada old input --}}
                                @include('admin.operasional.harian.partials._slot_jadwal_item', ['index' => 0, 'slot' => null])
                            @endif
                        </div>

                        <button type="button" id="tambah-slot-btn" class="btn btn-success btn-sm mt-2">
                            <i class="fas fa-plus"></i> Tambah Slot Waktu
                        </button>

                        <hr>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan Jadwal {{ $namaHariProper }}</button>
                            <a href="{{ route('admin.operasional.index') }}" class="btn btn-secondary">Kembali ke Daftar Operasional</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Template untuk slot baru (disembunyikan, akan di-clone oleh JS) --}}
<div id="slot-jadwal-template" style="display: none;">
    @include('admin.operasional.harian.partials._slot_jadwal_item', ['index' => 'TEMPLATE_INDEX', 'slot' => null])
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('slot-jadwal-container');
    const addButton = document.getElementById('tambah-slot-btn');
    const template = document.getElementById('slot-jadwal-template');

    // Baca nilai awal dari atribut data-*
    // initialSlotCount adalah JUMLAH slot yang sudah dirender.
    // Index untuk slot berikutnya adalah initialSlotCount itu sendiri (jika array 0-indexed).
    let slotIndex = parseInt(container.dataset.initialSlotCount) || 0;
    // Jika initialSlotCount adalah 1 (karena ada 1 slot dengan index 0),
    // maka slotIndex untuk item BARU yang ditambahkan harus dimulai dari 1.
    // Jadi, jika initialSlotCount dari data-attribute adalah jumlah item yg sudah ada.

    // Jika container.children.length bisa diandalkan dan lebih akurat:
    // slotIndex = container.children.length;


    addButton.addEventListener('click', function () {
        const newSlotHtml = template.innerHTML.replace(/TEMPLATE_INDEX/g, slotIndex);
        const newSlotDiv = document.createElement('div');
        newSlotDiv.innerHTML = newSlotHtml;
        // Pastikan kita mengambil elemen slot-jadwal yang sebenarnya, bukan div pembungkus jika newSlotDiv.innerHTML hanya berisi slot-jadwal
        let actualNewSlotElement = newSlotDiv.querySelector('.slot-jadwal') || newSlotDiv.firstElementChild;
        if (actualNewSlotElement) {
            container.appendChild(actualNewSlotElement);
        }
        slotIndex++;
    });

    // Fungsi untuk menghapus slot
    container.addEventListener('click', function (event) {
        if (event.target.classList.contains('hapus-slot-btn') || event.target.closest('.hapus-slot-btn')) {
            event.preventDefault();
            const slotToRemove = event.target.closest('.slot-jadwal');
            if (slotToRemove) {
                slotToRemove.remove();
                // Kita tidak perlu decrement slotIndex di sini karena slotIndex
                // digunakan untuk GENERASI index BARU. Menghapus slot tidak mempengaruhi
                // nomor index yang akan digunakan untuk slot berikutnya.
            }
        }
    });
});
</script>
@endpush