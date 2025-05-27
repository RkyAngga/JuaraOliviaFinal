<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('pemerintah_pusat_dinas_new');
    }

    public function down()
    {
        // We don't need to recreate the table in down() since it was temporary
    }
}; 