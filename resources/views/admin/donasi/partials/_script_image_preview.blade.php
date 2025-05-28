<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('bukti_pembayaran_input');
    const imagePreview = document.getElementById('bukti-preview'); // Ini adalah elemen <img> kita

    if (imageInput && imagePreview) {
        // Baca status gambar awal dari atribut data-*
        const hasInitialImage = imagePreview.dataset.hasInitialImage === 'true';
        const initialSrc = imagePreview.dataset.initialSrc;

        // Atur tampilan awal berdasarkan ada atau tidaknya gambar awal
        if (hasInitialImage) {
            imagePreview.style.display = 'block';
        } else {
            imagePreview.style.display = 'none';
        }

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block'; // Selalu tampilkan saat file baru dipilih
                }
                reader.readAsDataURL(file);
            } else {
                // Jika file di-clear dari input
                if (hasInitialImage) {
                    // Kembalikan ke gambar awal dari server
                    imagePreview.src = initialSrc;
                    imagePreview.style.display = 'block'; // Pastikan tetap terlihat
                } else {
                    // Jika memang tidak ada gambar awal, sembunyikan preview
                    imagePreview.src = '#'; // Reset ke placeholder
                    imagePreview.style.display = 'none';
                }
            }
        });
    }
});
</script>