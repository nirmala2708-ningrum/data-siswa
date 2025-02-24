<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSiswaTable extends Migration
{
    public function up()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('avatar')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('avatar')->nullable(false)->change();
        });
    }
}

