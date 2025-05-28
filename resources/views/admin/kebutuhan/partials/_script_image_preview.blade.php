<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('gambar_kebutuhan_input');
    const imagePreview = document.getElementById('gambar-kebutuhan-preview');

    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                // Jika tidak ada file dipilih (misal di-clear), jangan ubah src jika sudah ada dari server.
                // Atau jika ingin kembali ke placeholder jika field dikosongkan:
                // imagePreview.src = '#';
                // imagePreview.style.display = 'none';
            }
        });
    }
});
</script>