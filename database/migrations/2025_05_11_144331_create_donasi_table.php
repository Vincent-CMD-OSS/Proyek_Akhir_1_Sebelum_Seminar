<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            // Relasi ke kebutuhan, nullable jika donasi umum
            $table->foreignId('kebutuhan_id')->nullable()->constrained('kebutuhan')->onDelete('set null'); // Jika kebutuhan dihapus, donasi jadi umum

            $table->string('nama_donatur');
            $table->string('nomor_telepon_donatur')->nullable();
            $table->string('email_donatur')->nullable();
            $table->decimal('jumlah_donasi', 15, 2);
            $table->date('tanggal_donasi');
            $table->string('metode_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable(); // Path ke gambar bukti
            $table->string('nomor_rekening_pengirim')->nullable();
            $table->string('bank_pengirim')->nullable();
            $table->text('catatan_donasi')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Terverifikasi', 'Ditolak'])->default('Pending');
            // $table->foreignId('user_id')->nullable()->constrained('users')->comment('Admin yang mencatat'); // Opsional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};