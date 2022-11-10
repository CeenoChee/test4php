<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateKosarSzallitasiCim extends Migration
{

    public function up()
    {
        Schema::table('kosar', function (Blueprint $table) {
            $table->dropColumn('UgyfelCim_ID');

            $table->bigInteger('UgyfelTelephely_ID')->nullable();
            $table->string('Nev',100)->nullable();
            $table->string('Orszag',100)->nullable();
            $table->string('Helyseg',100)->nullable();
            $table->string('UtcaHSzam',100)->nullable();
            $table->string('IrSzam',100)->nullable();
            $table->string('Telefon',100)->nullable();
            $table->string('Email',100)->nullable();
            $table->string('FutarMegjegyzes', 100)->nullable();
        });
    }

    public function down()
    {
        Schema::table('kosar', function (Blueprint $table) {
            $table->integer('UgyfelCim_ID')->nullable();

            $table->dropColumn('UgyfelTelephely_ID');
            $table->dropColumn('Nev');
            $table->dropColumn('Orszag');
            $table->dropColumn('Helyseg');
            $table->dropColumn('UtcaHSzam');
            $table->dropColumn('IrSzam');
            $table->dropColumn('Telefon');
            $table->dropColumn('Email');
            $table->dropColumn('FutarMegjegyzes');
        });
    }
}
