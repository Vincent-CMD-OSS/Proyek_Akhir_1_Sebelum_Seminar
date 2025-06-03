<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanKunjungan extends Model
{
    use HasFactory;

    protected $table = 'permintaan_kunjungan';

    protected $fillable = [
        'nama_pengunjung',
        'kontak_whatsapp',
        'email_pengunjung',
        'tanggal_rencana_kunjungan',
        'jam_rencana_kunjungan',
        'catatan_pengunjung',
        'status',
        'alasan_penolakan',
        'catatan_admin',
        'admin_id_yang_memproses',
        'diproses_pada',
    ];

    protected $casts = [
        'tanggal_rencana_kunjungan' => 'date',
        // 'jam_rencana_kunjungan' tidak perlu di-cast jika disimpan sebagai TIME,
        // tapi jika disimpan sebagai string, bisa di-cast ke Carbon dengan format tertentu.
        'diproses_pada' => 'datetime',
    ];

    // Relasi ke User (Admin yang memproses) - Opsional
    public function adminYangMemproses()
    {
        return $this->belongsTo(User::class, 'admin_id_yang_memproses');
    }

    // Accessor untuk mempermudah
    public function getKontakUtamaAttribute()
    {
        return $this->kontak_whatsapp ?: $this->email_pengunjung;
    }
}