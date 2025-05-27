<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('masyarakat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('username');
            $table->string('role')->default('masyarakat');
            $table->string('masyarakat_id')->unique();
            $table->binary('foto_profil')->nullable();
            $table->integer('poin')->default(0);
            $table->timestamp('last_report_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Add trigger to automatically update username and role when user table is updated
        DB::unprepared('
            CREATE TRIGGER update_masyarakat_user_fields
            AFTER UPDATE ON users
            FOR EACH ROW
            BEGIN
                IF OLD.username != NEW.username OR OLD.role != NEW.role THEN
                    UPDATE masyarakat
                    SET username = NEW.username,
                        role = NEW.role
                    WHERE user_id = NEW.id;
                END IF;
            END
        ');
    }

    public function down()
    {
        // Drop the trigger first
        DB::unprepared('DROP TRIGGER IF EXISTS update_masyarakat_user_fields');

        // Then drop the table
        Schema::dropIfExists('masyarakat');
    }
};
