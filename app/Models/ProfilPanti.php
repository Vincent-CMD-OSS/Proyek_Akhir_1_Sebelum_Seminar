<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfilPanti extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'profil_panti'; // Eksplisit mendefinisikan nama tabel

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slogan',
        'tentang_kami_deskripsi',
        'tentang_kami_img',
        'sejarah_singkat_deskripsi',
        'sejarah_singkat_img',
        'visi_deskripsi',
        'misi_deskripsi',
        'visi_misi_img',
        'struktur_organisasi_img_utama',
        'tim_pendiri_img_utama',
        'lokasi_deskripsi',
        'lokasi_img',
    ];

    /**
     * Mendefinisikan relasi one-to-many ke StrukturOrganisasiAnggota.
     */
    public function strukturOrganisasiAnggota(): HasMany
    {
        return $this->hasMany(StrukturOrganisasiAnggota::class, 'profil_panti_id', 'id');
    }

    /**
     * Mendefinisikan relasi one-to-many ke TimPendiriAnggota.
     */
    public function timPendiriAnggota(): HasMany
    {
        return $this->hasMany(TimPendiriAnggota::class, 'profil_panti_id', 'id');
    }

    // Helper method untuk mendapatkan data profil panti (karena hanya ada satu)
    // Ini opsional, tapi bisa memudahkan di controller
    public static function getData()
    {
        // Ambil record pertama, atau buat baru jika tidak ada (menggunakan data dari seeder jika sudah dijalankan)
        return self::firstOrCreate([], [
            // Nilai default jika record baru dibuat dan seeder belum jalan
            // Sesuaikan nilai default ini jika diperlukan
            'slogan' => 'Slogan Default Panti',
            'tentang_kami_deskripsi' => 'Tentang Kami Default',
            // ... tambahkan default untuk field lain jika perlu ...
        ]);
    }
}