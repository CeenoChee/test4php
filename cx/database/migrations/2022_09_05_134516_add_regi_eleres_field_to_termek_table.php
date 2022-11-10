<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegiEleresFieldToTermekTable extends Migration
{
    public function up()
    {
        Schema::table('termek', function (Blueprint $table) {
            $table->string('RegiEleres')->after('Eleres');
        });
    }

    public function down()
    {
        Schema::table('termek', function (Blueprint $table) {
            $table->dropColumn('RegiEleres');
        });
    }
}
