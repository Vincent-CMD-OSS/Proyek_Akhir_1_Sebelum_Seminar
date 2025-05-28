<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdentitasPanti;
use App\Models\FotoIdentitasPanti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; // Tambahkan ini

class IdentitasPantiController extends Controller
{
    // ID default untuk identitas panti, karena kita asumsikan hanya ada satu.
    protected $identitasPantiId = 1;

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Cari atau buat entri IdentitasPanti jika belum ada (dengan ID 1)
        $identitasPanti = IdentitasPanti::firstOrCreate(
            ['id' => $this->identitasPantiId],
            [
                'nama_panti' => 'Nama Panti Asuhan Anda', // Nilai default
                // Anda bisa menambahkan nilai default lainnya di sini jika perlu
            ]
        );

        $fotos = FotoIdentitasPanti::where('identitas_panti_id', $identitasPanti->id)->orderBy('created_at', 'asc')->get();

        return view('admin.identitas_panti.edit', compact('identitasPanti', 'fotos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $identitasPanti = IdentitasPanti::findOrFail($this->identitasPantiId);

        $validator = Validator::make($request->all(), [
            'nama_panti' => 'nullable|string|max:255',
            'lokasi_gmaps' => 'nullable|string',
            'nomor_wa' => 'nullable|string|max:20',
            'email_panti' => 'nullable|email|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.identitas_panti.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $identitasPanti->update($request->only([
            'nama_panti',
            'lokasi_gmaps',
            'nomor_wa',
            'email_panti',
            'facebook_url',
            'youtube_url',
            'instagram_url',
        ]));

        return redirect()->route('admin.identitas_panti.edit')->with('success', 'Identitas panti berhasil diperbarui.');
    }

    /**
     * Store a newly created foto resource in storage.
     */
    public function storeFoto(Request $request)
    {
        $identitasPanti = IdentitasPanti::findOrFail($this->identitasPantiId);

        if ($identitasPanti->fotos()->count() >= 8) {
            return redirect()->route('admin.identitas_panti.edit')
                ->with('error_foto', 'Maksimal 8 foto yang dapat diunggah.');
        }

        // Gunakan 'nama_gambar_baru' untuk form tambah agar tidak bentrok dengan form edit
        $validator = Validator::make($request->all(), [
            'nama_gambar_baru' => 'required|string|max:255', // Validasi untuk nama gambar baru
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'keterangan_foto_baru' => 'nullable|string|max:255', // Ubah nama input keterangan juga
        ], [], [
            'nama_gambar_baru' => 'nama gambar',
            'keterangan_foto_baru' => 'keterangan foto'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.identitas_panti.edit')
                ->withErrors($validator, 'fotoStore')
                ->withInput();
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $identitasPanti->id . '_' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/identitas_panti/fotos', $filename);

            FotoIdentitasPanti::create([
                'identitas_panti_id' => $identitasPanti->id,
                'nama_gambar' => $request->input('nama_gambar_baru'), // Simpan nama gambar baru
                'file_path' => 'identitas_panti/fotos/' . $filename,
                'keterangan' => $request->input('keterangan_foto_baru'), // Simpan keterangan baru
            ]);

            return redirect()->route('admin.identitas_panti.edit')->with('success_foto', 'Foto berhasil ditambahkan.');
        }

        return redirect()->route('admin.identitas_panti.edit')->with('error_foto', 'Gagal menambahkan foto.');
    }

    /**
     * Remove the specified foto resource from storage.
     */
    public function destroyFoto(FotoIdentitasPanti $foto)
    {
        if ($foto->identitas_panti_id != $this->identitasPantiId) {
             return redirect()->route('admin.identitas_panti.edit')->with('error_foto', 'Aksi tidak diizinkan.');
        }

        if (Storage::disk('public')->exists($foto->file_path)) {
            Storage::disk('public')->delete($foto->file_path);
        }
        $foto->delete();
        return redirect()->route('admin.identitas_panti.edit')->with('success_foto', 'Foto berhasil dihapus.');
    }

    /**
     * Show the form for editing the specified foto's keterangan.
     * (Opsional, jika ingin form edit keterangan foto terpisah)
     */
    public function editFotoKeterangan(FotoIdentitasPanti $foto)
    {
        // Logika untuk menampilkan form edit keterangan foto
        return view('admin.identitas_panti.partials._edit_foto_keterangan_modal', compact('foto'));
    }

    /**
     * Update the specified foto's keterangan in storage.
     * (Opsional, jika ingin form edit keterangan foto terpisah)
     */
    public function updateFotoKeterangan(Request $request, FotoIdentitasPanti $foto)
    {
        if ($foto->identitas_panti_id != $this->identitasPantiId) {
             return redirect()->route('admin.identitas_panti.edit')
                              ->with('error_foto', 'Aksi tidak diizinkan.');
        }

        $namaGambarInput = 'nama_gambar_edit_' . $foto->id;
        $keteranganInput = 'keterangan_edit_' . $foto->id;
        $errorBagName = 'fotoUpdate_' . $foto->id;

        $validator = Validator::make($request->all(), [
            $namaGambarInput => 'required|string|max:255', // Validasi untuk nama gambar saat edit
            $keteranganInput => 'nullable|string|max:255',
        ],
        [], // Pesan kustom jika ada
        [
            $namaGambarInput => 'nama gambar',
            $keteranganInput => 'keterangan',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.identitas_panti.edit')
                ->withErrors($validator, $errorBagName)
                ->with('edit_keterangan_foto_id_error', $foto->id)
                ->withInput();
        }

        $foto->update([
            'nama_gambar' => $request->input($namaGambarInput), // Update nama gambar
            'keterangan' => $request->input($keteranganInput)
        ]);

        return redirect()->route('admin.identitas_panti.edit')
                         ->with('success_foto', 'Detail foto berhasil diperbarui.');
    }
}