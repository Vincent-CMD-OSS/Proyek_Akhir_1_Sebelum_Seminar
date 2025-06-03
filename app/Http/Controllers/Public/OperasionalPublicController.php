<?php

// App\Http\Controllers\Public\OperasionalPublicController.php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\IdentitasPanti;
use App\Models\JadwalOperasionalHarian;
use App\Models\JadwalOperasionalKhusus;
use Carbon\Carbon;

class OperasionalPublicController extends Controller
{
    public function index()
    {
        

        $identitasPanti = IdentitasPanti::first();

        // Ambil data jadwal harian dan format sebagai array asosiatif
        $jadwalHarianData = JadwalOperasionalHarian::all()->keyBy('hari');
        $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $jadwalHarianTampil = [];

        foreach ($daysOrder as $hari) {
            $entry = $jadwalHarianData->get($hari);
            if ($entry && $entry->status_operasional === 'Buka' && $entry->jam_buka && $entry->jam_tutup) {
                $jadwalHarianTampil[$hari] = [
                    'jam_buka' => Carbon::parse($entry->jam_buka)->format('H:i'),
                    'jam_tutup' => Carbon::parse($entry->jam_tutup)->format('H:i'),
                    'status' => 'Buka',
                ];
            } else {
                $jadwalHarianTampil[$hari] = [
                    'jam_buka' => '-',
                    'jam_tutup' => '-',
                    'status' => 'Tutup',
                ];
            }
        }

        // Ambil jadwal khusus untuk bulan ini dan beberapa bulan ke depan (misalnya)
        $tanggalMulai = Carbon::now()->startOfMonth();
        $tanggalSelesai = Carbon::now()->addMonths(2)->endOfMonth(); // Tampilkan untuk 2 bulan ke depan

        $jadwalKhusus = JadwalOperasionalKhusus::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
                                              ->orderBy('tanggal', 'asc')
                                              ->get();

        return view('public.operasional_index', compact('identitasPanti', 'jadwalHarianTampil', 'jadwalKhusus', 'daysOrder'));
    }
}