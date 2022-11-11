<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeszletErejeigColumnToTermekTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('termek', function (Blueprint $table) {
            $table->boolean('KeszletErejeig')->after('MaxRendelheto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('termek', function (Blueprint $table) {
            $table->removeColumn('KeszletErejeig');
        });
    }
}
