<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUgyfelTelephelyTableAndCreateCustomerPremisesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('ugyfel_telephely');

        Schema::create('ugyfel_telephely', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Ugyfel_ID');
            $table->bigInteger('UgyfelTelephely_ID')->nullable();
            $table->string('Kod');
            $table->string('Nev');
            $table->integer('Orszag_ID');
            $table->string('Helyseg');
            $table->string('UtcaHSzam');
            $table->string('IrSzam');
            $table->boolean('Hasznalhato')->default(1);
            $table->integer('Ugynok_ID');
            $table->dateTime('ModDatum');
            $table->dateTime('FelvDatum');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ugyfel_telephely');

        Schema::create('ugyfel_telephely', function (Blueprint $table) {
            $table->bigInteger('Ugyfel_ID');
            $table->bigInteger('UgyfelTelephely_ID');
            $table->string('Kod');
            $table->string('Nev');
            $table->integer('Orszag_ID');
            $table->string('Helyseg');
            $table->string('UtcaHSzam');
            $table->string('IrSzam');
            $table->boolean('Hasznalhato')->default(1);
            $table->integer('Ugynok_ID');
            $table->dateTime('ModDatum');
            $table->dateTime('FelvDatum');

            $table->primary([
                'Ugyfel_ID',
                'UgyfelTelephely_ID',
            ]);
        });
    }
}
