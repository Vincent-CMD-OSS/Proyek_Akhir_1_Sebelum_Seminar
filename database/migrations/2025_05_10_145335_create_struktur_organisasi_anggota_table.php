<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_organisasi_anggota', function (Blueprint $table) {
            $table->id();
            // Relasi ke profil_panti (jika panti hanya ada satu, ini tetap berguna untuk konsistensi)
            // Jika kamu yakin hanya ada satu profil_panti dan tidak akan pernah ada lebih,
            // foreign key ini bisa dipertimbangkan untuk dihilangkan dari tabel anggota,
            // TAPI lebih baik tetap ada untuk struktur data yang lebih robus dan antisipasi masa depan.
            // Asumsi kita tetap pakai foreign key.
            $table->foreignId('profil_panti_id')->constrained('profil_panti')->onDelete('cascade');
            $table->string('nama_anggota');
            $table->string('jabatan');
            $table->string('foto_anggota')->nullable();
            $table->text('deskripsi_singkat')->nullable(); // Opsional, jika ada deskripsi per anggota
            $table->integer('urutan')->default(0); // Untuk mengatur urutan tampil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_organisasi_anggota');
    }
};