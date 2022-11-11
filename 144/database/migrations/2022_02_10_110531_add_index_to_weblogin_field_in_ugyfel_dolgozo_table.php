<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToWebloginFieldInUgyfelDolgozoTable extends Migration
{
    public function up()
    {
        Schema::table('ugyfel_dolgozo', function (Blueprint $table) {
            $table->index('WebLogin');
        });
    }

    public function down()
    {
        Schema::table('ugyfel_dolgozo', function (Blueprint $table) {
            $table->dropIndex(['weblogin']);
        });
    }
}
