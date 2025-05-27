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
            $table->text('deskripsi_pengerjaan')->nullable()->after('alasan_penolakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyelesaian_laporan', function (Blueprint $table) {
            $table->dropColumn('deskripsi_pengerjaan');
        });
    }
};
