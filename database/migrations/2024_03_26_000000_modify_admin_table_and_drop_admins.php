<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the admins table
        Schema::dropIfExists('admins');

        // Add columns to admin table
        Schema::table('admin', function (Blueprint $table) {
            $table->string('username')->unique()->after('user_id');
            $table->string('email')->unique()->after('username');
        });
    }

    public function down(): void
    {
        // Remove columns from admin table
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn(['username', 'email']);
        });

        // Recreate admins table
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
}; 