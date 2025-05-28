<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilPanti;
use App\Models\Galeri;
use App\Models\IdentitasPanti; // PASTIKAN INI DIIMPORT

class HomeController extends Controller
{
    public function index()
    {
        $profilPanti = ProfilPanti::first();
        $identitasPanti = IdentitasPanti::first(); // Ambil data identitas panti

        // Ambil data Galeri
        $galeriItemsHomepage = Galeri::where('status_publikasi', 'published')
                                    ->orderBy('tanggal_kegiatan', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->take(4)
                                    ->get();
        $galeriUtama = $galeriItemsHomepage->shift();
        $galeriListKecil = $galeriItemsHomepage;

        return view('public.home', compact(
            'profilPanti',
            'identitasPanti', // Kirim data identitas panti ke view
            'galeriUtama',
            'galeriListKecil'
        ));
    }
    // ...
}