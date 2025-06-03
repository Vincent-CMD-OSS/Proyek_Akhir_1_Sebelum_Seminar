<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalOperasionalHarian;
use App\Models\JadwalOperasionalKhusus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OperasionalController extends Controller
{
    public function index()
    {
        // Ambil data jadwal harian, pastikan hanya ada satu entri per hari jika logikanya sudah diubah
        // Kita akan menggunakan array asosiatif untuk memudahkan akses di view
        $jadwalHarianData = JadwalOperasionalHarian::all()->keyBy('hari');
        $jadwalKhusus = JadwalOperasionalKhusus::orderBy('tanggal', 'desc')->paginate(10, ['*'], 'khusus_page');
        $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Siapkan array default untuk setiap hari jika belum ada datanya
        $jadwalHarian = [];
        foreach ($daysOrder as $hari) {
            $jadwalHarian[$hari] = $jadwalHarianData->get($hari); // Bisa null jika belum ada
        }

        return view('admin.operasional.index', compact('jadwalHarian', 'jadwalKhusus', 'daysOrder'));
    }

    // Method aturJadwalHarian dan updateJadwalHarianPerHari DIHAPUS

    /**
     * Menampilkan form untuk mengatur/membuat jadwal untuk satu hari.
     * Jika sudah ada, tampilkan form edit. Jika belum, form tambah (dengan hari sudah terpilih).
     */
    public function editOrCreateHarian(string $hari) // $hari akan 'senin', 'selasa', dst.
    {
        $namaHariProper = ucfirst($hari);
        $validDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        if (!in_array($namaHariProper, $validDays)) {
            abort(404, 'Hari tidak valid.');
        }

        $jadwal = JadwalOperasionalHarian::where('hari', $namaHariProper)->first();

        // Jika belum ada data, kita buat instance baru agar form bisa di-prefill harinya
        if (!$jadwal) {
            $jadwal = new JadwalOperasionalHarian(['hari' => $namaHariProper]);
        }

        return view('admin.operasional.harian.edit_or_create', compact('jadwal', 'namaHariProper'));
    }

    /**
     * Menyimpan atau memperbarui jadwal untuk satu hari.
     */
    public function storeOrUpdateHarian(Request $request, string $hari)
    {
        $namaHariProper = ucfirst($hari);
        $validDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        if (!in_array($namaHariProper, $validDays)) {
            return redirect()->route('admin.operasional.index')
                             ->with('error', 'Hari tidak valid.')
                             ->with('active_tab', '#harian-tab-pane');
        }

        // Validasi: jam_buka dan jam_tutup WAJIB jika status 'Buka'
        // Jika user mengosongkan jam, berarti hari itu 'Tutup'
        $validatedData = $request->validate([
            'jam_buka' => 'nullable|required_with:jam_tutup|date_format:H:i',
            'jam_tutup' => 'nullable|required_with:jam_buka|date_format:H:i|after_or_equal:jam_buka',
        ], [
            'jam_buka.required_with' => 'Jam buka wajib diisi jika jam tutup diisi.',
            'jam_tutup.required_with' => 'Jam tutup wajib diisi jika jam buka diisi.',
            'jam_tutup.after_or_equal' => 'Jam tutup harus setelah atau sama dengan jam buka.',
        ]);

        // Tentukan status berdasarkan input jam
        // Jika jam_buka dan jam_tutup diisi, maka status "Buka"
        // Jika salah satu atau keduanya kosong, maka "Tutup" (dan jam akan di-null-kan)
        $isBuka = !empty($validatedData['jam_buka']) && !empty($validatedData['jam_tutup']);

        JadwalOperasionalHarian::updateOrCreate(
            ['hari' => $namaHariProper], // Kunci untuk mencari atau membuat baru
            [
                'jam_buka' => $isBuka ? $validatedData['jam_buka'] : null,
                'jam_tutup' => $isBuka ? $validatedData['jam_tutup'] : null,
                'status_operasional' => $isBuka ? 'Buka' : 'Tutup',
                // 'keterangan' dan 'urutan' tidak lagi digunakan/diisi di sini
            ]
        );

        return redirect()->route('admin.operasional.index')
                         ->with('success_harian', 'Jadwal untuk hari ' . $namaHariProper . ' berhasil disimpan.')
                         ->with('active_tab', '#harian-tab-pane');
    }

    // Method createHarian, storeHarian (versi lama), editHarian, destroyHarian DIHAPUS
    // karena sudah digabung ke editOrCreateHarian dan storeOrUpdateHarian.
    // Jika kamu tetap ingin ada tombol hapus per hari (untuk mereset ke default/belum diatur),
    // kita bisa buat method destroy baru.

    /**
     * Menghapus (mereset) jadwal untuk satu hari.
     */
    public function destroyHarianByDay(string $hari)
    {
        $namaHariProper = ucfirst($hari);
        JadwalOperasionalHarian::where('hari', $namaHariProper)->delete();
        return redirect()->route('admin.operasional.index')
                         ->with('success_harian', 'Jadwal untuk hari ' . $namaHariProper . ' berhasil dihapus/direset.')
                         ->with('active_tab', '#harian-tab-pane');
    }


    // --- CRUD Jadwal Operasional Khusus (Tetap sama seperti sebelumnya) ---
    public function createKhusus()
    {
        return view('admin.operasional.khusus.create');
    }

    public function storeKhusus(Request $request)
    {
        // ... (validasi dan logic storeKhusus tetap sama)
        $validatedData = $request->validate([
            'tanggal' => 'required|date|unique:jadwal_operasional_khusus,tanggal',
            'nama_acara_libur' => 'required|string|max:255',
            'status_operasional' => ['required', Rule::in(['Buka', 'Tutup', 'Jam Khusus'])],
            'jam_buka_khusus' => 'nullable|required_if:status_operasional,Jam Khusus|date_format:H:i',
            'jam_tutup_khusus' => 'nullable|required_if:status_operasional,Jam Khusus|date_format:H:i|after:jam_buka_khusus',
            'keterangan' => 'nullable|string',
        ], [
            'tanggal.unique' => 'Sudah ada jadwal khusus untuk tanggal ini.',
            'jam_buka_khusus.required_if' => 'Jam buka khusus wajib diisi jika status adalah "Jam Khusus".',
            'jam_tutup_khusus.required_if' => 'Jam tutup khusus wajib diisi jika status adalah "Jam Khusus".',
            'jam_tutup_khusus.after' => 'Jam tutup khusus harus setelah jam buka khusus.',
        ]);

        if ($validatedData['status_operasional'] !== 'Jam Khusus') {
            $validatedData['jam_buka_khusus'] = null;
            $validatedData['jam_tutup_khusus'] = null;
        }
        JadwalOperasionalKhusus::create($validatedData);
        return redirect()->route('admin.operasional.index')
                         ->with('success', 'Jadwal khusus berhasil ditambahkan.')
                         ->with('active_tab', '#khusus-tab-pane');
    }

    public function editKhusus(JadwalOperasionalKhusus $jadwalOperasionalKhusus)
    {
        return view('admin.operasional.khusus.edit', compact('jadwalOperasionalKhusus'));
    }

    public function updateKhusus(Request $request, JadwalOperasionalKhusus $jadwalOperasionalKhusus)
    {
        // ... (validasi dan logic updateKhusus tetap sama)
        $validatedData = $request->validate([
            'tanggal' => ['required', 'date', Rule::unique('jadwal_operasional_khusus', 'tanggal')->ignore($jadwalOperasionalKhusus->id)],
            'nama_acara_libur' => 'required|string|max:255',
            'status_operasional' => ['required', Rule::in(['Buka', 'Tutup', 'Jam Khusus'])],
            'jam_buka_khusus' => 'nullable|required_if:status_operasional,Jam Khusus|date_format:H:i',
            'jam_tutup_khusus' => 'nullable|required_if:status_operasional,Jam Khusus|date_format:H:i|after:jam_buka_khusus',
            'keterangan' => 'nullable|string',
        ], [
            'tanggal.unique' => 'Sudah ada jadwal khusus lain untuk tanggal ini.',
            'jam_buka_khusus.required_if' => 'Jam buka khusus wajib diisi jika status adalah "Jam Khusus".',
            'jam_tutup_khusus.required_if' => 'Jam tutup khusus wajib diisi jika status adalah "Jam Khusus".',
            'jam_tutup_khusus.after' => 'Jam tutup khusus harus setelah jam buka khusus.',
        ]);

        if ($validatedData['status_operasional'] !== 'Jam Khusus') {
            $validatedData['jam_buka_khusus'] = null;
            $validatedData['jam_tutup_khusus'] = null;
        }
        $jadwalOperasionalKhusus->update($validatedData);
        return redirect()->route('admin.operasional.index')
                         ->with('success', 'Jadwal khusus berhasil diperbarui.')
                         ->with('active_tab', '#khusus-tab-pane');
    }

    public function destroyKhusus(JadwalOperasionalKhusus $jadwalOperasionalKhusus)
    {
        $jadwalOperasionalKhusus->delete();
        return redirect()->route('admin.operasional.index')
                         ->with('success', 'Jadwal khusus berhasil dihapus.')
                         ->with('active_tab', '#khusus-tab-pane');
    }
}