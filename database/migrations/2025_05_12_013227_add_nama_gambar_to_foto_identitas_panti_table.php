<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('foto_identitas_panti', function (Blueprint $table) {
            $table->string('nama_gambar')->nullable()->after('identitas_panti_id'); // Atau sesuaikan posisi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foto_identitas_panti', function (Blueprint $table) {
            $table->dropColumn('nama_gambar');
        });
    }
};