<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilPanti;
use App\Models\IdentitasPanti;

use Illuminate\Http\Request;

class ProfilPantiPublicController extends Controller
{
    public function index() // Atau mungkin lebih deskriptif seperti showDetail()
    {
        // 1. Gunakan method getData() yang sudah kamu buat di model ProfilPanti
        //    Ini lebih konsisten dan jika ada logika default (seperti create jika belum ada)
        //    bisa terpusat di sana.
        $profilPanti = ProfilPanti::getData();
        $identitasPanti = IdentitasPanti::first(); // Atau cara kamu mengambil data identitas panti

        // 2. Jika $profilPanti null (belum ada data sama sekali), kita tetap perlu mengirim variabel
        //    ke view agar tidak error.
        if (!$profilPanti) {
            return view('public.profil_panti_detail', [
                'profilPanti' => null,
                'identitasPanti' => $identitasPanti, // Untuk title dll.
                'strukturAnggota' => collect(), // Kirim collection kosong
                'timPendiri' => collect(),      // Kirim collection kosong
            ]);
        }

        // 3. Ambil data relasi langsung dari objek $profilPanti. Ini lebih 'Eloquent-way'.
        //    Pastikan relasi 'strukturOrganisasiAnggota' dan 'timPendiriAnggota'
        //    sudah didefinisikan di model App\Models\ProfilPanti.php
        $strukturAnggota = $profilPanti->strukturOrganisasiAnggota()->orderBy('urutan', 'asc')->get();
        $timPendiri = $profilPanti->timPendiriAnggota()->orderBy('urutan', 'asc')->get();

        // 4. Variabel $identitasPanti juga perlu dikirim ke view jika digunakan (misal untuk title)
        return view('public.profil_panti_detail', compact(
            'profilPanti',
            'identitasPanti', // Tambahkan ini
            'strukturAnggota',
            'timPendiri'
        ));
    }
}
