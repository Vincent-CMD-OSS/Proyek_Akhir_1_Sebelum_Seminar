import './bootstrap';

import * as bootstrap from 'bootstrap'; // Impor semua dari Bootstrap
window.bootstrap = bootstrap; 


import './public/galeri-modal.js';


document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('site-navbar');
    const heroSection = document.querySelector('.hero-section'); // Asumsi hero section punya class 'hero-section'

    let heroHeight = 0;
    if (heroSection) {
        heroHeight = heroSection.offsetHeight;
    }
    const navbarHeightThreshold = navbar ? navbar.offsetHeight : 70; // Tinggi navbar untuk referensi

    if (navbar) {
        const updateNavbarStyle = () => {
            const scrollPosition = window.scrollY;

            if (scrollPosition > (heroHeight - navbarHeightThreshold)) {
                // Jika sudah scroll melewati (atau hampir melewati) hero
                navbar.classList.add('navbar-scrolled');
                navbar.classList.remove('navbar-on-hero'); // Hapus class ini jika ada
            } else {
                // Jika masih di atas hero section
                navbar.classList.remove('navbar-scrolled');
                navbar.classList.add('navbar-on-hero'); // Tambahkan class ini
            }
        };

        // Panggil saat load untuk set style awal
        updateNavbarStyle();

        // Panggil saat scroll
        window.addEventListener('scroll', updateNavbarStyle);

        // Event listener untuk hover pada navbar HANYA jika sedang di atas hero
        navbar.addEventListener('mouseenter', function() {
            if (navbar.classList.contains('navbar-on-hero')) {
                navbar.classList.add('navbar-hovered-on-hero');
            }
        });

        navbar.addEventListener('mouseleave', function() {
            // Selalu hapus class hover saat mouse leave,
            // updateNavbarStyle() akan mengembalikan ke transparan jika masih di hero
            navbar.classList.remove('navbar-hovered-on-hero');
        });
    }

    // ... (script smooth scroll dan offset lainnya tetap sama) ...
    const currentNavbarHeight = navbar ? navbar.offsetHeight : 70;
    document.querySelectorAll('#navbarNavPublic a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#') && href.length > 1) {
                const targetElement = document.querySelector(href);
                if (targetElement) {
                    e.preventDefault();
                    const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                    // Gunakan tinggi navbar saat ini (bisa berubah jika padding berubah)
                    const offsetPosition = elementPosition - currentNavbarHeight - 10;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    const navbarCollapse = document.getElementById('navbarNavPublic');
                    if (navbarCollapse.classList.contains('show')) {
                        const toggler = document.querySelector('.navbar-toggler[data-bs-target="#navbarNavPublic"]');
                        if (toggler) {
                            toggler.click();
                        }
                    }
                }
            }
        });
    });
});