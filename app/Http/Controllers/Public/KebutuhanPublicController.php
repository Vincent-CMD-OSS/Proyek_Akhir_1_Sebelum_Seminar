<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kebutuhan;
use App\Models\IdentitasPanti; // Jika kamu butuh info panti di halaman ini
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Untuk Str::limit

class KebutuhanPublicController extends Controller
{
    /**
     * Menampilkan daftar kebutuhan yang aktif untuk publik.
     */
    public function index(Request $request)
    {
        $identitasPanti = IdentitasPanti::first(); // Ambil data identitas panti

        $query = Kebutuhan::where('status_kebutuhan', 'Aktif')
                          ->where(function ($q) {
                              $q->whereNull('tanggal_mulai_dipublikasikan')
                                ->orWhere('tanggal_mulai_dipublikasikan', '<=', now());
                          })
                          ->where(function ($q) {
                              $q->whereNull('tanggal_target_tercapai')
                                ->orWhere('tanggal_target_tercapai', '>=', today());
                          });

        // Fitur pencarian sederhana (opsional)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kebutuhan', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $kebutuhanItems = $query->orderBy('created_at', 'desc')->paginate(9); // Misal 9 item per halaman (3 kolom)

        return view('public.kebutuhan.index', compact('kebutuhanItems', 'identitasPanti'));
    }

    /**
     * Menampilkan detail satu kebutuhan publik.
     */
    public function show($slug)
    {
        $identitasPanti = IdentitasPanti::first();
        $kebutuhan = Kebutuhan::where('slug', $slug)
                              ->where('status_kebutuhan', 'Aktif')
                              ->where(function ($q) {
                                  $q->whereNull('tanggal_mulai_dipublikasikan')
                                    ->orWhere('tanggal_mulai_dipublikasikan', '<=', now());
                              })
                              ->where(function ($q) {
                                  $q->whereNull('tanggal_target_tercapai')
                                    ->orWhere('tanggal_target_tercapai', '>=', today());
                              })
                              ->firstOrFail(); // Gagal jika tidak ditemukan atau tidak aktif

        // Ambil juga kebutuhan aktif lainnya untuk ditampilkan sebagai rekomendasi (opsional)
        $kebutuhanLainnya = Kebutuhan::where('status_kebutuhan', 'Aktif')
            ->where('id', '!=', $kebutuhan->id) // Jangan tampilkan yang sedang dilihat
            ->where(function ($q) {
                $q->whereNull('tanggal_mulai_dipublikasikan')
                  ->orWhere('tanggal_mulai_dipublikasikan', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('tanggal_target_tercapai')
                  ->orWhere('tanggal_target_tercapai', '>=', today());
            })
            ->inRandomOrder()
            ->limit(3)
            ->get();


        return view('public.kebutuhan.show', compact('kebutuhan', 'identitasPanti', 'kebutuhanLainnya'));
    }
}