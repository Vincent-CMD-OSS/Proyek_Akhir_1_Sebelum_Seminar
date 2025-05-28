<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalOperasionalKhusus extends Model
{
    use HasFactory;

    protected $table = 'jadwal_operasional_khusus';

    protected $fillable = [
        'tanggal',
        'nama_acara_libur',
        'status_operasional',
        'jam_buka_khusus',
        'jam_tutup_khusus',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        // 'jam_buka_khusus' => 'datetime:H:i',
        // 'jam_tutup_khusus' => 'datetime:H:i',
    ];
}