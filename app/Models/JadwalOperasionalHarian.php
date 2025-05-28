<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalOperasionalHarian extends Model
{
    use HasFactory;

    protected $table = 'jadwal_operasional_harian';

    protected $fillable = [
        'hari',
        'jam_buka',
        'jam_tutup',
        'status_operasional',
        'keterangan',
        'urutan',
    ];

    // Atribut yang harus di-cast
    // protected $casts = [
    //     'jam_buka' => 'datetime:H:i', // Jika ingin format spesifik, tapi time saja cukup
    //     'jam_tutup' => 'datetime:H:i',
    // ];

    // Jika ingin nama hari dalam bahasa Indonesia untuk tampilan, bisa tambahkan accessor
    public function getNamaHariAttribute()
    {
        // Ini hanya contoh, bisa disesuaikan dengan kebutuhan
        return $this->attributes['hari'];
    }
}