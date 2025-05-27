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
        Schema::table('tracking_laporan', function (Blueprint $table) {
            if (!Schema::hasColumn('tracking_laporan', 'escalated_to_pusat')) {
                $table->boolean('escalated_to_pusat')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking_laporan', function (Blueprint $table) {
            $table->dropColumn('escalated_to_pusat');
        });
    }
};
