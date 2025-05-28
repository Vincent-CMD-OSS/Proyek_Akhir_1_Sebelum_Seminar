// resources/js/public/galeri-modal.js
import { Modal } from 'bootstrap'; // Impor Modal dari Bootstrap

function initializeGaleriModal() {
    const galeriDetailModalElement = document.getElementById('galeriDetailModal');
    if (!galeriDetailModalElement) {
        // console.log('Elemen modal galeri tidak ditemukan di halaman ini, skip inisialisasi galeri modal.');
        return; // Keluar jika elemen modal tidak ada di halaman ini
    }

    // Inisialisasi instance Modal Bootstrap sekali saja
    const galeriDetailModalInstance = new Modal(galeriDetailModalElement);

    const modalTitle = document.getElementById('galeriDetailModalLabel');
    const modalGambar = document.getElementById('modalGaleriGambar');
    const modalJudul = document.getElementById('modalGaleriJudul');
    const modalTanggal = document.getElementById('modalGaleriTanggal');
    const modalLokasi = document.getElementById('modalGaleriLokasi');
    const modalDeskripsi = document.getElementById('modalGaleriDeskripsi');
    const modalDiposting = document.getElementById('modalGaleriDiposting');
    const modalLoader = document.getElementById('modalLoader');
    const modalBodyContent = document.getElementById('modalBodyContent');

    // Event listener untuk semua tombol/link yang membuka modal
    document.querySelectorAll('.open-galeri-modal').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const galeriId = this.dataset.id;
            // Pastikan base URL di-set di tag <html> jika menggunakan pendekatan dataset.baseUrl
            // <html lang="en" data-base-url="{{ url('/') }}">
            const baseUrl = document.documentElement.dataset.baseUrl || window.location.origin;
            const url = `${baseUrl}/galeri-kegiatan/${galeriId}`;

            // Tampilkan loader dan reset UI modal
            if (modalLoader) modalLoader.style.display = 'block';
            if (modalBodyContent) modalBodyContent.classList.add('loading');

            if (modalGambar) {
                modalGambar.src = '';
                modalGambar.alt = ''; // Reset alt text juga
                modalGambar.style.display = 'none';
            }
            if (modalJudul) modalJudul.textContent = 'Memuat...';
            if (modalTanggal) modalTanggal.textContent = '';
            if (modalLokasi) modalLokasi.textContent = '';
            if (modalDeskripsi) modalDeskripsi.innerHTML = '';
            if (modalDiposting) modalDiposting.textContent = '';
            if (modalTitle) modalTitle.textContent = 'Detail Kegiatan'; // Reset judul modal utama

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        // Coba dapatkan teks error jika ada
                        return response.text().then(text => {
                            throw new Error(`HTTP error! status: ${response.status}, message: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (modalTitle) modalTitle.textContent = data.judul || 'Detail Kegiatan';
                    if (modalGambar) {
                        if (data.gambar_url) {
                            modalGambar.src = data.gambar_url;
                            modalGambar.alt = data.judul || 'Gambar Kegiatan'; // Beri alt text
                            modalGambar.style.display = 'block';
                        } else {
                            modalGambar.style.display = 'none';
                        }
                    }
                    if (modalJudul) modalJudul.textContent = data.judul;
                    if (modalTanggal) modalTanggal.textContent = data.tanggal_kegiatan_formatted;
                    if (modalLokasi) modalLokasi.textContent = data.lokasi;
                    if (modalDeskripsi) modalDeskripsi.innerHTML = data.deskripsi_html; // PASTIKAN AMAN DARI XSS
                    if (modalDiposting) modalDiposting.textContent = data.diposting_pada;

                    // Tampilkan modal menggunakan instance yang sudah dibuat
                    galeriDetailModalInstance.show();
                })
                .catch(error => {
                    console.error('Error fetching galeri detail:', error);
                    if (modalJudul) modalJudul.textContent = 'Gagal Memuat Detail';
                    if (modalDeskripsi) modalDeskripsi.innerHTML = '<p class="text-danger">Tidak dapat mengambil data kegiatan. Silakan coba lagi nanti.</p>';
                    // Tetap tampilkan modal dengan pesan error
                    galeriDetailModalInstance.show();
                })
                .finally(() => {
                    if (modalLoader) modalLoader.style.display = 'none';
                    if (modalBodyContent) modalBodyContent.classList.remove('loading');
                });
        });
    }); // Akhir dari querySelectorAll('.open-galeri-modal')

    // Event listener untuk saat modal ditutup (hidden.bs.modal)
    galeriDetailModalElement.addEventListener('hidden.bs.modal', function () {
        // console.log('Modal ditutup, membersihkan konten.');
        // Reset konten modal ke keadaan awal
        if (modalGambar) {
            modalGambar.src = '';
            modalGambar.alt = '';
            modalGambar.style.display = 'none';
        }
        if (modalJudul) modalJudul.textContent = ''; // Kosongkan
        if (modalTanggal) modalTanggal.textContent = '';
        if (modalLokasi) modalLokasi.textContent = '';
        if (modalDeskripsi) modalDeskripsi.innerHTML = ''; // Kosongkan
        if (modalDiposting) modalDiposting.textContent = '';
        if (modalTitle) modalTitle.textContent = 'Detail Kegiatan'; // Judul default modal

        // Pastikan loader juga disembunyikan dan class loading dihapus jika belum
        if (modalLoader) modalLoader.style.display = 'none';
        if (modalBodyContent) modalBodyContent.classList.remove('loading');
    });
}

// Panggil fungsi inisialisasi saat DOM siap
// Ini akan memastikan bahwa skrip berjalan setelah semua elemen HTML dimuat.
document.addEventListener('DOMContentLoaded', initializeGaleriModal);