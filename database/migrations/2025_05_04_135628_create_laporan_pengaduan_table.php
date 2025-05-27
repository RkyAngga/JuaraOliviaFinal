<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('laporan_pengaduan', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('masyarakat_id');
        $table->unsignedBigInteger('dinas_id')->nullable();
        $table->text('lokasi');
        $table->decimal('latitude', 10, 7);
        $table->decimal('longitude', 10, 7);
        $table->text('foto_video');
        $table->text('deskripsi')->nullable();
        $table->enum('status', ['Menunggu', 'Di Proses', 'Selesai', 'Ditolak'])->default('Menunggu');
        $table->timestamp('timestamp')->useCurrent();
        $table->unsignedBigInteger('related_pengaduan_id')->nullable();
        $table->timestamps();

        $table->foreign('masyarakat_id')->references('id')->on('masyarakat')->onDelete('cascade');
        $table->foreign('dinas_id')->references('id')->on('dinas')->onDelete('set null');
        $table->foreign('related_pengaduan_id')->references('id')->on('laporan_pengaduan')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pengaduan');
    }
};
