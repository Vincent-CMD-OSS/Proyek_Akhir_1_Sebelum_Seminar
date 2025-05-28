{{-- resources/views/public/partials/_hero.blade.php --}}
<section class="hero-section" id="home">
    <video class="hero-video" autoplay muted loop playsinline> {{-- Tambahkan playsinline untuk iOS --}}
        <source src="{{ asset('videos/hero-video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="hero-overlay">
        <h1 class="hero-title">CHILDREN FLOURISHING</h1>
        <p class="lead">Memberikan Harapan dan Masa Depan Cerah untuk Anak-Anak Indonesia</p>
    </div>
</section>