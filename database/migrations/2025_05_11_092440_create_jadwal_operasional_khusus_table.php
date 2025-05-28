<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_operasional_khusus', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique(); // Tanggal spesifik, harus unik
            $table->string('nama_acara_libur');
            $table->enum('status_operasional', ['Buka', 'Tutup', 'Jam Khusus']);
            $table->time('jam_buka_khusus')->nullable();
            $table->time('jam_tutup_khusus')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_operasional_khusus');
    }
};