<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;    // Import model Donasi
use App\Models\Kebutuhan; // Import model Kebutuhan untuk select list
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk gambar bukti pembayaran
use Illuminate\Validation\Rule;

class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Donasi::with('kebutuhan')->orderBy('tanggal_donasi', 'desc'); // Eager load relasi kebutuhan

        // Filter berdasarkan nama donatur
        if ($request->filled('nama_donatur')) {
            $query->where('nama_donatur', 'like', '%' . $request->nama_donatur . '%');
        }

        // Filter berdasarkan status verifikasi
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        // Filter berdasarkan kebutuhan_id (jika ada)
        if ($request->filled('kebutuhan_id_filter')) {
            $query->where('kebutuhan_id', $request->kebutuhan_id_filter);
        }

        // Filter berdasarkan rentang tanggal donasi
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_donasi', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_donasi', '<=', $request->tanggal_akhir);
        }


        $donasiItems = $query->paginate(15);
        $kebutuhanList = Kebutuhan::whereIn('status_kebutuhan', ['Aktif', 'Draft']) // Hanya tampilkan kebutuhan yang masih relevan untuk donasi
                                  ->orderBy('nama_kebutuhan')
                                  ->pluck('nama_kebutuhan', 'id'); // Untuk dropdown filter

        return view('admin.donasi.index', compact('donasiItems', 'kebutuhanList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) // Tambahkan Request untuk menerima parameter
    {
        $kebutuhanList = Kebutuhan::whereIn('status_kebutuhan', ['Aktif', 'Draft'])
                                  ->orderBy('nama_kebutuhan')
                                  ->pluck('nama_kebutuhan', 'id');

        $selectedKebutuhanId = $request->query('kebutuhan_id'); // Ambil kebutuhan_id dari query param jika ada

        return view('admin.donasi.create', compact('kebutuhanList', 'selectedKebutuhanId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kebutuhan_id' => 'nullable|exists:kebutuhan,id',
            'nama_donatur' => 'required|string|max:255',
            'nomor_telepon_donatur' => 'nullable|string|max:20',
            'email_donatur' => 'nullable|email|max:255',
            'jumlah_donasi' => 'required|numeric|min:1', // Minimal donasi 1 (sesuaikan)
            'tanggal_donasi' => 'required|date',
            'metode_pembayaran' => 'nullable|string|max:100',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'nomor_rekening_pengirim' => 'nullable|string|max:50',
            'bank_pengirim' => 'nullable|string|max:100',
            'catatan_donasi' => 'nullable|string',
            'status_verifikasi' => ['required', Rule::in(['Pending', 'Terverifikasi', 'Ditolak'])],
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_donasi', 'public');
            $validatedData['bukti_pembayaran'] = $path;
        }

        Donasi::create($validatedData);

        // Jika donasi terkait dengan kebutuhan, redirect ke halaman detail kebutuhan, jika tidak ke index donasi
        if (!empty($validatedData['kebutuhan_id'])) {
            return redirect()->route('admin.kebutuhan.show', $validatedData['kebutuhan_id'])
                             ->with('success_penerimaan', 'Donasi berhasil dicatat untuk kebutuhan ini.');
        }

        return redirect()->route('admin.donasi.index')->with('success', 'Donasi berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donasi $donasi)
    {
        return view('admin.donasi.show', compact('donasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donasi $donasi)
    {
        $kebutuhanList = Kebutuhan::whereIn('status_kebutuhan', ['Aktif', 'Draft', 'Tercapai'])
                                  ->orWhere('id', $donasi->kebutuhan_id) // Penting untuk menampilkan kebutuhan yang sudah terpilih meskipun statusnya lain
                                  ->orderBy('nama_kebutuhan')
                                  ->pluck('nama_kebutuhan', 'id');
        return view('admin.donasi.edit', compact('donasi', 'kebutuhanList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donasi $donasi)
    {
         $validatedData = $request->validate([
            'kebutuhan_id' => 'nullable|exists:kebutuhan,id',
            'nama_donatur' => 'required|string|max:255',
            'nomor_telepon_donatur' => 'nullable|string|max:20',
            'email_donatur' => 'nullable|email|max:255',
            'jumlah_donasi' => 'required|numeric|min:1',
            'tanggal_donasi' => 'required|date',
            'metode_pembayaran' => 'nullable|string|max:100',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'nomor_rekening_pengirim' => 'nullable|string|max:50',
            'bank_pengirim' => 'nullable|string|max:100',
            'catatan_donasi' => 'nullable|string',
            'status_verifikasi' => ['required', Rule::in(['Pending', 'Terverifikasi', 'Ditolak'])],
            'remove_bukti_pembayaran' => 'nullable|boolean',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus bukti lama jika ada
            if ($donasi->bukti_pembayaran && Storage::disk('public')->exists($donasi->bukti_pembayaran)) {
                Storage::disk('public')->delete($donasi->bukti_pembayaran);
            }
            $path = $request->file('bukti_pembayaran')->store('bukti_donasi', 'public');
            $validatedData['bukti_pembayaran'] = $path;
        } elseif ($request->boolean('remove_bukti_pembayaran')) {
            if ($donasi->bukti_pembayaran && Storage::disk('public')->exists($donasi->bukti_pembayaran)) {
                Storage::disk('public')->delete($donasi->bukti_pembayaran);
            }
            $validatedData['bukti_pembayaran'] = null;
        }
        unset($validatedData['remove_bukti_pembayaran']);


        $donasi->update($validatedData);

        return redirect()->route('admin.donasi.index')->with('success', 'Data donasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donasi $donasi)
    {
        if ($donasi->bukti_pembayaran && Storage::disk('public')->exists($donasi->bukti_pembayaran)) {
            Storage::disk('public')->delete($donasi->bukti_pembayaran);
        }
        $donasi->delete();

        return redirect()->route('admin.donasi.index')->with('success', 'Data donasi berhasil dihapus.');
    }
}