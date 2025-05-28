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
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal_kegiatan')->nullable(); // Bisa jadi tanggal upload jika bukan kegiatan spesifik
            $table->string('lokasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar'); // Path ke file gambar, tidak nullable karena galeri harus ada gambar
            $table->string('slug')->unique()->nullable(); // SEO friendly URL, bisa di-generate dari judul
            $table->enum('status_publikasi', ['draft', 'published'])->default('draft');
            // Jika ingin lebih sederhana, bisa pakai boolean:
            // $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};