<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kebutuhan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kebutuhan');
            $table->text('deskripsi');
            $table->enum('status_kebutuhan', ['Draft', 'Aktif', 'Tercapai', 'Dibatalkan'])->default('Draft');
            $table->decimal('target_dana', 15, 2)->nullable(); // 15 digit total, 2 digit desimal
            $table->decimal('dana_terkumpul', 15, 2)->default(0.00);
            $table->date('tanggal_mulai_dipublikasikan')->nullable();
            $table->date('tanggal_target_tercapai')->nullable();
            $table->string('gambar_kebutuhan')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kebutuhan');
    }
};