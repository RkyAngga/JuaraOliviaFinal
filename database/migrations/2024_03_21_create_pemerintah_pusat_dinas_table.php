<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pemerintah_pusat_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dinas_id')->constrained('dinas')->onDelete('cascade');
            $table->string('username');
            $table->string('nomor_telepon', 15);
            $table->string('email');
            $table->string('wilayah');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();

            // Membuat kombinasi user_id dan dinas_id unik
            $table->unique(['user_id', 'dinas_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemerintah_pusat_dinas');
    }
}; 