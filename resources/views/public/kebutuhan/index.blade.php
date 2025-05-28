@extends('layouts.user') {{-- Sesuaikan dengan layout publik utama Anda --}}

@section('title', 'Kebutuhan Panti - ' . ($identitasPanti->nama_panti ?? 'Rumah Harapan'))

@push('styles')
<style>
    body { background-color: #f4f7f6; font-family: 'Arial', sans-serif; color: #333; }
    .kebutuhan-container { max-width: 1200px; margin: 40px auto; padding: 0 15px; }
    .page-header-kebutuhan {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e0e0e0;
    }
    .page-header-kebutuhan h1 { font-size: 2.8rem; color: #007bff; /* Biru primer */ margin-bottom: 0.5rem; }
    .page-header-kebutuhan p { font-size: 1.1rem; color: #555; }

    .kebutuhan-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px; }
    .kebutuhan-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .kebutuhan-card:hover { transform: translateY(-5px); box-shadow: 0 6px 20px rgba(0,0,0,0.12); }
    .kebutuhan-card-img img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }
    .kebutuhan-card-placeholder {
        width: 100%;
        height: 200px;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 1.2rem;
        border-bottom: 1px solid #eee;
    }
    .kebutuhan-card-content { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .kebutuhan-card-content h3 { font-size: 1.4rem; margin-top: 0; margin-bottom: 10px; color: #0056b3; }
    .kebutuhan-card-content h3 a { color: inherit; text-decoration: none; }
    .kebutuhan-card-content h3 a:hover { text-decoration: underline; }
    .kebutuhan-card-content .deskripsi-singkat { font-size: 0.95rem; color: #666; margin-bottom: 15px; line-height: 1.5; flex-grow: 1; }
    .kebutuhan-progress { margin-bottom: 15px; }
    .progress-bar-container { background-color: #e9ecef; border-radius: .25rem; height: 10px; overflow: hidden; margin-top:5px; }
    .progress-bar-fill { background-color: #28a745; /* Hijau untuk progres */ height: 100%; width: 0%; transition: width 0.5s ease-in-out; border-radius: .25rem; }
    .progress-text { font-size: 0.85rem; color: #444; display: flex; justify-content: space-between; margin-bottom: 3px;}
    .dana-info { font-size: 0.9rem; margin-bottom: 5px; }
    .dana-info strong { color: #17a2b8; } /* Biru kehijauan untuk dana */
    .kebutuhan-card-footer { padding: 15px 20px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; background-color: #f8f9fa; }
    .btn-detail, .btn-donasi {
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: background-color 0.2s ease;
        text-align: center;
    }
    .btn-detail { background-color: #007bff; color: white; border: 1px solid #007bff;}
    .btn-detail:hover { background-color: #0056b3; }
    .btn-donasi { background-color: #28a745; color: white; border: 1px solid #28a745;}
    .btn-donasi:hover { background-color: #1e7e34; }
    .pagination-wrapper { margin-top: 40px; display: flex; justify-content: center; }
    .no-kebutuhan {
        text-align: center;
        padding: 50px 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .no-kebutuhan p { font-size: 1.2rem; color: #555; }

    /* Search form */
    .search-form-container {
        margin-bottom: 30px;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .search-form-container form {
        display: flex;
        gap: 10px;
    }
    .search-form-container .form-control {
        flex-grow: 1;
        padding: .75rem 1rem;
        font-size: 1rem;
        border: 1px solid #ced4da;
        border-radius: .25rem;
    }
    .search-form-container .btn-search {
        padding: .75rem 1.5rem;
        font-size: 1rem;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: .25rem;
        cursor: pointer;
    }
    .search-form-container .btn-search:hover {
        background-color: #0056b3;
    }

</style>
@endpush

@section('content')
<div class="kebutuhan-container">
    <div class="page-header-kebutuhan">
        <h1>Kebutuhan Panti Asuhan</h1>
        <p>Bantu kami memenuhi kebutuhan anak-anak di {{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }}. Setiap dukungan Anda sangat berarti.</p>
    </div>

    {{-- Formulir Pencarian --}}
    <div class="search-form-container">
        <form action="{{ route('public.kebutuhan.index') }}" method="GET">
            <input type="text" name="search" class="form-control" placeholder="Cari kebutuhan..." value="{{ request('search') }}">
            <button type="submit" class="btn-search">Cari</button>
        </form>
    </div>

    @if($kebutuhanItems->isNotEmpty())
        <div class="kebutuhan-grid">
            @foreach($kebutuhanItems as $item)
            <div class="kebutuhan-card">
                @if($item->gambar_kebutuhan)
                <a href="{{ route('public.kebutuhan.show', $item->slug) }}" class="kebutuhan-card-img">
                    <img src="{{ Storage::url($item->gambar_kebutuhan) }}" alt="{{ $item->nama_kebutuhan }}">
                </a>
                @else
                <a href="{{ route('public.kebutuhan.show', $item->slug) }}" class="kebutuhan-card-placeholder">
                    <span>Tidak Ada Gambar</span>
                </a>
                @endif
                <div class="kebutuhan-card-content">
                    <h3><a href="{{ route('public.kebutuhan.show', $item->slug) }}">{{ $item->nama_kebutuhan }}</a></h3>
                    <p class="deskripsi-singkat">{{ Str::limit(strip_tags($item->deskripsi), 120) }}</p>

                    @if($item->target_dana > 0)
                    <div class="kebutuhan-progress">
                        <div class="progress-text">
                            <span>Terkumpul: <strong>Rp {{ number_format($item->dana_terkumpul, 0, ',', '.') }}</strong></span>
                            <span>{{ number_format($item->persentase_terkumpul, 0) }}%</span>
                        </div>
                        <div class="progress-bar-container">
                            <div class="progress-bar-fill" style="width: {{ $item->persentase_terkumpul }}%;"></div>
                        </div>
                        <div class="progress-text" style="margin-top: 5px;">
                             <span>Target: Rp {{ number_format($item->target_dana, 0, ',', '.') }}</span>
                             @if($item->sisa_hari !== null)
                             <span class="text-muted"><small>{{ $item->sisa_hari }} hari lagi</small></span>
                             @endif
                        </div>
                    </div>
                    @else
                    <div class="dana-info">
                        <p>Kebutuhan non-dana atau target belum ditentukan.</p>
                    </div>
                    @endif
                </div>
                <div class="kebutuhan-card-footer">
                    <a href="{{ route('public.kebutuhan.show', $item->slug) }}" class="btn-detail">Lihat Detail</a>
                    {{-- Tombol Donasi mengarah ke halaman donasi dengan parameter --}}
                    <a href="{{ route('public.donasi.index', ['kebutuhan_id' => $item->id, 'nama_kebutuhan' => $item->nama_kebutuhan]) }}" class="btn-donasi">Donasi Sekarang</a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $kebutuhanItems->appends(request()->query())->links() }} {{-- appends() untuk menjaga parameter search saat paginasi --}}
        </div>
    @else
        <div class="no-kebutuhan">
            <p>Saat ini belum ada kebutuhan mendesak yang dipublikasikan atau sesuai pencarian Anda.</p>
            <p>Silakan cek kembali nanti atau <a href="{{ route('public.donasi.index') }}">berdonasi secara umum</a>.</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Script untuk animasi progress bar jika diperlukan
    document.addEventListener('DOMContentLoaded', function () {
        const progressBars = document.querySelectorAll('.progress-bar-fill');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%'; // Reset dulu agar animasi terlihat
            setTimeout(() => {
                bar.style.width = width;
            }, 100);
        });
    });
</script>
@endpush