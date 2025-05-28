<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_panti', function (Blueprint $table) {
            $table->id();
            $table->string('slogan')->nullable();
            $table->longText('tentang_kami_deskripsi')->nullable();
            $table->string('tentang_kami_img')->nullable();
            $table->longText('sejarah_singkat_deskripsi')->nullable();
            $table->string('sejarah_singkat_img')->nullable();
            $table->text('visi_deskripsi')->nullable();
            $table->longText('misi_deskripsi')->nullable();
            $table->string('visi_misi_img')->nullable();
            $table->string('struktur_organisasi_img_utama')->nullable(); // Gambar bagan utama
            $table->string('tim_pendiri_img_utama')->nullable(); // Gambar grup utama
            $table->longText('lokasi_deskripsi')->nullable();
            $table->string('lokasi_img')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_panti');
    }
};