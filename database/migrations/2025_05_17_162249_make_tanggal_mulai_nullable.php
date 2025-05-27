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
        Schema::table('penyelesaian_laporan', function (Blueprint $table) {
            $table->timestamp('tanggal_mulai')->nullable()->change();
            $table->timestamp('tanggal_selesai')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyelesaian_laporan', function (Blueprint $table) {
            $table->timestamp('tanggal_mulai')->nullable(false)->change();
            $table->timestamp('tanggal_selesai')->nullable(false)->change();
        });
    }
};
