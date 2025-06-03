<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PermintaanKunjungan;
// use App\Models\IdentitasPanti; // Tidak digunakan langsung di store
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PermintaanKunjunganController extends Controller
{
    public function store(Request $request)
    {
        // Gunakan error bag default agar @error() di Blade bekerja tanpa nama bag
        $validator = Validator::make($request->all(), [
            'nama_pengunjung' => 'required|string|max:255',
            'kontak_whatsapp' => 'nullable|required_without:email_pengunjung|string|max:20|regex:/^08[0-9]{8,12}$/', // Validasi format nomor WA Indonesia
            'email_pengunjung' => 'nullable|required_without:kontak_whatsapp|email|max:255',
            'tanggal_rencana_kunjungan' => 'required|date|after_or_equal:' . Carbon::now(config('app.timezone'))->toDateString(),
            'jam_rencana_kunjungan' => 'required|date_format:H:i',
            'catatan_pengunjung' => 'nullable|string|max:1000',
            'hari_kunjungan_pilihan' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_buka_pilihan' => 'required|date_format:H:i',
            'jam_tutup_pilihan' => 'required|date_format:H:i|after:jam_buka_pilihan',
        ], [
            'nama_pengunjung.required' => 'Nama lengkap wajib diisi.',
            'kontak_whatsapp.required_without' => 'Mohon isi Nomor WhatsApp jika Email kosong.',
            'kontak_whatsapp.regex' => 'Format Nomor WhatsApp tidak valid (contoh: 081234567890).',
            'email_pengunjung.required_without' => 'Mohon isi Alamat Email jika Nomor WhatsApp kosong.',
            'email_pengunjung.email' => 'Format alamat email tidak valid.',
            'tanggal_rencana_kunjungan.required' => 'Tanggal rencana kunjungan wajib diisi.',
            'tanggal_rencana_kunjungan.date' => 'Format tanggal tidak valid.',
            'tanggal_rencana_kunjungan.after_or_equal' => 'Tanggal kunjungan minimal adalah hari ini.',
            'jam_rencana_kunjungan.required' => 'Jam rencana kunjungan wajib diisi.',
            'jam_rencana_kunjungan.date_format' => 'Format jam tidak valid (Contoh: 10:00).',
            'jam_tutup_pilihan.after' => 'Jam tutup pilihan tidak valid.', // Error ini seharusnya tidak muncul jika data dari button benar
        ]);

        // Validasi tambahan yang lebih kompleks
        $validator->after(function ($validatorInstance) use ($request) {
            if ($request->filled('tanggal_rencana_kunjungan') && $request->filled('hari_kunjungan_pilihan')) {
                try {
                    $hariDipilihPengguna = Carbon::parse($request->tanggal_rencana_kunjungan, config('app.timezone'))->isoFormat('dddd');
                    if ($hariDipilihPengguna !== $request->hari_kunjungan_pilihan) {
                        $validatorInstance->errors()->add('tanggal_rencana_kunjungan', 'Hari pada tanggal yang Anda pilih (' . $hariDipilihPengguna . ') tidak sesuai dengan hari operasional yang dipilih (' . $request->hari_kunjungan_pilihan . ').');
                    }
                } catch (\Exception $e) {
                    $validatorInstance->errors()->add('tanggal_rencana_kunjungan', 'Format tanggal tidak dapat diproses.');
                }
            }

            if ($request->filled('jam_rencana_kunjungan') && $request->filled('jam_buka_pilihan') && $request->filled('jam_tutup_pilihan')) {
                try {
                    $jamRencana = Carbon::parse($request->jam_rencana_kunjungan);
                    $jamBukaPilihan = Carbon::parse($request->jam_buka_pilihan);
                    $jamTutupPilihan = Carbon::parse($request->jam_tutup_pilihan);

                    if (!$jamRencana->betweenIncluded($jamBukaPilihan, $jamTutupPilihan)) {
                        $validatorInstance->errors()->add('jam_rencana_kunjungan', 'Jam rencana kunjungan di luar jam operasional (' . $request->jam_buka_pilihan . ' - ' . $request->jam_tutup_pilihan . ').');
                    }
                } catch (\Exception $e) {
                     $validatorInstance->errors()->add('jam_rencana_kunjungan', 'Format jam tidak dapat diproses.');
                }
            }
        });


        if ($validator->fails()) {
            // Redirect kembali ke URL sebelumnya dengan anchor ke modal
            // dan flash session untuk menandakan modal harus terbuka karena error validasi
            return redirect(url()->previous() . '#modalPermintaanKunjungan')
                             ->withErrors($validator)
                             ->withInput()
                             ->with('open_modal_kunjungan_error', true); // Nama session flash diubah
        }

        PermintaanKunjungan::create([
            'nama_pengunjung' => $request->nama_pengunjung,
            'kontak_whatsapp' => $request->kontak_whatsapp,
            'email_pengunjung' => $request->email_pengunjung,
            'tanggal_rencana_kunjungan' => $request->tanggal_rencana_kunjungan,
            'jam_rencana_kunjungan' => $request->jam_rencana_kunjungan,
            'catatan_pengunjung' => $request->catatan_pengunjung,
            'status' => 'pending',
        ]);

        return redirect()->route('public.operasional.index')
                         ->with('success_kunjungan', 'Permintaan kunjungan Anda telah terkirim. Kami akan segera menghubungi Anda untuk konfirmasi.');
    }
}