<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri; // Pastikan model Galeri di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk mengelola file
use Illuminate\Support\Str; // Untuk Str::slug jika ingin override manual
use Illuminate\Validation\Rule;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Tambahkan Request $request untuk search dan filter
    {
        $query = Galeri::query();

        // Fitur Pencarian (opsional, tapi bagus)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        // Fitur Filter berdasarkan Status (opsional)
        if ($request->has('status_publikasi') && $request->status_publikasi != '') {
            $query->where('status_publikasi', $request->status_publikasi);
        }

        // Urutkan berdasarkan yang terbaru, bisa juga berdasarkan urutan lain
        $galeriItems = $query->orderBy('created_at', 'desc')->paginate(10); // 10 item per halaman

        return view('admin.galeri.index', compact('galeriItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tidak ada data khusus yang perlu di-pass ke view create, kecuali mungkin enum atau data lain untuk select
        // Variabel $galeri akan di-set null secara default di partial _form jika tidak di-pass
        return view('admin.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_kegiatan' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Gambar wajib saat create
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('galeri', 'slug') // Pastikan slug unik di tabel galeri
            ],
            'status_publikasi' => 'required|in:draft,published',
        ]);

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('galeri_images', 'public');
            $validatedData['gambar'] = $path;
        }

        // Auto-generate slug jika kosong, menggunakan method dari model
        if (empty($validatedData['slug']) && !empty($validatedData['judul'])) {
            $validatedData['slug'] = Galeri::generateUniqueSlug($validatedData['judul']);
        } elseif (!empty($validatedData['slug'])) {
            // Jika slug diisi manual, pastikan formatnya benar
            $validatedData['slug'] = Str::slug($validatedData['slug']);
            // Periksa lagi keunikan slug yang diinput manual
            if (Galeri::slugExists($validatedData['slug'])) {
                // Jika sudah ada, bisa tambahkan error atau generate yang unik
                // Untuk simpelnya, kita bisa biarkan validasi Rule::unique menangani ini
                // atau generate yang unik:
                // $validatedData['slug'] = Galeri::generateUniqueSlug($validatedData['slug']);
            }
        }


        Galeri::create($validatedData);

        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        // Biasanya tidak digunakan di admin untuk CRUD dasar, lebih ke frontend
        // return view('admin.galeri.show', compact('galeri'));
        return redirect()->route('admin.galeri.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri) // Route model binding akan otomatis mengambil instance Galeri berdasarkan ID
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_kegiatan' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Gambar tidak wajib saat update
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('galeri', 'slug')->ignore($galeri->id) // Abaikan ID saat ini untuk validasi unik
            ],
            'status_publikasi' => 'required|in:draft,published',
            'remove_gambar' => 'nullable|boolean', // Untuk checkbox hapus gambar
        ]);

        // Handle slug
        // Jika slug di request kosong DAN judul berubah, generate slug baru
        if (empty($request->input('slug')) && $request->input('judul') !== $galeri->judul) {
            $validatedData['slug'] = Galeri::generateUniqueSlug($request->input('judul'), $galeri->id);
        } elseif (!empty($request->input('slug'))) {
            // Jika slug diisi manual, pastikan formatnya benar dan unik (mengabaikan diri sendiri)
            $newSlug = Str::slug($request->input('slug'));
            if ($newSlug !== $galeri->slug) { // Hanya proses jika slug baru berbeda
                if (Galeri::slugExists($newSlug, $galeri->id)) {
                    // Jika sudah ada (selain diri sendiri), bisa tambahkan error atau generate yang unik
                    // $validatedData['slug'] = Galeri::generateUniqueSlug($newSlug, $galeri->id);
                    // atau biarkan Rule::unique menangani
                } else {
                    $validatedData['slug'] = $newSlug;
                }
            } else {
                // Jika slug sama dengan yang lama, tidak perlu diubah
                unset($validatedData['slug']);
            }
        } else {
            // Jika slug di request kosong dan judul tidak berubah, jangan ubah slug yang sudah ada
            unset($validatedData['slug']);
        }


        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            $path = $request->file('gambar')->store('galeri_images', 'public');
            $validatedData['gambar'] = $path;
        } elseif ($request->boolean('remove_gambar')) {
            // Jika checkbox remove_gambar dicentang dan tidak ada file baru diupload
            // (Kita asumsikan gambar galeri itu required, jadi remove_gambar berarti akan diganti,
            // atau jika logicnya memperbolehkan gambar dihapus total, maka set $validatedData['gambar'] = null)
            // Untuk sekarang, jika remove_gambar dicentang TAPI TIDAK ADA file baru, gambar lama tidak akan terhapus
            // kecuali kita tambahkan logic khusus. Fokusnya adalah PENGGANTIAN gambar.
            // Jika 'gambar' tidak ada di $validatedData (karena tidak diupload baru), maka field gambar tidak diupdate.
            // Jika remove_gambar DAN ada file baru, file baru akan menggantikan.
            // Jika remove_gambar SAJA, tanpa file baru, ini perlu penanganan khusus jika gambar boleh null.
            // Karena gambar galeri kita 'required' di store, kita asumsikan di update juga ingin ada gambar.
            // Jika gambar di-set nullable di update:
            // if ($request->boolean('remove_gambar') && !$request->hasFile('gambar')) {
            //     if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            //         Storage::disk('public')->delete($galeri->gambar);
            //     }
            //     $validatedData['gambar'] = null;
            // }
        }


        // Hapus 'remove_gambar' dari data yang akan diupdate ke database
        unset($validatedData['remove_gambar']);

        $galeri->update($validatedData);

        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        // Hapus gambar dari storage sebelum menghapus record dari database
        if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil dihapus.');
    }
}