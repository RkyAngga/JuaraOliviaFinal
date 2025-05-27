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
        Schema::create('penyelesaian_laporan', function (Blueprint $table) {
            $table->id('penyelesaian_laporan_id');
            $table->unsignedBigInteger('pengaduan_id');
            $table->unsignedBigInteger('dinas_id');
            $table->text('foto_penyelesaian')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['On-Progress', 'Selesai', 'Ditolak'])->default('On-Progress');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();

            $table->foreign('pengaduan_id')->references('id')->on('laporan_pengaduan')->onDelete('cascade');
            $table->foreign('dinas_id')->references('id')->on('dinas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyelesaian_laporan');
    }
};
