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
        Schema::create('identitas_panti', function (Blueprint $table) {
            $table->id();
            $table->string('nama_panti')->nullable();
            $table->text('lokasi_gmaps')->nullable(); // Untuk iframe atau link Google Maps
            $table->string('nomor_wa')->nullable();
            $table->string('email_panti')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_panti');
    }
};