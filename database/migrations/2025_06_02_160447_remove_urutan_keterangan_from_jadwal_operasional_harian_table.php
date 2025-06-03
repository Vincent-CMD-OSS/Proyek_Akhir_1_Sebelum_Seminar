<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // dalam file migration yang baru dibuat
    public function up(): void
    {
        Schema::table('jadwal_operasional_harian', function (Blueprint $table) {
            $table->dropColumn(['urutan', 'keterangan']);
            // Mungkin ubah kolom hari menjadi unique agar hanya ada 1 entri per hari
            // $table->unique('hari'); // Pertimbangkan ini
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_operasional_harian', function (Blueprint $table) {
            $table->integer('urutan')->default(0)->after('status_operasional');
            $table->string('keterangan')->nullable()->after('urutan');
            // $table->dropUnique(['hari']); // Jika menambahkan unique di up()
        });
    }
};
