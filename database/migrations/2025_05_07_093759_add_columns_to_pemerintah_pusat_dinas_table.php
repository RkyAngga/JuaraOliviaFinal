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
        // Schema::table('pemerintah_pusat_dinas', function (Blueprint $table) {
        //     $table->string('username')->after('dinas_id');
        //     $table->string('nomor_telepon', 15)->after('username');
        //     $table->string('email')->after('nomor_telepon');
        //     $table->string('wilayah')->after('email');
        // });
        // Kosongkan metode up() karena kolom-kolom ini sudah ada
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('pemerintah_pusat_dinas', function (Blueprint $table) {
        //     $table->dropColumn(['username', 'nomor_telepon', 'email', 'wilayah']);
        // });
        // Kosongkan metode down()
    }
};