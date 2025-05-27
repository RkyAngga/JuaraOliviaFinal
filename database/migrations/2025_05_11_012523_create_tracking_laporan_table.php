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
        Schema::create('tracking_laporan', function (Blueprint $table) {
            $table->id('tracking_id');
            $table->unsignedBigInteger('pengaduan_id');
            $table->enum('status', ['Menunggu', 'Di Proses', 'Selesai', 'Ditolak']);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('pengaduan_id')->references('id')->on('laporan_pengaduan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_laporan');
    }
};
