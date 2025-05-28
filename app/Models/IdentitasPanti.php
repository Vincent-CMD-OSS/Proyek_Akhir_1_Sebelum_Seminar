<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentitasPanti extends Model
{
    use HasFactory;

    protected $table = 'identitas_panti';

    protected $fillable = [
        'nama_panti',
        'lokasi_gmaps',
        'nomor_wa',
        'email_panti',
        'facebook_url',
        'youtube_url',
        'instagram_url',
    ];

    /**
     * Get all of the fotos for the IdentitasPanti
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fotos()
    {
        return $this->hasMany(FotoIdentitasPanti::class);
    }
}