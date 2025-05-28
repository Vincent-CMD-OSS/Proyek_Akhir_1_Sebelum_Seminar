<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kebutuhan; // Import model
use App\Models\PenerimaanDanaKebutuhan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk gambar
use Illuminate\Support\Str;         // Untuk Str::slug
use Illuminate\Validation\Rule;     // Untuk validasi

class KebutuhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kebutuhan::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_kebutuhan', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
        }
        if ($request->has('status_kebutuhan') && $request->status_kebutuhan != '') {
            $query->where('status_kebutuhan', $request->status_kebutuhan);
        }

        $kebutuhanItems = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.kebutuhan.index', compact('kebutuhanItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kebutuhan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kebutuhan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status_kebutuhan' => ['required', Rule::in(['Draft', 'Aktif', 'Tercapai', 'Dibatalkan'])],
            'target_dana' => 'nullable|numeric|min:0',
            // 'dana_terkumpul' akan dikelola oleh catatan penerimaan, jadi tidak di-input manual di sini
            'tanggal_mulai_dipublikasikan' => 'nullable|date',
            'tanggal_target_tercapai' => 'nullable|date|after_or_equal:tanggal_mulai_dipublikasikan',
            'gambar_kebutuhan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('kebutuhan', 'slug')],
        ]);

        if ($request->hasFile('gambar_kebutuhan')) {
            $path = $request->file('gambar_kebutuhan')->store('kebutuhan_images', 'public');
            $validatedData['gambar_kebutuhan'] = $path;
        }

        if (empty($validatedData['slug']) && !empty($validatedData['nama_kebutuhan'])) {
            $validatedData['slug'] = Kebutuhan::generateUniqueSlug($validatedData['nama_kebutuhan']);
        } elseif (!empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['slug']);
        }
        // dana_terkumpul defaultnya 0 dari migration, dan akan dihitung via accessor dari penerimaan

        Kebutuhan::create($validatedData);

        return redirect()->route('admin.kebutuhan.index')->with('success', 'Kebutuhan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kebutuhan $kebutuhan)
    {
        // Nanti halaman ini akan menampilkan detail kebutuhan dan daftar penerimaan dananya
        return view('admin.kebutuhan.show', compact('kebutuhan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kebutuhan $kebutuhan)
    {
        // Tambahkan logika untuk mencegah edit jika status 'Tercapai' atau 'Dibatalkan' (opsional di sini, bisa di update)
        // if (in_array($kebutuhan->status_kebutuhan, ['Tercapai', 'Dibatalkan'])) {
        //     return redirect()->route('admin.kebutuhan.index')->with('error', 'Kebutuhan yang sudah ' . $kebutuhan->status_kebutuhan . ' tidak dapat diedit.');
        // }
        return view('admin.kebutuhan.edit', compact('kebutuhan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kebutuhan $kebutuhan)
    {
        // Logika untuk mencegah update status dari Tercapai/Dibatalkan ke status lain
        $originalStatus = $kebutuhan->status_kebutuhan;
        if (in_array($originalStatus, ['Tercapai', 'Dibatalkan']) && $request->input('status_kebutuhan') !== $originalStatus) {
            // Jika admin mencoba mengubah status dari Tercapai/Dibatalkan
            // Kita bisa mengabaikan perubahan status atau menampilkan error.
            // Untuk sekarang, kita akan paksa status tetap.
            if($request->input('status_kebutuhan') != $originalStatus){
                 return redirect()->back()
                    ->withInput()
                    ->with('error', "Status Kebutuhan yang sudah '$originalStatus' tidak dapat diubah ke status lain.");
            }
        }

        $validatedData = $request->validate([
            'nama_kebutuhan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status_kebutuhan' => ['required', Rule::in(['Draft', 'Aktif', 'Tercapai', 'Dibatalkan'])],
            'target_dana' => 'nullable|numeric|min:0',
            'tanggal_mulai_dipublikasikan' => 'nullable|date',
            'tanggal_target_tercapai' => 'nullable|date|after_or_equal:tanggal_mulai_dipublikasikan',
            'gambar_kebutuhan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('kebutuhan', 'slug')->ignore($kebutuhan->id)],
        ]);

        if ($request->hasFile('gambar_kebutuhan')) {
            // Hapus gambar lama jika ada
            if ($kebutuhan->gambar_kebutuhan && Storage::disk('public')->exists($kebutuhan->gambar_kebutuhan)) {
                Storage::disk('public')->delete($kebutuhan->gambar_kebutuhan);
            }
            $path = $request->file('gambar_kebutuhan')->store('kebutuhan_images', 'public');
            $validatedData['gambar_kebutuhan'] = $path;
        } elseif ($request->boolean('remove_gambar_kebutuhan')) { // Jika ada checkbox untuk hapus gambar
            if ($kebutuhan->gambar_kebutuhan && Storage::disk('public')->exists($kebutuhan->gambar_kebutuhan)) {
                Storage::disk('public')->delete($kebutuhan->gambar_kebutuhan);
            }
            $validatedData['gambar_kebutuhan'] = null;
        }


        if (empty($validatedData['slug']) && $kebutuhan->nama_kebutuhan !== $validatedData['nama_kebutuhan']) {
            $validatedData['slug'] = Kebutuhan::generateUniqueSlug($validatedData['nama_kebutuhan'], $kebutuhan->id);
        } elseif (!empty($validatedData['slug'])) {
            $newSlug = Str::slug($validatedData['slug']);
            if ($newSlug !== $kebutuhan->slug) {
                $validatedData['slug'] = Kebutuhan::generateUniqueSlug($newSlug, $kebutuhan->id);
            } else {
                 unset($validatedData['slug']); // Tidak ada perubahan slug
            }
        } else {
            unset($validatedData['slug']);
        }


        // Jika status diubah ke Tercapai/Dibatalkan, dan status aslinya bukan itu.
        if (in_array($validatedData['status_kebutuhan'], ['Tercapai', 'Dibatalkan']) && !in_array($originalStatus, ['Tercapai', 'Dibatalkan'])) {
            // Di sini bisa ditambahkan aksi lain jika diperlukan saat status menjadi final
            // misalnya kirim notifikasi, dll.
        }


        $kebutuhan->update($validatedData);

        return redirect()->route('admin.kebutuhan.index')->with('success', 'Kebutuhan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kebutuhan $kebutuhan)
    {
        // Kita harus memutuskan apa yang terjadi dengan penerimaan dana jika kebutuhan dihapus.
        // Karena ada onDelete('cascade') di migration, penerimaan dana terkait akan ikut terhapus.
        // Jika tidak ingin, ubah constraint di migration.

        if ($kebutuhan->gambar_kebutuhan && Storage::disk('public')->exists($kebutuhan->gambar_kebutuhan)) {
            Storage::disk('public')->delete($kebutuhan->gambar_kebutuhan);
        }
        $kebutuhan->delete();

        return redirect()->route('admin.kebutuhan.index')->with('success', 'Kebutuhan berhasil dihapus.');
    }

    // Method untuk CRUD Penerimaan Dana akan ditambahkan nanti
    // public function indexPenerimaan(Kebutuhan $kebutuhan) { ... }
    // public function createPenerimaan(Kebutuhan $kebutuhan) { ... }
    // ...dst

    /**
     * Menampilkan daftar penerimaan dana untuk kebutuhan spesifik.
     * Ini bisa dipanggil dari halaman Kebutuhan::show
     * Namun, untuk saat ini kita akan render langsung di Kebutuhan::show
     */
    // public function indexPenerimaan(Kebutuhan $kebutuhan)
    // {
    //     $penerimaanItems = $kebutuhan->penerimaanDana()->orderBy('tanggal_diterima', 'desc')->paginate(10);
    //     return view('admin.kebutuhan.penerimaan.index', compact('kebutuhan', 'penerimaanItems'));
    // }

    /**
     * Menampilkan form untuk menambah catatan penerimaan dana baru untuk kebutuhan spesifik.
     */
    public function createPenerimaan(Kebutuhan $kebutuhan)
    {
        return view('admin.kebutuhan.penerimaan.create', compact('kebutuhan'));
    }

    /**
     * Menyimpan catatan penerimaan dana baru.
     */
    public function storePenerimaan(Request $request, Kebutuhan $kebutuhan)
    {
        $validatedData = $request->validate([
            'jumlah_dana_diterima' => 'required|numeric|min:0.01',
            'nama_pemberi' => 'required|string|max:255',
            'tanggal_diterima' => 'required|date',
            'metode_pembayaran' => 'nullable|string|max:255',
            'catatan_penerimaan' => 'nullable|string',
        ]);

        $kebutuhan->penerimaanDana()->create($validatedData);

        // Opsional: Panggil method untuk update dana_terkumpul di Kebutuhan jika menggunakan pendekatan kolom cache
        // $kebutuhan->updateDanaTerkumpul();

        return redirect()->route('admin.kebutuhan.show', $kebutuhan->id)
                         ->with('success_penerimaan', 'Catatan penerimaan dana berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit catatan penerimaan dana.
     */
    public function editPenerimaan(Kebutuhan $kebutuhan, PenerimaanDanaKebutuhan $penerimaanDanaKebutuhan)
    {
        // Pastikan penerimaan dana ini milik kebutuhan yang benar (meskipun route sudah scoping)
        if ($penerimaanDanaKebutuhan->kebutuhan_id !== $kebutuhan->id) {
            abort(404);
        }
        return view('admin.kebutuhan.penerimaan.edit', compact('kebutuhan', 'penerimaanDanaKebutuhan'));
    }

    /**
     * Memperbarui catatan penerimaan dana.
     */
    public function updatePenerimaan(Request $request, Kebutuhan $kebutuhan, PenerimaanDanaKebutuhan $penerimaanDanaKebutuhan)
    {
        if ($penerimaanDanaKebutuhan->kebutuhan_id !== $kebutuhan->id) {
            abort(404);
        }

        $validatedData = $request->validate([
            'jumlah_dana_diterima' => 'required|numeric|min:0.01',
            'nama_pemberi' => 'required|string|max:255',
            'tanggal_diterima' => 'required|date',
            'metode_pembayaran' => 'nullable|string|max:255',
            'catatan_penerimaan' => 'nullable|string',
        ]);

        $penerimaanDanaKebutuhan->update($validatedData);

        // Opsional: Panggil method untuk update dana_terkumpul di Kebutuhan
        // $kebutuhan->updateDanaTerkumpul();

        return redirect()->route('admin.kebutuhan.show', $kebutuhan->id)
                         ->with('success_penerimaan', 'Catatan penerimaan dana berhasil diperbarui.');
    }

    /**
     * Menghapus catatan penerimaan dana.
     */
    public function destroyPenerimaan(Kebutuhan $kebutuhan, PenerimaanDanaKebutuhan $penerimaanDanaKebutuhan)
    {
        if ($penerimaanDanaKebutuhan->kebutuhan_id !== $kebutuhan->id) {
            abort(404);
        }

        $penerimaanDanaKebutuhan->delete();

        // Opsional: Panggil method untuk update dana_terkumpul di Kebutuhan
        // $kebutuhan->updateDanaTerkumpul();

        return redirect()->route('admin.kebutuhan.show', $kebutuhan->id)
                         ->with('success_penerimaan', 'Catatan penerimaan dana berhasil dihapus.');
    }
}