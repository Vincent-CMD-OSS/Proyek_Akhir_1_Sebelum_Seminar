<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenerimaanDanaKebutuhan extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_dana_kebutuhan';

    protected $fillable = [
        'kebutuhan_id',
        'jumlah_dana_diterima',
        'nama_pemberi',
        'tanggal_diterima',
        'metode_pembayaran',
        'catatan_penerimaan',
        // 'user_id', // Jika digunakan
    ];

    protected $casts = [
        'jumlah_dana_diterima' => 'decimal:2',
        'tanggal_diterima' => 'date',
    ];

    /**
     * Relasi ke Kebutuhan.
     */
    public function kebutuhan(): BelongsTo
    {
        return $this->belongsTo(Kebutuhan::class, 'kebutuhan_id', 'id');
    }

    // Observer untuk mengupdate dana_terkumpul di Kebutuhan setelah save/delete (OPSIONAL)
    // Ini akan menyimpan kalkulasi ke kolom 'dana_terkumpul' di tabel 'kebutuhan'
    // Jika tidak ingin ada kolom 'dana_terkumpul' dan selalu kalkulasi via accessor, ini tidak perlu.
    // Pilihan ini membuat kolom 'dana_terkumpul' sebagai semacam cache/denormalisasi.
    /*
    protected static function booted()
    {
        static::saved(function ($penerimaan) {
            $penerimaan->kebutuhan->updateDanaTerkumpul();
        });

        static::deleted(function ($penerimaan) {
            // Pastikan relasi kebutuhan masih ada jika menggunakan soft delete atau kasus lain
            if ($penerimaan->kebutuhan) {
                $penerimaan->kebutuhan->updateDanaTerkumpul();
            }
        });
    }
    */
    // Dan di model Kebutuhan, tambahkan method:
    /*
    public function updateDanaTerkumpul()
    {
        $this->dana_terkumpul = $this->penerimaanDana()->sum('jumlah_dana_diterima');
        $this->saveQuietly(); // saveQuietly untuk menghindari trigger event model lagi (infinite loop)
    }
    */
}