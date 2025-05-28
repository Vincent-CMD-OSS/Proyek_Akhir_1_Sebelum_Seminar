<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoIdentitasPanti extends Model
{
    use HasFactory;

    protected $table = 'foto_identitas_panti';

    protected $fillable = [
        'identitas_panti_id',
        'nama_gambar', // Tambahkan ini
        'file_path',
        'keterangan',
    ];

    /**
     * Get the identitasPanti that owns the FotoIdentitasPanti
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function identitasPanti()
    {
        return $this->belongsTo(IdentitasPanti::class);
    }
}