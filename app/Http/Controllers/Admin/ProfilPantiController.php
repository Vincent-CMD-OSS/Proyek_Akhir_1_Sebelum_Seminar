<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPanti;
use App\Models\StrukturOrganisasiAnggota;
use App\Models\TimPendiriAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule; 

class ProfilPantiController extends Controller
{
   public function edit()
    {
        $profil = ProfilPanti::getData();
        $editStrukturAnggota = session('editStrukturAnggota');
        $editTimPendiri = session('editTimPendiri');

        session()->forget(['editStrukturAnggota', 'editTimPendiri']);

        return view('admin.profil_panti.edit', [
            'profil' => $profil,
            'strukturAnggota' => $profil ? $profil->strukturOrganisasiAnggota()->orderBy('urutan')->get() : collect(),
            'timPendiri' => $profil ? $profil->timPendiriAnggota()->orderBy('urutan')->get() : collect(),
            'editStrukturAnggota' => $editStrukturAnggota,
            'editTimPendiri' => $editTimPendiri,
        ]);
    }

    public function update(Request $request)
    {
        $profil = ProfilPanti::getData();
        $imageFields = [
            'tentang_kami_img', 'sejarah_singkat_img', 'visi_misi_img',
            'struktur_organisasi_img_utama', 'tim_pendiri_img_utama', 'lokasi_img'
        ];
        $imageValidationRules = [];
        foreach ($imageFields as $imgField) {
            $imageValidationRules[$imgField] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }
        $validationRules = array_merge([
            'slogan' => 'nullable|string|max:255',
            'tentang_kami_deskripsi' => 'nullable|string',
            'sejarah_singkat_deskripsi' => 'nullable|string',
            'visi_deskripsi' => 'nullable|string',
            'misi_deskripsi' => 'nullable|string',
            'lokasi_deskripsi' => 'nullable|string',
        ], $imageValidationRules);
        $customAttributes = [];
        $validatedData = $request->validate($validationRules, [], $customAttributes);
        $dataToUpdate = $validatedData;
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                if ($profil->$field && Storage::disk('public')->exists($profil->$field)) {
                    Storage::disk('public')->delete($profil->$field);
                }
                $path = $request->file($field)->store('profil_panti_images', 'public');
                $dataToUpdate[$field] = $path;
            } elseif ($request->boolean("remove_{$field}")) {
                if ($profil->$field && Storage::disk('public')->exists($profil->$field)) {
                    Storage::disk('public')->delete($profil->$field);
                }
                $dataToUpdate[$field] = null;
            } else {
                if (array_key_exists($field, $dataToUpdate) && is_null($dataToUpdate[$field]) && !is_null($profil->$field)) {
                     unset($dataToUpdate[$field]);
                }
            }
        }
        $profil->update($dataToUpdate);
        return redirect()->route('admin.profil.panti.edit')->with('success', 'Profil panti berhasil diperbarui.');
    }

    // --- CRUD Struktur Organisasi Anggota ---
    public function storeStrukturAnggota(Request $request)
    {
        $profilPanti = ProfilPanti::getData();
        if (!$profilPanti) {
            return redirect()->route('admin.profil.panti.edit')->with('error', 'Profil Panti belum ada. Silakan simpan profil panti terlebih dahulu.');
        }

        try {
            $request->validate([
                'nama_anggota' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'foto_anggota' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'deskripsi_singkat' => 'nullable|string',
                'urutan' => [
                    'nullable',
                    'integer',
                    'min:0', // Sesuaikan jika urutan mulai dari 1, ganti jadi min:1
                    Rule::unique('struktur_organisasi_anggota', 'urutan')
                        ->where(function ($query) use ($profilPanti) {
                            return $query->where('profil_panti_id', $profilPanti->id);
                        }),
                    // Parameter: nama_tabel, nama_kolom_fk, nilai_fk
                    'sequential_order:struktur_organisasi_anggota,profil_panti_id,'.$profilPanti->id,
                ],
            ], [
                'urutan.unique' => 'Nilai urutan ini sudah digunakan untuk anggota struktur lain.',
                'urutan.sequential_order' => 'Urutan anggota struktur tidak berurutan. Pastikan urutan sebelumnya telah ada.',
            ]);

            $validatedData = $request->all();
            $validatedData['profil_panti_id'] = $profilPanti->id;

            // Otomatisasi urutan jika kosong
            if (!isset($validatedData['urutan']) || is_null($validatedData['urutan'])) {
                $maxUrutan = StrukturOrganisasiAnggota::where('profil_panti_id', $profilPanti->id)->max('urutan');
                // Jika urutanmu mulai dari 0, $startOrder = 0. Jika dari 1, $startOrder = 1.
                $startOrder = 0;
                $validatedData['urutan'] = is_null($maxUrutan) ? $startOrder : $maxUrutan + 1;
            }

            if ($request->hasFile('foto_anggota')) {
                $path = $request->file('foto_anggota')->store('struktur_anggota_images', 'public');
                $validatedData['foto_anggota'] = $path;
            }

            StrukturOrganisasiAnggota::create($validatedData);
            return redirect()->route('admin.profil.panti.edit')->with('success_struktur', 'Anggota struktur berhasil ditambahkan.');

        } catch (ValidationException $e) {
            return redirect()->route('admin.profil.panti.edit')
                ->withErrors($e->validator, 'struktur_store')
                ->withInput();
        }
    }

    public function editStrukturAnggota(StrukturOrganisasiAnggota $strukturOrganisasiAnggota)
    {
        return redirect()->route('admin.profil.panti.edit')
            ->with('editStrukturAnggota', $strukturOrganisasiAnggota);
    }

    public function updateStrukturAnggota(Request $request, StrukturOrganisasiAnggota $strukturOrganisasiAnggota)
    {
        $profilPanti = ProfilPanti::getData(); // atau $strukturOrganisasiAnggota->profilPanti
        if (!$profilPanti) {
             return redirect()->route('admin.profil.panti.edit')->with('error', 'Profil Panti tidak ditemukan.');
        }
        $errorBagName = 'struktur_update_' . $strukturOrganisasiAnggota->id;
        try {
            $request->validate([
                'nama_anggota' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'foto_anggota' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'deskripsi_singkat' => 'nullable|string',
                'urutan' => [
                    'nullable',
                    'integer',
                    'min:0', // Sesuaikan jika urutan mulai dari 1
                    Rule::unique('struktur_organisasi_anggota', 'urutan')
                        ->where(function ($query) use ($profilPanti) {
                            return $query->where('profil_panti_id', $profilPanti->id);
                        })
                        ->ignore($strukturOrganisasiAnggota->id),
                    // Parameter: nama_tabel, nama_kolom_fk, nilai_fk, nama_kolom_id, id_yang_diabaikan
                    'sequential_order:struktur_organisasi_anggota,profil_panti_id,'.$profilPanti->id.',id,'.$strukturOrganisasiAnggota->id,
                ],
                'remove_foto_anggota' => 'nullable|boolean',
            ],[
                'urutan.unique' => 'Nilai urutan ini sudah digunakan untuk anggota struktur lain.',
                'urutan.sequential_order' => 'Urutan anggota struktur tidak berurutan. Pastikan urutan sebelumnya telah ada.',
            ]);

            $dataToUpdate = $request->except(['_token', '_method', 'remove_foto_anggota']);
            // Jika 'urutan' kosong saat update, kita asumsikan user ingin mengosongkannya (jadi null)
            // atau biarkan apa adanya jika tidak diubah. Jika ingin mempertahankan nilai lama jika tidak diisi,
            // perlu logika tambahan.
            if ($request->filled('urutan')) {
                $dataToUpdate['urutan'] = $request->urutan;
            } else if (array_key_exists('urutan', $dataToUpdate) && is_null($request->urutan) && $request->has('urutan')) {
                // Jika 'urutan' ada di request tapi nilainya null (misal dikosongkan di form)
                $dataToUpdate['urutan'] = null;
            } else {
                // Jika 'urutan' tidak ada di request sama sekali, jangan ubah nilai yg ada di DB
                unset($dataToUpdate['urutan']);
            }


            if ($request->hasFile('foto_anggota')) {
                if ($strukturOrganisasiAnggota->foto_anggota && Storage::disk('public')->exists($strukturOrganisasiAnggota->foto_anggota)) {
                    Storage::disk('public')->delete($strukturOrganisasiAnggota->foto_anggota);
                }
                $path = $request->file('foto_anggota')->store('struktur_anggota_images', 'public');
                $dataToUpdate['foto_anggota'] = $path;
            } elseif ($request->boolean('remove_foto_anggota')) {
                if ($strukturOrganisasiAnggota->foto_anggota && Storage::disk('public')->exists($strukturOrganisasiAnggota->foto_anggota)) {
                    Storage::disk('public')->delete($strukturOrganisasiAnggota->foto_anggota);
                }
                $dataToUpdate['foto_anggota'] = null;
            }

            $strukturOrganisasiAnggota->update($dataToUpdate);
            return redirect()->route('admin.profil.panti.edit')->with('success_struktur', 'Anggota struktur berhasil diperbarui.');

        } catch (ValidationException $e) {
            return redirect()->route('admin.profil.panti.edit')
                ->withErrors($e->validator, $errorBagName)
                ->withInput()
                ->with('editStrukturAnggota', $strukturOrganisasiAnggota);
        }
    }

    public function destroyStrukturAnggota(StrukturOrganisasiAnggota $strukturOrganisasiAnggota)
    {
        $profilPantiId = $strukturOrganisasiAnggota->profil_panti_id;
        $deletedOrder = $strukturOrganisasiAnggota->urutan;

        if ($strukturOrganisasiAnggota->foto_anggota && Storage::disk('public')->exists($strukturOrganisasiAnggota->foto_anggota)) {
            Storage::disk('public')->delete($strukturOrganisasiAnggota->foto_anggota);
        }
        $strukturOrganisasiAnggota->delete();

        // Re-order setelah hapus (opsional, tapi baik)
        if (!is_null($deletedOrder)) {
            StrukturOrganisasiAnggota::where('profil_panti_id', $profilPantiId)
                ->where('urutan', '>', $deletedOrder)
                ->decrement('urutan');
        }

        return redirect()->route('admin.profil.panti.edit')->with('success_struktur', 'Anggota struktur berhasil dihapus.');
    }


    // --- CRUD Tim Pendiri Anggota ---
    public function storeTimPendiri(Request $request)
    {
        $profilPanti = ProfilPanti::getData();
        if (!$profilPanti) {
            return redirect()->route('admin.profil.panti.edit')->with('error', 'Profil Panti belum ada. Silakan simpan profil panti terlebih dahulu.');
        }
        try {
            $request->validate([
                'nama_pendiri' => 'required|string|max:255',
                'peran_atau_jabatan' => 'nullable|string|max:255',
                'deskripsi_kontribusi' => 'nullable|string',
                'foto_pendiri' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'urutan' => [
                    'nullable',
                    'integer',
                    'min:0', // Sesuaikan jika urutan mulai dari 1
                    Rule::unique('tim_pendiri_anggota', 'urutan')
                        ->where(function ($query) use ($profilPanti) {
                            return $query->where('profil_panti_id', $profilPanti->id);
                        }),
                    'sequential_order:tim_pendiri_anggota,profil_panti_id,'.$profilPanti->id,
                ],
            ],[
                'urutan.unique' => 'Nilai urutan ini sudah digunakan untuk anggota tim pendiri lain.',
                'urutan.sequential_order' => 'Urutan anggota tim pendiri tidak berurutan. Pastikan urutan sebelumnya telah ada.',
            ]);

            $validatedData = $request->all();
            $validatedData['profil_panti_id'] = $profilPanti->id;

            if (!isset($validatedData['urutan']) || is_null($validatedData['urutan'])) {
                $maxUrutan = TimPendiriAnggota::where('profil_panti_id', $profilPanti->id)->max('urutan');
                $startOrder = 0; // Sesuaikan jika mulai dari 1
                $validatedData['urutan'] = is_null($maxUrutan) ? $startOrder : $maxUrutan + 1;
            }

            if ($request->hasFile('foto_pendiri')) {
                $path = $request->file('foto_pendiri')->store('pendiri_anggota_images', 'public');
                $validatedData['foto_pendiri'] = $path;
            }

            TimPendiriAnggota::create($validatedData);
            return redirect()->route('admin.profil.panti.edit')->with('success_pendiri', 'Anggota tim pendiri berhasil ditambahkan.');

        } catch (ValidationException $e) {
            return redirect()->route('admin.profil.panti.edit')
                ->withErrors($e->validator, 'pendiri_store')
                ->withInput();
        }
    }

    public function editTimPendiri(TimPendiriAnggota $timPendiriAnggota)
    {
        return redirect()->route('admin.profil.panti.edit')
            ->with('editTimPendiri', $timPendiriAnggota);
    }

    public function updateTimPendiri(Request $request, TimPendiriAnggota $timPendiriAnggota)
    {
        $profilPanti = ProfilPanti::getData(); // atau $timPendiriAnggota->profilPanti
         if (!$profilPanti) {
             return redirect()->route('admin.profil.panti.edit')->with('error', 'Profil Panti tidak ditemukan.');
        }
        $errorBagName = 'pendiri_update_' . $timPendiriAnggota->id;
        try {
            $request->validate([
                'nama_pendiri' => 'required|string|max:255',
                'peran_atau_jabatan' => 'nullable|string|max:255',
                'deskripsi_kontribusi' => 'nullable|string',
                'foto_pendiri' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'urutan' => [
                    'nullable',
                    'integer',
                    'min:0', // Sesuaikan jika urutan mulai dari 1
                    Rule::unique('tim_pendiri_anggota', 'urutan')
                        ->where(function ($query) use ($profilPanti) {
                            return $query->where('profil_panti_id', $profilPanti->id);
                        })
                        ->ignore($timPendiriAnggota->id),
                    'sequential_order:tim_pendiri_anggota,profil_panti_id,'.$profilPanti->id.',id,'.$timPendiriAnggota->id,
                ],
                'remove_foto_pendiri' => 'nullable|boolean',
            ],[
                'urutan.unique' => 'Nilai urutan ini sudah digunakan untuk anggota tim pendiri lain.',
                'urutan.sequential_order' => 'Urutan anggota tim pendiri tidak berurutan. Pastikan urutan sebelumnya telah ada.',
            ]);

            $dataToUpdate = $request->except(['_token', '_method', 'remove_foto_pendiri']);

            if ($request->filled('urutan')) {
                $dataToUpdate['urutan'] = $request->urutan;
            } else if (array_key_exists('urutan', $dataToUpdate) && is_null($request->urutan) && $request->has('urutan')) {
                $dataToUpdate['urutan'] = null;
            } else {
                unset($dataToUpdate['urutan']);
            }


            if ($request->hasFile('foto_pendiri')) {
                if ($timPendiriAnggota->foto_pendiri && Storage::disk('public')->exists($timPendiriAnggota->foto_pendiri)) {
                    Storage::disk('public')->delete($timPendiriAnggota->foto_pendiri);
                }
                $path = $request->file('foto_pendiri')->store('pendiri_anggota_images', 'public');
                $dataToUpdate['foto_pendiri'] = $path;
            } elseif ($request->boolean('remove_foto_pendiri')) {
                if ($timPendiriAnggota->foto_pendiri && Storage::disk('public')->exists($timPendiriAnggota->foto_pendiri)) {
                    Storage::disk('public')->delete($timPendiriAnggota->foto_pendiri);
                }
                $dataToUpdate['foto_pendiri'] = null;
            }

            $timPendiriAnggota->update($dataToUpdate);
            return redirect()->route('admin.profil.panti.edit')->with('success_pendiri', 'Anggota tim pendiri berhasil diperbarui.');

        } catch (ValidationException $e) {
            return redirect()->route('admin.profil.panti.edit')
                ->withErrors($e->validator, $errorBagName)
                ->withInput()
                ->with('editTimPendiri', $timPendiriAnggota);
        }
    }

    public function destroyTimPendiri(TimPendiriAnggota $timPendiriAnggota)
    {
        $profilPantiId = $timPendiriAnggota->profil_panti_id;
        $deletedOrder = $timPendiriAnggota->urutan;

        if ($timPendiriAnggota->foto_pendiri && Storage::disk('public')->exists($timPendiriAnggota->foto_pendiri)) {
            Storage::disk('public')->delete($timPendiriAnggota->foto_pendiri);
        }
        $timPendiriAnggota->delete();

        // Re-order setelah hapus (opsional, tapi baik)
        if (!is_null($deletedOrder)) {
            TimPendiriAnggota::where('profil_panti_id', $profilPantiId)
                ->where('urutan', '>', $deletedOrder)
                ->decrement('urutan');
        }

        return redirect()->route('admin.profil.panti.edit')->with('success_pendiri', 'Anggota tim pendiri berhasil dihapus.');
    }
}