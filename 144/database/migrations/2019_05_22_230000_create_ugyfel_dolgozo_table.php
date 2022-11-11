<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUgyfelDolgozoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ugyfel_dolgozo')) {
            Schema::create('ugyfel_dolgozo', function (Blueprint $table) {
                $table->bigInteger('Ugyfel_ID');
                $table->bigInteger('UgyfelDolgozo_ID');
                $table->string('Nev');
                $table->string('WebLogin');
                $table->string('Beosztas');
                $table->string('Telefon');
                $table->string('Mobil');
                $table->string('Fax');
                $table->boolean('UgyfelAdmin');
                $table->boolean('Hasznalhato');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Ugyfel_ID', 'UgyfelDolgozo_ID']);
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
        Schema::dropIfExists('ugyfel_dolgozo');
    }
}
