<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTermekForditasTable extends Migration
{
    public function up()
    {
        Schema::table('termek_forditas', function (Blueprint $table) {
            $table->longText('RovidLeiras')->change();
            $table->longText('Leiras')->change();
        });
    }

    public function down()
    {
        Schema::table('termek_forditas', function (Blueprint $table) {
            $table->text('RovidLeiras')->change();
            $table->text('Leiras')->change();
        });
    }
}
