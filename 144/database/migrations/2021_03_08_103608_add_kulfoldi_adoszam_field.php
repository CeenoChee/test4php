<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKulfoldiAdoszamField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ugyfel', function (Blueprint $table) {
            $table->string('KulfoldiAdoszam')->after('EUAdoszam')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ugyfel', function (Blueprint $table) {
            $table->dropColumn('KulfoldiAdoszam');
        });
    }
}
