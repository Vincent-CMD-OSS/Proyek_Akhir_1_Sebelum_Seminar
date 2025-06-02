@extends('layouts.user')

@section('title', $kebutuhan->nama_kebutuhan . ' - ' . ($identitasPanti->nama_panti ?? 'Rumah Harapan'))

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.7;
        color: #1a1a1a;
        background: linear-gradient(135deg, #fafafa 0%, #f0f2f5 100%);
        font-weight: 400;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Main Container */
    .kebutuhan-detail-container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 2rem;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Header Section */
    .kebutuhan-header {
        padding: 7rem 0 3rem 0;
        text-align: center;
        margin-bottom: 4rem;
        position: relative;
    }

    .kebutuhan-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
    }

    .kebutuhan-header h1 {
        font-size: 3.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, black 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.02em;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
        text-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .header-meta {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 0.95rem;
        color: #666;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease;
    }

    .meta-item:hover {
        transform: translateY(-5px);
    }

    .meta-item strong {
        color: #1a1a1a;
        font-weight: 700;
        margin-top: 0.5rem;
        font-size: 1.1rem;
    }

    /* Hero Image Section */
    .hero-image-section {
        margin-bottom: 5rem;
        position: relative;
    }

    .hero-image {
        width: 100%;
        height: 65vh;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.12);
        transition: transform 0.3s ease;
    }

    .hero-image:hover {
        transform: scale(1.02);
    }

    .hero-image-placeholder {
        width: 100%;
        height: 65vh;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        font-weight: 500;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }

    .hero-image-placeholder::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Progress Section */
    .progress-section {
        margin-bottom: 5rem;
        padding: 3.5rem 0;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }

    .progress-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 3rem;
        margin-bottom: 3rem;
        padding: 0 2rem;
    }

    .stat-item {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9ff, #ffffff);
        border-radius: 16px;
        border: 1px solid rgba(102, 126, 234, 0.1);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.15);
    }

    .stat-number {
        font-size: 2.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 0.8rem;
    }

    .stat-label {
        font-size: 1rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
    }

    .progress-bar-luxury {
        height: 12px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 20px;
        overflow: hidden;
        margin: 2.5rem 2rem;
        position: relative;
    }

    .progress-bar-luxury::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: progressShimmer 2s infinite;
    }

    @keyframes progressShimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .progress-fill-luxury {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 20px;
        transition: width 2.5s cubic-bezier(0.4, 0, 0.2, 1);
        width: 0%;
        position: relative;
        box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
    }

    .progress-percentage {
        text-align: center;
        font-size: 1.3rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-top: 1.5rem;
    }

    /* Content Section */
    .content-section {
        margin-bottom: 5rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        padding: 3.5rem;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, black);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 2.5rem;
        letter-spacing: -0.01em;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
    }

    .description-content {
        font-size: 1.15rem;
        line-height: 1.9;
        color: #444;
        max-width: 100%;
    }

    .description-content h2,
    .description-content h3 {
        color: #1a1a1a;
        font-weight: 700;
        margin: 2.5rem 0 1.5rem 0;
        line-height: 1.3;
    }

    .description-content h2 {
        font-size: 1.8rem;
    }

    .description-content h3 {
        font-size: 1.5rem;
    }

    .description-content p {
        margin-bottom: 1.8rem;
    }

    .description-content ul,
    .description-content ol {
        padding-left: 2rem;
        margin-bottom: 1.8rem;
    }

    .description-content li {
        margin-bottom: 0.8rem;
    }

    /* CTA Section */
    .cta-section {
        text-align: center;
        padding: 4rem 0;
        margin-bottom: 5rem;
        position: relative;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
    }

    .btn-donate-luxury {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1.2rem 3rem;
        background: linear-gradient(120deg, orange);
        color: white;
        font-size: 1.2rem;
        font-weight: 700;
        text-decoration: none;
        border-radius: 50px;
        transition: all 0.4s ease;
        letter-spacing: 0.02em;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        text-transform: uppercase;
    }

    .btn-donate-luxury::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }

    .btn-donate-luxury:hover::before {
        left: 100%;
    }

    .btn-donate-luxury:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 20px 50px rgba(102, 126, 234, 0.4);
    }

    /* Related Section */
    .related-section {
        margin-bottom: 5rem;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2.5rem;
        margin-top: 3rem;
    }

    .related-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .related-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 60px rgba(102, 126, 234, 0.15);
    }

    .related-image {
        width: 100%;
        height: 240px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .related-card:hover .related-image {
        transform: scale(1.05);
    }

    .related-image-placeholder {
        width: 100%;
        height: 240px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }

    .related-image-placeholder::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: shimmer 2s infinite;
    }

    .related-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.4;
        margin-bottom: 1rem;
        transition: color 0.3s ease;
        flex-grow: 1;
    }

    .related-title a {
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
    }

    .related-title a:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .related-meta {
        font-size: 1rem;
        color: #666;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .btn-related {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.8rem 2rem;
        background: linear-gradient(135deg,black);
        color: white;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        border-radius: 25px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        margin-top: auto;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-related:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .kebutuhan-detail-container {
            padding: 0 1.5rem;
        }

        .kebutuhan-header {
            padding: 3rem 0 2rem 0;
            margin-bottom: 3rem;
        }

        .kebutuhan-header h1 {
            font-size: 2.8rem;
        }

        .header-meta {
            gap: 1.5rem;
            flex-direction: column;
        }

        .meta-item {
            padding: 1rem;
        }

        .hero-image,
        .hero-image-placeholder {
            height: 50vh;
        }

        .progress-stats {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 0 1rem;
        }

        .stat-number {
            font-size: 2.2rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .description-content {
            font-size: 1rem;
        }

        .content-section {
            padding: 2.5rem 2rem;
        }

        .related-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .related-card {
            padding: 1.5rem;
        }

        .btn-donate-luxury {
            padding: 1rem 2.5rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .kebutuhan-header h1 {
            font-size: 2.2rem;
        }

        .hero-image,
        .hero-image-placeholder {
            height: 40vh;
        }

        .content-section {
            padding: 2rem 1.5rem;
        }

        .related-card {
            padding: 1.5rem;
        }
    }

    /* Smooth scrolling and selection */
    html {
        scroll-behavior: smooth;
    }

    ::selection {
        background: rgba(102, 126, 234, 0.2);
        color: #1a1a1a;
    }

    /* Loading state */
    .loading {
        opacity: 0;
        animation: fadeInUp 0.8s ease-out forwards;
    }

    /* Floating particles animation */
    .kebutuhan-detail-container::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23667eea' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
        pointer-events: none;
        z-index: -1;
        animation: float 20s infinite linear;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        100% { transform: translateY(-60px); }
    }
</style>
@endpush

@section('content')
<div class="kebutuhan-detail-container loading">
    
    <!-- Header Section -->
    <header class="kebutuhan-header">
        <h1>{{ $kebutuhan->nama_kebutuhan }}</h1>
        
        <div class="header-meta">
            @if($kebutuhan->tanggal_mulai_dipublikasikan)
            <div class="meta-item">
                <span>Dipublikasikan</span>
                <strong>{{ $kebutuhan->tanggal_mulai_dipublikasikan->isoFormat('D MMMM YYYY') }}</strong>
            </div>
            @endif
            
            @if($kebutuhan->tanggal_target_tercapai)
            <div class="meta-item">
                <span>Target Tercapai</span>
                <strong>{{ $kebutuhan->tanggal_target_tercapai->isoFormat('D MMMM YYYY') }}</strong>
                @if($kebutuhan->sisa_hari !== null)
                <small style="color: #999; font-size: 0.85rem;">({{ $kebutuhan->sisa_hari }} hari tersisa)</small>
                @endif
            </div>
            @endif
        </div>
    </header>

    <!-- Hero Image Section -->
    <section class="hero-image-section">
        @if($kebutuhan->gambar_kebutuhan)
        <img src="{{ Storage::url($kebutuhan->gambar_kebutuhan) }}" 
             alt="{{ $kebutuhan->nama_kebutuhan }}" 
             class="hero-image" 
             loading="lazy">
        @else
        <div class="hero-image-placeholder">
            <span>Gambar tidak tersedia</span>
        </div>
        @endif
    </section>

    <!-- Progress Section -->
    @if($kebutuhan->target_dana > 0)
    <section class="progress-section">
        <div class="progress-stats">
            <div class="stat-item">
                <div class="stat-number">Rp {{ number_format($kebutuhan->dana_terkumpul, 0, ',', '.') }}</div>
                <div class="stat-label">Terkumpul</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">Rp {{ number_format($kebutuhan->target_dana, 0, ',', '.') }}</div>
                <div class="stat-label">Target Donasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ number_format($kebutuhan->persentase_terkumpul, 0) }}%</div>
                <div class="stat-label">Tercapai</div>
            </div>
        </div>
        
        <div class="progress-bar-luxury">
            <div class="progress-fill-luxury" data-width="{{ $kebutuhan->persentase_terkumpul }}"></div>
        </div>
        
        <div class="progress-percentage">
            {{ number_format($kebutuhan->persentase_terkumpul, 1) }}% dari target tercapai
        </div>
    </section>
    @endif

    <!-- Content Section -->
    <section class="content-section">
        <h2 class="section-title">Deskripsi Kebutuhan</h2>
        <div class="description-content">
            {!! $kebutuhan->deskripsi !!}
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <a href="{{ route('public.donasi.index', ['kebutuhan_id' => $kebutuhan->id, 'nama_kebutuhan' => $kebutuhan->nama_kebutuhan]) }}" 
           class="btn-donate-luxury">
            Donasi Untuk Kebutuhan Ini
        </a>
    </section>

    <!-- Related Section -->
    @if($kebutuhanLainnya->isNotEmpty())
    <section class="related-section">
        <h2 class="section-title">Kebutuhan Lainnya</h2>
        
        <div class="related-grid">
            @foreach($kebutuhanLainnya as $itemLain)
            <article class="related-card">
                @if($itemLain->gambar_kebutuhan)
                <img src="{{ Storage::url($itemLain->gambar_kebutuhan) }}" 
                     alt="{{ $itemLain->nama_kebutuhan }}" 
                     class="related-image" 
                     loading="lazy">
                @else
                <div class="related-image-placeholder">
                    <span>Gambar tidak tersedia</span>
                </div>
                @endif
                
                <h3 class="related-title">
                    <a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}">
                        {{ Str::limit($itemLain->nama_kebutuhan, 60) }}
                    </a>
                </h3>
                
                @if($itemLain->target_dana > 0)
                <div class="related-meta">
                    Target: Rp {{ number_format($itemLain->target_dana, 0, ',', '.') }}
                </div>
                @endif
                
                <a href="{{ route('public.kebutuhan.show', $itemLain->slug) }}" class="btn-related">
                    Lihat Detail
                </a>
            </article>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Progress bar animation
    const progressBar = document.querySelector('.progress-fill-luxury');
    if (progressBar) {
        const targetWidth = progressBar.dataset.width;
        
        // Intersection Observer untuk trigger animasi saat terlihat
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        progressBar.style.width = targetWidth + '%';
                    }, 500);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(progressBar.parentElement);
    }

    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Loading animation trigger
    setTimeout(() => {
        const loadingElement = document.querySelector('.loading');
        if (loadingElement) {
            loadingElement.style.opacity = '1';
        }
    }, 100);

    // Lazy loading untuk gambar yang belum memiliki loading="lazy"
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Parallax effect untuk background particles
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.kebutuhan-detail-container::before');
        if (parallax) {
            const speed = scrolled * 0.5;
            parallax.style.transform = `translateY(${speed}px)`;
        }
    });
});
</script>
@endpush