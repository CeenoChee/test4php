<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySzallhataridoColumnInMegrendelesTetelTable extends Migration
{
    public function up()
    {
        Schema::table('megrendeles_tetel', function (Blueprint $table) {
            $table->date('SzallHatarido')->change();
        });
    }

    public function down()
    {
        Schema::table('megrendeles_tetel', function (Blueprint $table) {
            $table->dateTime('SzallHatarido')->change();
        });
    }
}
