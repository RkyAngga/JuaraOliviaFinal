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
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->string('role_tujuan')->nullable()->after('user_id');
            $table->text('alasan_penolakan')->nullable()->after('isi_notifikasi');
            $table->timestamp('waktu_tolak')->nullable()->after('alasan_penolakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropColumn(['role_tujuan', 'alasan_penolakan', 'waktu_tolak']);
        });
    }
};
