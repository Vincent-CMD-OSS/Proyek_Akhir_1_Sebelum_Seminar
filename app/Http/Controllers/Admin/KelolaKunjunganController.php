<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermintaanKunjungan;
use App\Models\IdentitasPanti; // Untuk nomor WA panti
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk admin_id_yang_memproses
use Carbon\Carbon;

class KelolaKunjunganController extends Controller
{
    public function index(Request $request)
    {
        $query = PermintaanKunjungan::orderBy('created_at', 'desc');

        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }
        if ($request->filled('search_kunjungan')) {
            $search = $request->search_kunjungan;
            $query->where(function($q) use ($search) {
                $q->where('nama_pengunjung', 'like', "%{$search}%")
                  ->orWhere('kontak_whatsapp', 'like', "%{$search}%")
                  ->orWhere('email_pengunjung', 'like', "%{$search}%");
            });
        }

        $permintaanKunjungan = $query->paginate(15);
        return view('admin.kunjungan.index', compact('permintaanKunjungan'));
    }

    // Method create dan store tidak diperlukan karena permintaan dibuat dari publik

    public function show(PermintaanKunjungan $permintaanKunjungan)
    {
        // Bisa digunakan untuk menampilkan detail permintaan di halaman admin jika diperlukan
        // Untuk sekarang, kita fokus pada proses setujui/tolak
        return view('admin.kunjungan.show', compact('permintaanKunjungan'));
    }

    // Method edit dan update tidak untuk data inti, tapi untuk memproses (setujui/tolak)
    // Kita buat method custom untuk ini

    public function proses(Request $request, PermintaanKunjungan $permintaanKunjungan)
    {
        $request->validate([
            'aksi' => 'required|in:setujui,tolak',
            'alasan_penolakan' => 'nullable|required_if:aksi,tolak|string|max:500',
            'catatan_admin' => 'nullable|string|max:500', // Catatan tambahan untuk admin
        ]);

        $identitasPanti = IdentitasPanti::first();
        $nomorWaPantiDefault = $identitasPanti->telepon ?? '6281234567890'; // Ganti dengan nomor WA panti default

        // Fungsi untuk membersihkan nomor WA
        $bersihkanNomorWa = function ($nomor) {
            if (!$nomor) return null;
            $nomor = preg_replace('/[^0-9]/', '', $nomor);
            if (substr($nomor, 0, 1) === '0') {
                return '62' . substr($nomor, 1);
            }
            if (substr($nomor, 0, 2) === '62') {
                return $nomor;
            }
            return '62' . $nomor; // Asumsi default jika tidak ada 0 atau 62
        };

        $nomorWaPengunjung = $bersihkanNomorWa($permintaanKunjungan->kontak_whatsapp);
        $emailPengunjung = $permintaanKunjungan->email_pengunjung;
        $namaPengunjung = $permintaanKunjungan->nama_pengunjung;
        $tanggalKunjungan = Carbon::parse($permintaanKunjungan->tanggal_rencana_kunjungan)->isoFormat('dddd, D MMMM YYYY');
        $jamKunjungan = Carbon::parse($permintaanKunjungan->jam_rencana_kunjungan)->format('H:i');

        $linkWa = null;
        $subjekEmail = null;
        $isiEmail = null;

        if ($request->aksi === 'setujui') {
            $permintaanKunjungan->status = 'disetujui';
            $permintaanKunjungan->alasan_penolakan = null; // Hapus alasan jika sebelumnya ditolak
            $pesan = "Halo {$namaPengunjung},\n\nPermintaan kunjungan Anda ke Panti Asuhan Rumah Harapan pada tanggal {$tanggalKunjungan} pukul {$jamKunjungan} telah DISETUJUI.\n\n";
            if ($request->catatan_admin) {
                $pesan .= "Catatan dari kami: " . $request->catatan_admin . "\n\n";
            }
            $pesan .= "Mohon konfirmasi kehadiran Anda. Jika ada pertanyaan lebih lanjut, silakan balas pesan ini atau hubungi kami.\n\nTerima kasih.\nAdmin Panti Asuhan Rumah Harapan.";

            $subjekEmail = "Konfirmasi Permintaan Kunjungan (Disetujui) - Panti Asuhan Rumah Harapan";

        } elseif ($request->aksi === 'tolak') {
            $permintaanKunjungan->status = 'ditolak';
            $permintaanKunjungan->alasan_penolakan = $request->alasan_penolakan;
            $pesan = "Halo {$namaPengunjung},\n\nMohon maaf, permintaan kunjungan Anda ke Panti Asuhan Rumah Harapan pada tanggal {$tanggalKunjungan} pukul {$jamKunjungan} belum dapat kami setujui saat ini.\n\n";
            $pesan .= "Alasan: " . $request->alasan_penolakan . "\n\n";
            if ($request->catatan_admin) {
                $pesan .= "Catatan tambahan: " . $request->catatan_admin . "\n\n";
            }
            $pesan .= "Anda dapat mencoba mengajukan permintaan kembali di lain waktu atau menghubungi kami untuk informasi lebih lanjut.\n\nTerima kasih atas pengertiannya.\nAdmin Panti Asuhan Rumah Harapan.";

            $subjekEmail = "Informasi Permintaan Kunjungan (Ditolak) - Panti Asuhan Rumah Harapan";
        }

        $permintaanKunjungan->catatan_admin = $request->catatan_admin;
        $permintaanKunjungan->admin_id_yang_memproses = Auth::id();
        $permintaanKunjungan->diproses_pada = now();
        $permintaanKunjungan->save();

        // Buat link WhatsApp jika nomor WA pengunjung ada
        if ($nomorWaPengunjung) {
            $linkWa = "https://wa.me/{$nomorWaPengunjung}?text=" . rawurlencode($pesan);
        }

        // Siapkan data untuk email jika email pengunjung ada
        if ($emailPengunjung) {
            $isiEmail = nl2br(e($pesan)); // e() untuk escape HTML, nl2br untuk baris baru
        }

        $pesanSukses = "Permintaan kunjungan berhasil di" . ($request->aksi === 'setujui' ? 'setujui' : 'tolak') . ".";

        // Kirim email jika ada
        if ($emailPengunjung && $subjekEmail && $isiEmail) {
            // Implementasi pengiriman email (contoh menggunakan Mail facade, buat Mailable dulu)
            // Mail::to($emailPengunjung)->send(new NotifikasiKunjunganMailable($subjekEmail, $isiEmail));
            // $pesanSukses .= " Email notifikasi telah dikirim.";
        }


        return redirect()->route('admin.kunjungan.index')
                         ->with('success', $pesanSukses)
                         ->with('link_whatsapp_konfirmasi', $linkWa) // Kirim link WA ke view
                         ->with('email_info', ['tujuan' => $emailPengunjung, 'subjek' => $subjekEmail, 'isi' => $isiEmail]); // Kirim info email
    }


    public function destroy(PermintaanKunjungan $permintaanKunjungan)
    {
        $permintaanKunjungan->delete();
        return redirect()->route('admin.kunjungan.index')->with('success', 'Permintaan kunjungan berhasil dihapus.');
    }
}