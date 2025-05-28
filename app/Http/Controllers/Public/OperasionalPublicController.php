<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\IdentitasPanti; // Jika perlu untuk title atau info lain
use App\Models\JadwalOperasionalHarian;
use App\Models\JadwalOperasionalKhusus;
use Carbon\Carbon; // Untuk manipulasi tanggal

class OperasionalPublicController extends Controller
{
    public function index()
    {
        $identitasPanti = IdentitasPanti::first(); // Opsional, jika diperlukan

        // Ambil Jadwal Harian, urutkan sesuai keinginan
        $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $jadwalHarianGrouped = JadwalOperasionalHarian::orderByRaw(
                                    "FIELD(hari, '" . implode("','", $daysOrder) . "')"
                                )
                                ->orderBy('urutan') // Urutan slot dalam satu hari
                                ->orderBy('jam_buka')
                                ->get()
                                ->groupBy('hari');

        // Pastikan semua hari ada di array, meskipun tidak ada jadwal, agar urutan di view benar
        $jadwalHarianTampilan = collect($daysOrder)->mapWithKeys(function ($hari) use ($jadwalHarianGrouped) {
            return [$hari => $jadwalHarianGrouped->get($hari, collect())];
        });

        // Ambil Jadwal Khusus yang akan datang atau beberapa waktu ke belakang & depan
        // Misalnya, dari 7 hari lalu sampai 30 hari ke depan
        $today = Carbon::today();
        $jadwalKhusus = JadwalOperasionalKhusus::where('tanggal', '>=', $today->copy()->subDays(7))
                                             ->where('tanggal', '<=', $today->copy()->addDays(30))
                                             ->orderBy('tanggal', 'asc') // Tampilkan dari tanggal terdekat
                                             ->get();

        // Atau jika ingin menampilkan semua jadwal khusus yang ada:
        // $jadwalKhusus = JadwalOperasionalKhusus::orderBy('tanggal', 'asc')->get();


        return view('public.operasional_public', compact(
            'identitasPanti',
            'jadwalHarianTampilan',
            'jadwalKhusus',
            'daysOrder' // Kirim ini untuk iterasi hari yang terurut
        ));
    }
}