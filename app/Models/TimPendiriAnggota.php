<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimPendiriAnggota extends Model
{
    use HasFactory;

    protected $table = 'tim_pendiri_anggota';

    protected $fillable = [
        'profil_panti_id',
        'nama_pendiri',
        'peran_atau_jabatan',
        'deskripsi_kontribusi',
        'foto_pendiri',
        'urutan',
    ];

    /**
     * Mendefinisikan relasi many-to-one ke ProfilPanti.
     */ 
    public function profilPanti(): BelongsTo
    {
        return $this->belongsTo(ProfilPanti::class, 'profil_panti_id', 'id');
    }
}