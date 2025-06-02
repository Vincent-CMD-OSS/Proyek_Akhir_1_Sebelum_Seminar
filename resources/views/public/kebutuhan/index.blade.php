@extends('layouts.user') {{-- Sesuaikan dengan layout publik utama Anda --}}

@section('title', 'Kebutuhan Panti - ' . ($identitasPanti->nama_panti ?? 'Rumah Harapan'))

@push('styles')
<style>
    body { 
    background-color: #f4f7f6; 
    font-family: 'Arial', sans-serif; 
    color: #333;
    margin: 0;
    padding: 0;
}

/* Hero Section dengan Background Image Full Screen */
.hero-section {
    height: 115vh;
    width: 100vw;
    background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)), 
                      url('/assets/images/ttg kami.jpg');
    background-size: cover;
    background-position: center center;
    background-attachment: fixed;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    margin: 0;
    padding: 0;
}

/* Animasi background parallax */
.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(0, 123, 255, 0.1), rgba(40, 167, 69, 0.1));
    animation: heroOverlay 8s ease-in-out infinite alternate;
}

@keyframes heroOverlay {
    0% { opacity: 0.3; }
    100% { opacity: 0.6; }
}

.hero-content {
    text-align: center;
    color: white;
    z-index: 2;
    position: relative;
    max-width: 800px;
    padding: 0 20px;
    animation: heroFadeIn 2s ease-out;
}

@keyframes heroFadeIn {
    0% { opacity: 0; transform: translateY(50px); }
    100% { opacity: 1; transform: translateY(0); }
}

.hero-content h1 {
    font-size: 4rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
    letter-spacing: 2px;
    line-height: 1.2;
    color: white;
    animation: titleGlow 3s ease-in-out infinite alternate;
}

@keyframes titleGlow {
    0% { text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7); }
    100% { text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7), 0 0 20px rgba(255, 255, 255, 0.3); }
}

.hero-content p {
    font-size: 1.4rem;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
    line-height: 1.6;
    opacity: 0.95;
    color: white;
}

.hero-scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    text-align: center;
    animation: bounce 2s infinite;
    cursor: pointer;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
    40% { transform: translateX(-50%) translateY(-10px); }
    60% { transform: translateX(-50%) translateY(-5px); }
}

.hero-scroll-indicator i {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

/* Main Content Section */
.main-content {
    background-color: #f4f7f6;
    position: relative;
    z-index: 3;
    margin-top: -100px;
    padding-top: 100px;
}

.kebutuhan-container { 
    max-width: 1200px; 
    margin: 0 auto; 
    padding: 40px 15px;
    position: relative;
}

/* Search form */
.search-form-container {
    margin-bottom: 40px;
    padding: 30px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
    transform: translateY(0);
    animation: contentSlideUp 1s ease-out 0.5s backwards;
}

@keyframes contentSlideUp {
    0% { opacity: 0; transform: translateY(50px); }
    100% { opacity: 1; transform: translateY(0); }
}

.search-form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #007bff, #28a745, #17a2b8);
    background-size: 300% 100%;
    animation: searchGradient 4s ease-in-out infinite;
}

@keyframes searchGradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.search-form-container form {
    display: flex;
    gap: 15px;
    align-items: center;
}

.search-form-container .form-control {
    flex-grow: 1;
    padding: 15px 25px;
    font-size: 1.1rem;
    border: 2px solid rgba(206, 212, 218, 0.3);
    border-radius: 50px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
}

.search-form-container .form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.15), inset 0 2px 4px rgba(0,0,0,0.05);
    background: rgba(255, 255, 255, 1);
}

.search-form-container .btn-search {
    padding: 15px 35px;
    font-size: 1.1rem;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0, 123, 255, 0.3);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
}

.search-form-container .btn-search:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
}

.search-form-container .btn-search::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.search-form-container .btn-search:hover::before {
    left: 100%;
}

.kebutuhan-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
    gap: 30px; 
    animation: gridFadeIn 1s ease-out 0.8s backwards;
}

@keyframes gridFadeIn {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

.kebutuhan-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid rgba(255, 255, 255, 0.3);
    position: relative;
    transform: translateY(0);
}

.kebutuhan-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #007bff, #28a745);
    transform: scaleX(0);
    transition: transform 0.4s ease;
    transform-origin: left;
}

.kebutuhan-card:hover {
    transform: translateY(-15px) scale(1.03);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.kebutuhan-card:hover::before {
    transform: scaleX(1);
}

.kebutuhan-card-img img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-bottom: 1px solid rgba(238, 238, 238, 0.5);
    transition: transform 0.4s ease;
}

.kebutuhan-card:hover .kebutuhan-card-img img {
    transform: scale(1.1);
}

.kebutuhan-card-placeholder {
    width: 100%;
    height: 200px;
    background: linear-gradient(135deg, #e9ecef, #f8f9fa);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 1.2rem;
    border-bottom: 1px solid rgba(238, 238, 238, 0.5);
    position: relative;
    overflow: hidden;
}

.kebutuhan-card-placeholder::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

.kebutuhan-card-content { 
    padding: 25px; 
    flex-grow: 1; 
    display: flex; 
    flex-direction: column;
    background: rgba(255, 255, 255, 0.8);
}

.kebutuhan-card-content h3 { 
    font-size: 1.5rem; 
    margin-top: 0; 
    margin-bottom: 15px; 
    color: #0056b3;
    background: linear-gradient(45deg, #0056b3, #007bff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 600;
}

.kebutuhan-card-content h3 a { 
    color: inherit; 
    text-decoration: none;
    transition: all 0.3s ease;
}

.kebutuhan-card-content h3 a:hover { 
    text-decoration: underline;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.kebutuhan-card-content .deskripsi-singkat { 
    font-size: 1rem; 
    color: #666; 
    margin-bottom: 20px; 
    line-height: 1.6; 
    flex-grow: 1;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
}

.kebutuhan-progress { 
    margin-bottom: 20px;
    background: rgba(255, 255, 255, 0.7);
    padding: 15px;
    border-radius: 12px;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
}

.progress-bar-container { 
    background: linear-gradient(135deg, #e9ecef, #f8f9fa);
    border-radius: 12px; 
    height: 14px; 
    overflow: hidden; 
    margin-top: 8px;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    position: relative;
}

.progress-bar-fill { 
    background: linear-gradient(135deg, #28a745, #20c997);
    height: 100%; 
    width: 0%; 
    transition: width 1s ease-in-out;
    border-radius: 12px;
    position: relative;
    overflow: hidden;
}

.progress-bar-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, rgba(255,255,255,0.2), rgba(255,255,255,0.4), rgba(255,255,255,0.2));
    animation: progressGlow 2s ease-in-out infinite;
}

@keyframes progressGlow {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}

.progress-text { 
    font-size: 0.9rem; 
    color: #444; 
    display: flex; 
    justify-content: space-between; 
    margin-bottom: 5px;
    font-weight: 600;
}

.dana-info { 
    font-size: 1rem; 
    margin-bottom: 10px;
    background: rgba(23, 162, 184, 0.1);
    padding: 12px 15px;
    border-radius: 10px;
    border-left: 4px solid #17a2b8;
}

.dana-info strong { 
    color: #17a2b8;
}

.kebutuhan-card-footer { 
    padding: 20px 25px; 
    border-top: 1px solid rgba(240, 240, 240, 0.5); 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    background: rgba(248, 249, 250, 0.9);
    backdrop-filter: blur(10px);
    gap: 15px; /* Tambahkan gap antar tombol */
}

.btn-detail, .btn-donasi {
    padding: 10px 20px; /* Ukuran padding yang lebih proporsional */
    text-decoration: none;
    border-radius: 8px; /* Border radius yang lebih subtle */
    font-size: 0.95rem; /* Font size yang lebih kecil */
    font-weight: 500; /* Font weight yang lebih ringan */
    transition: all 0.2s ease; /* Transisi yang lebih cepat */
    text-align: center;
    border: 1px solid transparent;
    cursor: pointer;
    min-width: 120px; /* Minimum width untuk konsistensi */
    flex: 1; /* Agar tombol memiliki lebar yang sama */
    max-width: 150px; /* Maximum width agar tidak terlalu lebar */
}

.btn-detail { 
    background: #ffffff;
    color: #007bff; 
    border: 1px solid #007bff;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1); /* Shadow yang lebih subtle */
}

.btn-detail:hover { 
    background: #007bff;
    color: white;
    transform: translateY(-1px); /* Hover effect yang lebih subtle */
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
}

.btn-donasi { 
    background: #ffffff;
    color: #28a745; 
    border: 1px solid #28a745;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.1); /* Shadow yang lebih subtle */
}

.btn-donasi:hover { 
    background: #28a745;
    color: white;
    border-color: #28a745;
    transform: translateY(-1px); /* Hover effect yang lebih subtle */
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
}

/* Hapus efek shimmer/glow yang berlebihan */
.btn-detail::before, .btn-donasi::before {
    display: none;
}

.btn-detail::before, .btn-donasi::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-detail:hover::before, .btn-donasi:hover::before {
    left: 100%;
}

.pagination-wrapper { 
    margin-top: 50px; 
    display: flex; 
    justify-content: center;
    animation: contentSlideUp 1s ease-out 1.2s backwards;
}

.no-kebutuhan {
    text-align: center;
    padding: 80px 40px;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
    animation: contentSlideUp 1s ease-out 0.8s backwards;
}

.no-kebutuhan::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #ffc107, #fd7e14);
}

.no-kebutuhan p { 
    font-size: 1.3rem; 
    color: #555;
    margin-bottom: 20px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .hero-content p {
        font-size: 1.2rem;
    }
    
    .kebutuhan-container {
        padding: 20px 10px;
    }
    
    .search-form-container {
        margin-bottom: 30px;
        padding: 20px;
    }
    
    .search-form-container form {
        flex-direction: column;
        gap: 15px;
    }
    
    .search-form-container .form-control,
    .search-form-container .btn-search {
        width: 100%;
    }
    
    .kebutuhan-card-footer {
        flex-direction: column;
        gap: 15px;
    }
    
    .btn-detail, .btn-donasi {
        width: 100%;
    }
    
    .hero-section {
        height: 100vh;
        width: 100vw;
        background-attachment: scroll;
    }
}

@media (max-width: 480px) {
    .hero-content h1 {
        font-size: 2rem;
    }
    
    .hero-content p {
        font-size: 1.1rem;
    }
    
    .hero-section {
        height: 100vh;
        width: 100vw;
    }
}

</style>
@endpush

@section('content')
<!-- Hero Section dengan Background -->
<div class="hero-section">
    <div class="hero-content">
        <h1>KEBUTUHAN PANTI ASUHAN</h1>
        <p>Memberikan Harapan dan Masa Depan Cerah untuk Anak-Anak<br>{{ $identitasPanti->nama_panti ?? 'Rumah Harapan' }}</p>
    </div>
    <div class="hero-scroll-indicator" onclick="document.querySelector('.main-content').scrollIntoView({behavior: 'smooth'})">
        <!-- <i>⬇</i> -->
        <!-- <span>Scroll untuk melihat kebutuhan</span> -->
    </div>
</div>

<!-- Main Content Section -->
<div class="main-content">
    <div class="kebutuhan-container">
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
</div>
@endsection

@push('scripts')
<script>
    // Script untuk animasi progress bar
    document.addEventListener('DOMContentLoaded', function () {
        const progressBars = document.querySelectorAll('.progress-bar-fill');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 500);
        });
        
        // Intersection Observer untuk animasi card
        const cards = document.querySelectorAll('.kebutuhan-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 150);
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)';
            card.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(card);
        });
        
        // Smooth scroll parallax effect
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    });
</script>
@endpush