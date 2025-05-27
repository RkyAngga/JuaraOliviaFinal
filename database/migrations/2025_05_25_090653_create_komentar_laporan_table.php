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
        Schema::create('komentar_laporan', function (Blueprint $table) {
            $table->id('komentar_id');
            $table->unsignedBigInteger('pengaduan_id');
            $table->unsignedBigInteger('user_id');
            $table->text('isi_komentar');
            $table->timestamps();

            $table->foreign('pengaduan_id')->references('id')->on('laporan_pengaduan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_laporan');
    }
};
