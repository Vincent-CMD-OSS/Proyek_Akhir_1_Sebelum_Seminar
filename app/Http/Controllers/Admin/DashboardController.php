<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\Kebutuhan;
use App\Models\PermintaanKunjungan;
use App\Models\Donasi; // Model Donasi sudah benar
use App\Models\JadwalOperasionalHarian;
use App\Models\JadwalOperasionalKhusus;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk Stat Cards
        $jumlahGaleri = Galeri::count();
        $galeriPublished = Galeri::where('status_publikasi', 'published')->count();

        $jumlahKebutuhan = Kebutuhan::count();
        $kebutuhanAktif = Kebutuhan::where('status_kebutuhan', 'Aktif')->count();
        $kebutuhanTercapai = Kebutuhan::where('status_kebutuhan', 'Tercapai')->count();

        $totalDonasiBulanIni = 0;
        if (class_exists(Donasi::class)) {
            $totalDonasiBulanIni = Donasi::where('status_verifikasi', 'Terverifikasi') // GANTI 'status_donasi' menjadi 'status_verifikasi' dan nilainya
                                        ->whereMonth('tanggal_donasi', Carbon::now()->month)
                                        ->whereYear('tanggal_donasi', Carbon::now()->year)
                                        ->sum('jumlah_donasi');
        }

        $permintaanKunjunganPending = 0;
        if (class_exists(PermintaanKunjungan::class)) {
            $permintaanKunjunganPending = PermintaanKunjungan::where('status', 'pending')->count();
        }


        // Data untuk Ringkasan Aktivitas Terbaru
        $galeriTerbaru = Galeri::orderBy('created_at', 'desc')->take(5)->get();
        $kebutuhanTerbaru = Kebutuhan::orderBy('created_at', 'desc')->take(5)->get();
        $permintaanKunjunganTerbaru = [];
        if (class_exists(PermintaanKunjungan::class)) {
            $permintaanKunjunganTerbaru = PermintaanKunjungan::orderBy('created_at', 'desc')->take(5)->get();
        }

        // Data untuk Jadwal Operasional
        $jadwalKhususBerikutnya = JadwalOperasionalKhusus::where('tanggal', '>=', Carbon::today())
                                                        ->orderBy('tanggal', 'asc')
                                                        ->take(3)
                                                        ->get();

        // Data untuk Chart Donasi
        $dataChartDonasi = ['labels' => [], 'data' => []]; // Inisialisasi dengan array kosong
        if (class_exists(Donasi::class)) {
            for ($i = 5; $i >= 0; $i--) {
                $bulan = Carbon::now()->subMonths($i);
                $dataChartDonasi['labels'][] = $bulan->isoFormat('MMM YYYY');
                $dataChartDonasi['data'][] = Donasi::where('status_verifikasi', 'Terverifikasi') // GANTI 'status_donasi' menjadi 'status_verifikasi' dan nilainya
                                                    ->whereMonth('tanggal_donasi', $bulan->month)
                                                    ->whereYear('tanggal_donasi', $bulan->year)
                                                    ->sum('jumlah_donasi');
            }
        }


        return view('admin.dashboard', compact(
            'jumlahGaleri',
            'galeriPublished',
            'jumlahKebutuhan',
            'kebutuhanAktif',
            'kebutuhanTercapai',
            'totalDonasiBulanIni',
            'permintaanKunjunganPending',
            'galeriTerbaru',
            'kebutuhanTerbaru',
            'permintaanKunjunganTerbaru',
            'jadwalKhususBerikutnya',
            'dataChartDonasi'
        ));
    }
}