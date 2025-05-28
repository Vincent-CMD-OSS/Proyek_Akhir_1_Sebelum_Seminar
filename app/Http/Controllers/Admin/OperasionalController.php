<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalOperasionalHarian;
use App\Models\JadwalOperasionalKhusus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Untuk validasi

class OperasionalController extends Controller
{
    /**
     * Menampilkan halaman utama pengelolaan jadwal operasional.
     */
    public function index()
    {
        // Ambil data jadwal harian dan kelompokkan
        $jadwalHarianGrouped = JadwalOperasionalHarian::orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
                                            ->orderBy('urutan')
                                            ->orderBy('jam_buka')
                                            ->get()
                                            ->groupBy('hari');

        $jadwalKhusus = JadwalOperasionalKhusus::orderBy('tanggal', 'desc')->paginate(10, ['*'], 'khusus_page');
        $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Ganti nama variabel agar sesuai dengan view yang baru
        return view('admin.operasional.index', compact('jadwalHarianGrouped', 'jadwalKhusus', 'daysOrder'));
    }

    // --- CRUD Jadwal Operasional Harian (Pendekatan Baru) ---

    /**
     * Menampilkan form untuk mengatur jadwal slot untuk hari tertentu.
     */
    public function aturJadwalHarian(string $hari) // $hari akan 'senin', 'selasa', dst.
    {
        $namaHariProper = ucfirst($hari); // 'Senin', 'Selasa'
        $validDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        if (!in_array($namaHariProper, $validDays)) {
            abort(404, 'Hari tidak valid.');
        }

        $jadwalSlots = JadwalOperasionalHarian::where('hari', $namaHariProper)
                                            ->orderBy('urutan')
                                            ->orderBy('jam_buka')
                                            ->get();

        return view('admin.operasional.harian.atur', compact('namaHariProper', 'jadwalSlots'));
    }

    // --- CRUD Jadwal Operasional Harian ---

    /**
     * Menampilkan form untuk membuat slot jadwal harian baru.
     */
    public function createHarian()
    {
        return view('admin.operasional.harian.create');
    }

    /**
     * Menyimpan slot jadwal harian baru ke database.
     */
    public function storeHarian(Request $request)
    {
        $validatedData = $request->validate([
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
            'status_operasional' => ['required', Rule::in(['Buka', 'Tutup'])],
            'keterangan' => 'nullable|string|max:255',
            'urutan' => 'required|integer|min:0',
        ], [
            'jam_tutup.after' => 'Jam tutup harus setelah jam buka.'
        ]);

        JadwalOperasionalHarian::create($validatedData);

        return redirect()->route('admin.operasional.index')
                         ->with('success', 'Slot jadwal harian berhasil ditambahkan.')
                         ->with('active_tab', '#harian-tab-pane'); // Untuk mengarahkan ke tab harian
    }

    /**
     * Menampilkan form untuk mengedit slot jadwal harian.
     */
    public function editHarian(JadwalOperasionalHarian $jadwalOperasionalHarian) // Route Model Binding
    {
        return view('admin.operasional.harian.edit', compact('jadwalOperasionalHarian'));
    }

    /**
     * Memperbarui slot jadwal harian di database.
     */
    public function updateJadwalHarianPerHari(Request $request, string $hari)
    {
        $namaHariProper = ucfirst($hari);
        // ... (validasi hari) ...

        // PERBAIKAN: Gunakan helper validator()
        $validator = validator($request->all(), [ // <--- PERUBAHAN DI SINI
            'slots' => 'nullable|array',
            'slots.*.jam_buka' => 'required_with:slots.*.jam_tutup,slots.*.status_operasional|nullable|date_format:H:i',
            'slots.*.jam_tutup' => 'required_with:slots.*.jam_buka,slots.*.status_operasional|nullable|date_format:H:i|after:slots.*.jam_buka',
            'slots.*.status_operasional' => ['required_with:slots.*.jam_buka,slots.*.jam_tutup', 'nullable', Rule::in(['Buka', 'Tutup'])],
            'slots.*.keterangan' => 'nullable|string|max:255',
            'slots.*.urutan' => 'required_with:slots.*.jam_buka|nullable|integer|min:0',
        ], [
            'slots.*.jam_tutup.after' => 'Jam tutup pada slot #:position harus setelah jam buka.',
            'slots.*.jam_buka.required_with' => 'Jam buka pada slot #:position wajib diisi jika field lain pada slot tersebut diisi.',
            // ...
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.operasional.harian.atur', ['hari' => $hari])
                ->withErrors($validator)
                ->withInput();
        }

        // ... (sisa logika) ...
        JadwalOperasionalHarian::where('hari', $namaHariProper)->delete();

        if ($request->has('slots')) {
            foreach ($request->slots as $index => $slotData) {
                if (!empty($slotData['jam_buka']) && !empty($slotData['jam_tutup']) && !empty($slotData['status_operasional'])) { // Pastikan field inti diisi
                    JadwalOperasionalHarian::create([
                        'hari' => $namaHariProper,
                        'jam_buka' => $slotData['jam_buka'],
                        'jam_tutup' => $slotData['jam_tutup'],
                        'status_operasional' => $slotData['status_operasional'],
                        'keterangan' => $slotData['keterangan'] ?? null,
                        'urutan' => $slotData['urutan'] ?? $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.operasional.index')
                         ->with('success_harian', 'Jadwal untuk hari ' . $namaHariProper . ' berhasil diperbarui.')
                         ->with('active_tab', '#harian-tab-pane');
    }



    /**
     * Menghapus slot jadwal harian dari database.
     */
    public function destroyHarian(JadwalOperasionalHarian $jadwalOperasionalHarian)
    {
        $jadwalOperasionalHarian->delete();

        return redirect()->route('admin.operasional.index')
                         ->with('success', 'Slot jadwal harian berhasil dihapus.')
                         ->with('active_tab', '#harian-tab-pane');
    }


    // --- CRUD Jadwal Operasional Khusus (Akan diisi nanti) ---
    public function createKhusus()
    {
        // Placeholder
        return view('admin.operasional.khusus.create');
    }

    public function storeKhusus(Request $request)
    {
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

        // Jika status bukan 'Jam Khusus', pastikan jam buka/tutup khusus di-null-kan
        if ($validatedData['status_operasional'] !== 'Jam Khusus') {
            $validatedData['jam_buka_khusus'] = null;
            $validatedData['jam_tutup_khusus'] = null;
        }

        JadwalOperasionalKhusus::create($validatedData);

        return redirect()->route('admin.operasional.index')
                         ->with('success', 'Jadwal khusus berhasil ditambahkan.')
                         ->with('active_tab', '#khusus-tab-pane'); // Mengarahkan ke tab khusus
    }

    public function editKhusus(JadwalOperasionalKhusus $jadwalOperasionalKhusus)
    {
        // Placeholder
        return view('admin.operasional.khusus.edit', compact('jadwalOperasionalKhusus'));
    }

    public function updateKhusus(Request $request, JadwalOperasionalKhusus $jadwalOperasionalKhusus)
    {
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