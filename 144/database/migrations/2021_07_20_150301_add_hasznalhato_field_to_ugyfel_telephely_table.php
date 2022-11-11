<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHasznalhatoFieldToUgyfelTelephelyTable extends Migration
{
    public function up()
    {
        Schema::table('ugyfel_telephely', function (Blueprint $table) {
            $table->boolean('Hasznalhato')->after('IrSzam')->default(1);
        });
    }

    public function down()
    {
        Schema::table('ugyfel_telephely', function (Blueprint $table) {
            $table->removeColumn('Hasznalhato');
        });
    }
}
