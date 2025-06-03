<?php

namespace App\Observers;

use App\Models\PenerimaanDanaKebutuhan;
// use App\Models\Kebutuhan; // Tidak perlu import Kebutuhan di sini jika hanya memanggil method dari objeknya

class PenerimaanDanaKebutuhanObserver
{
    /**
     * Setelah catatan 'PenerimaanDanaKebutuhan' baru DIBUAT.
     */
    public function created(PenerimaanDanaKebutuhan $penerimaanDanaKebutuhan): void
    {
        // Ambil objek Kebutuhan yang terkait dengan penerimaan dana ini
        $kebutuhan = $penerimaanDanaKebutuhan->kebutuhan;
        if ($kebutuhan) {
            // Panggil method di model Kebutuhan untuk cek apakah target sudah tercapai
            $kebutuhan->checkAndSetStatusTercapai();
        }
    }

    /**
     * Setelah catatan 'PenerimaanDanaKebutuhan' DIUPDATE (misal jumlahnya diubah).
     */
    public function updated(PenerimaanDanaKebutuhan $penerimaanDanaKebutuhan): void
    {
        $kebutuhan = $penerimaanDanaKebutuhan->kebutuhan;
        if ($kebutuhan) {
            $kebutuhan->checkAndSetStatusTercapai();
        }
    }

    /**
     * Setelah catatan 'PenerimaanDanaKebutuhan' DIHAPUS.
     */
    public function deleted(PenerimaanDanaKebutuhan $penerimaanDanaKebutuhan): void
    {
        // Untuk 'deleted', kita mungkin perlu mengambil ulang Kebutuhan
        // karena objek $penerimaanDanaKebutuhan->kebutuhan mungkin tidak selalu ada
        $kebutuhan = \App\Models\Kebutuhan::find($penerimaanDanaKebutuhan->kebutuhan_id);
        if ($kebutuhan) {
            $kebutuhan->checkAndSetStatusTercapai();
        }
    }
}