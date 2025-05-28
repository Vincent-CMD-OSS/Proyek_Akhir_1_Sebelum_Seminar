<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerimaan_dana_kebutuhan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kebutuhan_id')->constrained('kebutuhan')->onDelete('cascade');
            $table->decimal('jumlah_dana_diterima', 15, 2);
            $table->string('nama_pemberi')->default('Hamba Allah');
            $table->date('tanggal_diterima');
            $table->string('metode_pembayaran')->nullable();
            $table->text('catatan_penerimaan')->nullable();
            // $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Jika ingin melacak siapa admin yang mencatat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerimaan_dana_kebutuhan');
    }
};