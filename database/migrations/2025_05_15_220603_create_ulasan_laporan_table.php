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
        Schema::create('ulasan_laporan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporan_id')->unique();
            $table->unsignedBigInteger('masyarakat_id');
            $table->tinyInteger('rating');
            $table->text('ulasan');
            $table->timestamps();

            $table->foreign('laporan_id')->references('id')->on('laporan_pengaduan')->onDelete('cascade');
            $table->foreign('masyarakat_id')->references('id')->on('masyarakat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan_laporan');
    }
};
