<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PenerimaanDanaKebutuhan;
use Illuminate\Support\Str;

class Kebutuhan extends Model
{
    use HasFactory; // Pastikan ini ada

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'kebutuhan'; // Pastikan ini ada dan benar

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [ // Pastikan ini ada dan lengkap
        'nama_kebutuhan',
        'deskripsi',
        'status_kebutuhan',
        'target_dana',
        // 'dana_terkumpul',
        'tanggal_mulai_dipublikasikan',
        'tanggal_target_tercapai',
        'gambar_kebutuhan',
        'slug',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data asli.
     *
     * @var array
     */
    protected $casts = [
        'target_dana' => 'decimal:2',
        // 'dana_terkumpul' => 'decimal:2',
        'tanggal_mulai_dipublikasikan' => 'date',
        'tanggal_target_tercapai' => 'date',
    ];

    /**
     * Relasi ke Donasi yang terkait dengan kebutuhan ini.
     */
    public function donasiTerkait(): HasMany
    {
        // Hanya ambil donasi yang sudah terverifikasi untuk perhitungan dana terkumpul
        return $this->hasMany(Donasi::class, 'kebutuhan_id', 'id')->where('status_verifikasi', 'Terverifikasi');
    }

    /**
     * Accessor untuk menghitung total dana terkumpul dari donasi terkait yang sudah terverifikasi.
     */
    public function getDanaTerkumpulAktualAttribute(): float
    {
        // Jika kamu menghapus kolom 'dana_terkumpul' dari tabel 'kebutuhan'
        // dan sepenuhnya mengandalkan perhitungan dinamis ini:
        return (float) $this->donasiTerkait()->sum('jumlah_donasi');

        // Jika kamu MASIH memiliki kolom 'dana_terkumpul' di tabel 'kebutuhan' dan INGIN kolom itu
        // diisi oleh observer dari model Donasi (yang belum kita implementasikan sepenuhnya),
        // maka kamu bisa saja mengembalikan nilai kolom itu di sini:
        // return (float) $this->attributes['dana_terkumpul'];
        // TAPI, untuk konsistensi dan akurasi, lebih baik menghitung langsung dari relasi donasiTerkait.
    }

    /**
     * Accessor untuk persentase tercapai.
     */
    public function getPersentaseTercapaiAttribute(): float
    {
        if ($this->target_dana > 0) {
            // Pastikan menggunakan dana_terkumpul_aktual yang sudah dihitung dari donasi terverifikasi
            $persentase = ($this->dana_terkumpul_aktual / $this->target_dana) * 100;
            return round($persentase, 2); // Bulatkan ke 2 desimal
        }
        return 0;
    }

    /**
     * Accessor untuk sisa dana yang dibutuhkan.
     */
    public function getSisaDanaDibutuhkanAttribute(): float
    {
        if ($this->target_dana > 0) {
            // Pastikan menggunakan dana_terkumpul_aktual
            $sisa = $this->target_dana - $this->dana_terkumpul_aktual;
            return max(0, $sisa); // Pastikan tidak negatif
        }
        // Jika tidak ada target dana, maka tidak ada sisa yang dibutuhkan dalam konteks target
        // Atau bisa juga return $this->target_dana jika itu null (berarti tidak ada target, jadi tidak ada sisa).
        // Untuk konsistensi, jika target_dana 0 atau null, sisa 0.
        return 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kebutuhan) {
            if (empty($kebutuhan->slug) && !empty($kebutuhan->nama_kebutuhan)) {
                $kebutuhan->slug = static::generateUniqueSlug($kebutuhan->nama_kebutuhan);
            }
            // Inisialisasi dana_terkumpul ke 0 jika kolomnya masih ada
            if (array_key_exists('dana_terkumpul', $kebutuhan->getAttributes()) && is_null($kebutuhan->dana_terkumpul)) {
                $kebutuhan->dana_terkumpul = 0.00;
            }
        });

        static::updating(function ($kebutuhan) {
            if ($kebutuhan->isDirty('nama_kebutuhan') && empty($kebutuhan->getOriginal('slug')) && !empty($kebutuhan->nama_kebutuhan) ) {
                 $kebutuhan->slug = static::generateUniqueSlug($kebutuhan->nama_kebutuhan, $kebutuhan->id);
            } elseif (empty($kebutuhan->slug) && !empty($kebutuhan->nama_kebutuhan) && $kebutuhan->isDirty('nama_kebutuhan')) {
                 $kebutuhan->slug = static::generateUniqueSlug($kebutuhan->nama_kebutuhan, $kebutuhan->id);
            }
        });
    }

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

    protected static function slugExists(string $slug, int $excludeId = null): bool
    {
        $query = static::where('slug', $slug);
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->exists();
    }

    public function penerimaanDana()
    {
        return $this->hasMany(PenerimaanDanaKebutuhan::class, 'kebutuhan_id');
    }

    public function getDanaTerkumpulAttribute()
    {
        // Menghitung total dana terkumpul dari relasi penerimaanDana
        return $this->penerimaanDana()->sum('jumlah_dana_diterima');
    }
}