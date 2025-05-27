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
        Schema::table('laporan_pengaduan', function (Blueprint $table) {
            $table->boolean('escalated_to_pusat')->default(false)->after('related_pengaduan_id');
            $table->timestamp('waktu_menunggu_expired')->nullable()->after('escalated_to_pusat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_pengaduan', function (Blueprint $table) {
            $table->dropColumn(['escalated_to_pusat', 'waktu_menunggu_expired']);
        });
    }
};
