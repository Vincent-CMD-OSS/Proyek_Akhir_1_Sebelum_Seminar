<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengunjung');
            $table->string('kontak_whatsapp')->nullable(); // Nomor WA
            $table->string('email_pengunjung')->nullable(); // Email
            $table->date('tanggal_rencana_kunjungan'); // Tanggal yang dipilih user
            $table->time('jam_rencana_kunjungan');    // Jam yang dipilih user
            // Atau bisa juga satu field datetime: $table->dateTime('waktu_rencana_kunjungan');
            // Namun, memisahkan tanggal dan jam bisa lebih mudah untuk query berdasarkan hari/jam operasional

            $table->text('catatan_pengunjung')->nullable(); // Catatan dari pengunjung
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending');
            $table->text('alasan_penolakan')->nullable();   // Jika ditolak
            $table->text('catatan_admin')->nullable();      // Catatan dari admin (misal untuk internal atau info tambahan saat disetujui)
            $table->foreignId('admin_id_yang_memproses')->nullable()->constrained('users')->onDelete('set null'); // Jika diintegrasikan dengan user admin
            $table->timestamp('diproses_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_kunjungan');
    }
};