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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('notifikasi_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pengaduan_id')->nullable();
            $table->string('judul_notifikasi');
            $table->text('isi_notifikasi');
            $table->enum('status_notifikasi', ['Terkirim', 'Dibaca', 'Tindak Lanjut'])->default('Terkirim');
            $table->enum('jenis_notifikasi', ['Terlambat', 'Penolakan', 'Verifikasi']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pengaduan_id')->references('id')->on('laporan_pengaduan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
