<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\IdentitasPanti;
use App\Models\Kebutuhan;
use Illuminate\Http\Request;

class DonasiPublicController extends Controller
{
    public function index()
    {
        $identitasPanti = IdentitasPanti::first(); // Atau IdentitasPanti::find(1) jika ID selalu 1

        $kebutuhanAktif = Kebutuhan::where('status_kebutuhan', 'Aktif')
                                  ->orderBy('nama_kebutuhan', 'asc')
                                  ->get(['id', 'nama_kebutuhan']);

        // Ambil nomor WhatsApp dari identitas panti
        $nomorWaPantiRaw = $identitasPanti ? $identitasPanti->nomor_wa : null; // Ambil 'nomor_wa'
        $nomorWaPantiFormatted = '6281234567890'; // Default fallback jika nomor WA tidak ada/kosong

        if ($nomorWaPantiRaw) {
            $tempNomor = preg_replace('/[^0-9]/', '', $nomorWaPantiRaw); // Hapus semua karakter non-numerik
            if (substr($tempNomor, 0, 1) === '0') { // Ganti 0 di depan dengan 62
                $nomorWaPantiFormatted = '62' . substr($tempNomor, 1);
            } elseif (substr($tempNomor, 0, 2) === '62') { // Jika sudah pakai 62
                $nomorWaPantiFormatted = $tempNomor;
            } else {
                // Jika format tidak dikenal, mungkin tambahkan 62 di depan (asumsi nomor Indonesia)
                // Atau biarkan seperti fallback jika formatnya aneh.
                // Untuk keamanan, jika tidak mulai dengan 0 atau 62 setelah dibersihkan,
                // mungkin lebih baik tetap pakai fallback atau log error.
                // Untuk sekarang, jika tidak 0 atau 62, kita coba tambahkan 62.
                if(!empty($tempNomor)) $nomorWaPantiFormatted = '62' . $tempNomor;
            }
        }
        // Pastikan $nomorWaPantiFormatted tidak kosong setelah semua proses
        if (empty($nomorWaPantiFormatted) || strlen($nomorWaPantiFormatted) < 10) { // Panjang minimal nomor WA
             $nomorWaPantiFormatted = '6281234567890'; // Fallback jika hasil pemrosesan tidak valid
        }


        return view('public.donasi_public', compact(
            'identitasPanti',
            'kebutuhanAktif',
            'nomorWaPantiFormatted' // Gunakan nama variabel yang jelas
        ));
    }

    public function kirimKonfirmasiWA(Request $request)
    {
        $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'email_donatur' => 'nullable|email|max:255',
            'telepon_donatur' => 'required|string|max:20',
            'donasi_untuk' => 'required|string',
            'keterangan_tambahan' => 'nullable|string|max:1000',
        ]);

        // ... (logika ambil nama, email, telepon, keterangan, donasiUntukValue tetap sama) ...
        $nama = $request->input('nama_donatur');
        $email = $request->input('email_donatur', '-');
        $telepon = $request->input('telepon_donatur');
        $keterangan = $request->input('keterangan_tambahan', '-');
        $donasiUntukValue = $request->input('donasi_untuk');

        $tujuanDonasiText = "Umum";
        if (strpos($donasiUntukValue, 'kebutuhan_') === 0) {
            $idKebutuhan = str_replace('kebutuhan_', '', $donasiUntukValue);
            $kebutuhan = Kebutuhan::find($idKebutuhan);
            if ($kebutuhan) {
                $tujuanDonasiText = "Kebutuhan: " . $kebutuhan->nama_kebutuhan;
            } else {
                $tujuanDonasiText = "Kebutuhan Spesifik (ID: {$idKebutuhan})";
            }
        } elseif ($donasiUntukValue !== 'umum') {
             $tujuanDonasiText = $donasiUntukValue;
        }

        // Ambil nomor WhatsApp dari identitas panti (logika yang sama seperti di method index)
        $identitasPanti = IdentitasPanti::first();
        $nomorWaPantiRaw = $identitasPanti ? $identitasPanti->nomor_wa : null;
        $nomorWaPantiFormatted = '6281234567890'; // Default fallback

        if ($nomorWaPantiRaw) {
            $tempNomor = preg_replace('/[^0-9]/', '', $nomorWaPantiRaw);
            if (substr($tempNomor, 0, 1) === '0') {
                $nomorWaPantiFormatted = '62' . substr($tempNomor, 1);
            } elseif (substr($tempNomor, 0, 2) === '62') {
                $nomorWaPantiFormatted = $tempNomor;
            } else {
                 if(!empty($tempNomor)) $nomorWaPantiFormatted = '62' . $tempNomor;
            }
        }
        if (empty($nomorWaPantiFormatted) || strlen($nomorWaPantiFormatted) < 10) {
             $nomorWaPantiFormatted = '6281234567890';
        }


        $pesan = "Halo Admin Panti Asuhan Rumah Harapan,\n\n";
        $pesan .= "Saya ingin melakukan konfirmasi donasi dengan detail sebagai berikut:\n\n";
        $pesan .= "Nama Donatur: *{$nama}*\n";
        $pesan .= "Email: {$email}\n";
        $pesan .= "No. Telepon: {$telepon}\n";
        $pesan .= "Donasi Untuk: *{$tujuanDonasiText}*\n";
        $pesan .= "Keterangan Tambahan: {$keterangan}\n\n";
        $pesan .= "Mohon informasinya untuk langkah selanjutnya. Terima kasih.";

        $urlWhatsApp = "https://api.whatsapp.com/send?phone={$nomorWaPantiFormatted}&text=" . urlencode($pesan);

        return redirect()->away($urlWhatsApp);
    }
}       