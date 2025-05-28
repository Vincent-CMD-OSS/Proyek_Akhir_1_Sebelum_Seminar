<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tim_pendiri_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_panti_id')->constrained('profil_panti')->onDelete('cascade'); // Relasi ke profil_panti
            $table->string('nama_pendiri');
            $table->string('peran_atau_jabatan')->nullable();
            $table->text('deskripsi_kontribusi')->nullable();
            $table->string('foto_pendiri')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tim_pendiri_anggota');
    }
};