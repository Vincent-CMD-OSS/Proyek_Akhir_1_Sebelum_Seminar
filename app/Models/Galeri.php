<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Untuk Str::slug

class Galeri extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'galeri'; // Ini sudah benar

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'tanggal_kegiatan',
        'lokasi',
        'deskripsi',
        'gambar',
        'slug',
        'status_publikasi',
        // 'user_id', // Jika ada relasi ke user yang membuat, tambahkan di sini
        // created_at dan updated_at di-handle otomatis oleh Eloquent, tidak perlu di fillable
    ];

    /**
     * Atribut yang harus di-cast ke tipe data asli.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_kegiatan' => 'date', // Ini sudah benar
        // 'created_at' => 'datetime', // Tidak perlu jika ingin default Carbon instance
        // 'updated_at' => 'datetime', // Tidak perlu jika ingin default Carbon instance
        // Jika kamu secara spesifik ingin format tertentu saat serialisasi ke array/JSON,
        // kamu bisa menggunakan custom cast atau accessor, TAPI untuk operasi Carbon
        // seperti ->toIso8601String(), default casting sudah cukup.
    ];

    /**
     * Boot a new instance of the model.
     * Kita bisa menggunakan event 'creating' atau 'saving' untuk auto-generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($galeri) {
            if (empty($galeri->slug) && !empty($galeri->judul)) { // Pastikan judul tidak kosong juga
                $galeri->slug = static::generateUniqueSlug($galeri->judul);
            }
        });

        static::updating(function ($galeri) {
            // Hanya update slug jika judul berubah DAN slug tidak diisi manual oleh user
            if ($galeri->isDirty('judul') && !$galeri->isDirty('slug') && !empty($galeri->judul)) {
                 $galeri->slug = static::generateUniqueSlug($galeri->judul, $galeri->id);
            }
            // Jika slug dikosongkan manual oleh user tapi judul ada, generate ulang
            elseif (empty($galeri->slug) && !empty($galeri->judul)) {
                 $galeri->slug = static::generateUniqueSlug($galeri->judul, $galeri->id);
            }
        });
    }

    /**
     * Generate a unique slug.
     *
     * @param string $title
     * @param int|null $excludeId Untuk kasus update, agar tidak bentrok dengan diri sendiri
     * @return string
     */
    public static function generateUniqueSlug(string $title, int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $count++;
        }
        return $slug;
    }

    /**
     * Check if a slug exists in the database.
     *
     * @param string $slug
     * @param int|null $excludeId
     * @return bool
     */
    protected static function slugExists(string $slug, int $excludeId = null): bool
    {
        $query = static::where('slug', $slug);
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->exists();
    }
}