<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';

    protected $fillable = [
        'kebutuhan_id',
        'nama_donatur',
        'nomor_telepon_donatur',
        'email_donatur',
        'jumlah_donasi',
        'tanggal_donasi',
        'metode_pembayaran',
        'bukti_pembayaran',
        'nomor_rekening_pengirim',
        'bank_pengirim',
        'catatan_donasi',
        'status_verifikasi',
        // 'user_id',
    ];

    protected $casts = [
        'jumlah_donasi' => 'decimal:2',
        'tanggal_donasi' => 'date',
    ];

    /**
     * Relasi ke Kebutuhan (opsional).
     */
    public function kebutuhan(): BelongsTo
    {
        return $this->belongsTo(Kebutuhan::class, 'kebutuhan_id');
    }

    /**
     * Relasi ke User (Admin yang mencatat) (opsional).
     */
    // public function pencatat(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}