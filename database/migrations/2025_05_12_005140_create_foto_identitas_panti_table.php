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
        Schema::create('foto_identitas_panti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitas_panti_id')->constrained('identitas_panti')->onDelete('cascade');
            $table->string('file_path');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_identitas_panti');
    }
};