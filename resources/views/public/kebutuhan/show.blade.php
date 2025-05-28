@extends('layouts.user') {{-- Sesuaikan dengan layout publik utama Anda --}}

@section('title', $kebutuhan->nama_kebutuhan . ' - ' . ($identitasPanti->nama_panti ?? 'Rumah Harapan'))

@push('styles')
<style>
    body { background-color: #f8f9fa; font-family: 'Arial', sans-serif; color: #333; }
    .kebutuhan-detail-container { max-width: 900px; margin: 40px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
    .kebutuhan-header { margin-bottom: 30px; }
    .kebutuhan-header h1 { font-size: 2.5rem; color: #007bff; margin-bottom: 15px; }
    .kebutuhan-image-container { margin-bottom: 30px; text-align: center; }
    .kebutuhan-image-container img {
        max-width: 100%;
        max-height: 450px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        object-fit: cover;
    }
    .kebutuhan-image-placeholder {
        width: 100%;
        height: 300px;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 1.5rem;
        border-radius: 8px;
    }
    .kebutuhan-info { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; padding-bottom: 25px; border-bottom: 1px solid #eee; flex-wrap: wrap; }
    .info-item { margin-bottom: 10px; font-size: 1rem; color: #555;}
    .info-item strong { color: #333; }
    .kebutuhan-progress-detail { margin-bottom: 30px; }
    .progress-bar-container { background-color: #e9ecef; border-radius: .25rem; height: 12px; overflow: hidden; margin-top:5px; }
    .progress-bar-fill { background-color: #28a745; height: 100%; width: 0%; transition: width 0.5s ease-in-out; border-radius: .25rem;}
    .progress-text { font-size: 0.9rem; color: #444; display: flex; justify-content: space-between; margin-bottom: 3px;}
    .progress-text strong { color: #17a2b8; }
    .kebutuhan-deskripsi { font-size: 1.05rem; line-height: 1.7; color: #444; margin-bottom: 30px; }
    .kebutuhan-deskripsi h2, .kebutuhan-deskripsi h3 { color: #0056b3; margin-top: 20px; }
    .kebutuhan-deskripsi p { margin-bottom: 1em; }
    .kebutuhan-deskripsi ul, .kebutuhan-deskripsi ol { padding-left: 20px; margin-bottom: 1em; }
    .btn-donasi-detail {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 12px 30px;
        font-size: 1.1rem;
        font-weight: bold;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.2s ease;
        text-align: center;
        margin-top: 20px;
        border: none;
    }
    .btn-donasi-detail:hover { background-color: #1e7e34; }
    .action-buttons { text-align: center; margin-top: 20px; }

    .kebutuhan-lainnya-section { margin-top: 50px; padding-top: 30px; border-top: 1px solid #e0e0e0;}
    .kebutuhan-lainnya-section h2 { text-align: center; font-size: 1.8rem; color: #007bff; margin-bottom: 25px;}
    .kebutuhan-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
    .kebutuhan-card-small { /* Mirip .kebutuhan-card tapi mungkin lebih kecil */
        background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); overflow: hidden;
        display: flex; flex-direction: column; transition: transform 0.2s ease;
    }
    .kebutuhan-card-small:hover { transform: translateY(-3px); }
    .kebutuhan-card-small img { width: 100%; height: 150px; object-fit: cover; }
    .kebutuhan-card-small .kebutuhan-card-placeholder { height: 150px; font-size: 1rem;}
    .kebutuhan-card-small .kebutuhan-card-content { padding: 15px; text-align: left;}
    .kebutuhan-card-small h4 { font-size: 1.1rem; margin:0 0 8px 0; color: #0056b3;}
    .kebutuhan-card-small h4 a { color: inherit; text-decoration: none; }
    .kebutuhan-card-small .btn-sm-detail { font-size: 0.8rem; padding: 5px 10px; background-color: #007bff; color:white; border-radius: 3px; text-decoration: none; display: inline-block; margin-top:10px;}
</style>
@endpush

@section('content')
<div class="kebutuhan-detail-container">
    <div class="kebutuhan-header">
        <h1>{{ $kebutuhan->nama_kebutuhan }}</h1>
    </div>

    @if($kebutuhan->gambar_kebutuhan)
    <div class="kebutuhan-image-container">
        <img src="{{ Storage::url($kebutuhan->gambar_kebutuhan) }}" alt="{{ $kebutuhan->nama_kebutuhan }}">
    </div>
    @else
    <div class="kebutuhan-image-placeholder">
        <span>Gambar Tidak Tersedia</span>
    </div>
    @endif

    <div class="kebutuhan-info">
        <div class="info-block">
            @if($kebutuhan->tanggal_mulai_dipublikasikan)
            <div class="info-item">
                Dipublikasikan: <strong>{{ $kebutuhan->tanggal_mulai_dipublikasikan->isoFormat('D MMMM YYYY') }}</strong>
            </div>
            @endif
            @if($kebutuhan->tanggal_target_tercapai)
            <div class="info-item">
                Target Tercapai: <strong>{{ $kebutuhan->tanggal_target_tercapai->isoFormat('D MMMM YYYY') }}</strong>
                @if($kebutuhan->sisa_hari !== null)
                <span class="text-muted"> (Sisa {{ $kebutuhan->sisa_hari }} hari)</span>
                @endif
            </div>
            @endif
        </div>
    </div>

    @if($kebutuhan->target_dana > 0)
    <div class="kebutuhan-progress-detail">
        <div class="progress-text">
            <span>Terkumpul: <strong>Rp {{ number_format($kebutuhan->dana_terkumpul, 0, ',', '.') }}</strong></span>
            <span>{{ number_format($kebutuhan->persentase_terkumpul, 0) }}%</span>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar-fill" style="width: {{ $kebutuhan->persentase_terkumpul }}%;"></div>
        </div>
        <div class="progress-text" style="margin-top: 5px;">
             <span>Target Donasi: Rp {{ number_format($kebutuhan->target_dana, 0, ',', '.') }}</span>
        </div>
    </div>
    @endif

    <div class="kebutuhan-deskripsi">
        <h2>Deskripsi Kebutuhan</h2>
        {!! $kebutuhan->deskripsi !!} {{-- Hati-hati dengan XSS jika deskripsi dari WYSIWYG editor. Pertimbangkan strip_tags atau Purifier --}}
    </div>

    <div class="action-buttons">
        <a href="{{ route('public.donasi.index', ['kebutuhan_id' => $kebutuhan->id, 'nama_kebutuhan' => $kebutuhan->nama_kebutuhan]) }}" class="btn-donasi-detail">
            Donasi Untuk Kebutuhan Ini
        </a>
    </div>

    @if($kebutuhanLainnya->isNotEmpty())
    <section class="kebutuhan-lainnya-section">
        <h2>Kebutuhan Mendesak Lainnya</h2>
        <div class="kebutuhan-grid">
            @foreach($kebutuhanLainnya as $itemLain)
            <div class="kebutuhan-card-small">
                <a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}">
                    @if($itemLain->gambar_kebutuhan)
                    <img src="{{ Storage::url($itemLain->gambar_kebutuhan) }}" alt="{{ $itemLain->nama_kebutuhan }}">
                    @else
                    <div class="kebutuhan-card-placeholder"><span>No Image</span></div>
                    @endif
                </a>
                <div class="kebutuhan-card-content">
                    <h4><a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}">{{ Str::limit($itemLain->nama_kebutuhan, 40) }}</a></h4>
                    @if($itemLain->target_dana > 0)
                        <small>Target: Rp {{ number_format($itemLain->target_dana, 0, ',', '.') }}</small><br>
                    @endif
                    <a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}" class="btn-sm-detail">Lihat</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // Script untuk animasi progress bar jika diperlukan
    document.addEventListener('DOMContentLoaded', function () {
        const progressBar = document.querySelector('.progress-bar-fill');
        if(progressBar){
            const width = progressBar.style.width;
            progressBar.style.width = '0%'; // Reset dulu
            setTimeout(() => {
                progressBar.style.width = width;
            }, 100);
        }
    });
</script>
@endpush