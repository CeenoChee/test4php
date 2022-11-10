<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyLeirasColumnInTermekForditasTable extends Migration
{
    public function up()
    {
        Schema::table('termek_forditas', function (Blueprint $table) {
            $table->text('RovidLeiras')->nullable()->change();
            $table->text('Leiras')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('termek_forditas', function (Blueprint $table) {
            $table->text('RovidLeiras')->nullable(false)->change();
            $table->text('Leiras')->nullable(false)->change();
        });
    }
}
