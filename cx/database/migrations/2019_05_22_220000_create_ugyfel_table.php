<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUgyfelTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('ugyfel')) {
            return;
        }

        Schema::create('ugyfel', function (Blueprint $table) {
            $table->bigInteger('Ugyfel_ID');
            $table->string('Nev');
            $table->bigInteger('Orszag_ID');
            $table->string('Helyseg');
            $table->string('UtcaHSzam');
            $table->string('IrSzam');
            $table->boolean('Viszontelado');
            $table->string('Adoszam');
            $table->string('EUAdoszam');
            $table->string('Cegjegyzekszam');
            $table->bigInteger('CsopFizetesiFeltetel_ID');
            $table->bigInteger('Deviza_ID');
            $table->bigInteger('FizetesiMod_ID');
            $table->bigInteger('Ugynok_ID');
            $table->dateTime('FelvDatum')->nullable();
            $table->dateTime('ModDatum')->nullable();

            $table->primary('Ugyfel_ID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ugyfel');
    }
}
