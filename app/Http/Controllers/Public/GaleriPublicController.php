<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\IdentitasPanti;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriPublicController extends Controller
{
    public function index()
    {
        $identitasPanti = IdentitasPanti::first();
        $galeriItems = Galeri::where('status_publikasi', 'published')
                            ->orderBy('tanggal_kegiatan', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->paginate(9);

        return view('public.galeri_index', compact('galeriItems', 'identitasPanti'));
    }

    public function show($identifier)
    {
        $galeriItem = Galeri::where('slug', $identifier)->first();
        if (!$galeriItem) {
            $galeriItem = Galeri::find($identifier);
        }

        if (!$galeriItem || $galeriItem->status_publikasi !== 'published') {
            abort(404, 'Item galeri tidak ditemukan atau belum dipublikasikan.');
        }

        $identitasPanti = IdentitasPanti::first();

        $deskripsiHtml = nl2br(e(strip_tags($galeriItem->deskripsi, '<br><p><a><strong><em><ul><ol><li><img><iframe>')));

        // Ambil item galeri lainnya (misalnya 3-6 item, kecuali yang sedang ditampilkan)
        $galeriLainnya = Galeri::where('status_publikasi', 'published')
                                ->where('id', '!=', $galeriItem->id) // Kecualikan item saat ini
                                ->orderBy('tanggal_kegiatan', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->take(6) // Ambil 6 item lainnya, sesuaikan jumlahnya
                                ->get();

        return view('public.galeri_show', compact(
            'galeriItem',
            'identitasPanti',
            'deskripsiHtml',
            'galeriLainnya' // Kirim data galeri lainnya ke view
        ));
    }
}