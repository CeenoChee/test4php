<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUgyfelTelephelyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ugyfel_telephely')) {
            Schema::create('ugyfel_telephely', function (Blueprint $table) {
                $table->bigInteger('Ugyfel_ID');
                $table->bigInteger('UgyfelTelephely_ID');
                $table->string('Kod');
                $table->string('Nev');
                $table->integer('Orszag_ID');
                $table->string('Helyseg');
                $table->string('UtcaHSzam');
                $table->string('IrSzam');
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugyfel_telephely');
    }
}
