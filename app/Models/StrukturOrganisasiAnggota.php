<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StrukturOrganisasiAnggota extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'struktur_organisasi_anggota'; // <--- TAMBAHKAN BARIS INI

    protected $fillable = [
        'profil_panti_id',
        'nama_anggota',
        'jabatan',
        'foto_anggota',
        'deskripsi_singkat',
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