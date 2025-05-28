<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_operasional_harian', function (Blueprint $table) {
            $table->id();
            // Kolom hari bisa dibuat unik jika kita hanya ingin satu entri jam buka/tutup per hari.
            // Tapi jika ingin ada beberapa slot waktu dalam satu hari (misal pagi buka, siang istirahat/tutup, sore buka lagi),
            // maka 'hari' tidak boleh unik, dan kita perlu 'urutan' atau cara lain untuk mengelola slot.
            // Untuk kasus "dari jam berapa sampai jam berapa aja mereka bisa dikunjungi dan tidak",
            // satu entri per hari dengan jam_buka dan jam_tutup, lalu status, sudah cukup.
            // Jika ada istirahat, itu bisa jadi entri lain dengan status 'Tutup'.
            // Mari kita asumsikan bisa ada beberapa slot per hari.
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->enum('status_operasional', ['Buka', 'Tutup'])->default('Buka');
            $table->string('keterangan')->nullable();
            $table->integer('urutan')->default(0); // Untuk mengurutkan slot waktu dalam satu hari
            $table->timestamps();

            // Opsional: index untuk query yang lebih cepat
            $table->index('hari');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_operasional_harian');
    }
};