<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProfilPanti; // Kita akan buat model ini nanti

class ProfilPantiSeeder extends Seeder
{
    public function run(): void
    {
        // Hanya buat satu record jika belum ada
        if (ProfilPanti::count() == 0) {
            ProfilPanti::create([
                'slogan' => 'Slogan Awal Panti Harapan',
                'tentang_kami_deskripsi' => 'Isi deskripsi tentang kami di sini',
                'sejarah_singkat_deskripsi' => 'Isi deskripsi sejarah singkat disini',
                'visi_deskripsi' => 'Isi deskripsi visi disini',
                'misi_deskripsi' => 'isi deskripsi misi disini',
            ]);
        }
    }
}