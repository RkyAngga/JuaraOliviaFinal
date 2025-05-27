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
        // Schema::create('dinas', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        //     $table->string('wilayah', 100);
        //     $table->decimal('latitude', 10, 7)->nullable();
        //     $table->decimal('longitude', 10, 7)->nullable();
        //     $table->json('polygon_wilayah')->nullable();
        //     $table->enum('grade', ['A', 'B', 'C', 'D', 'E']);
        //     $table->integer('point')->default(0);
        //     $table->timestamps();
        // });
        // Kosongkan metode up() agar tidak mencoba membuat tabel lagi
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('dinas');
        // Kosongkan metode down()
    }
};
