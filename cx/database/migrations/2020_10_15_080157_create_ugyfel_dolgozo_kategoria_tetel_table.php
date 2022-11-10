<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUgyfelDolgozoKategoriaTetelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ugyfel_dolgozo_kategoria_tetel', function (Blueprint $table) {
            $table->bigInteger('UgyfelDolgozoKategoria_ID');
            $table->bigInteger('UgyfelDolgozoKategoriaTetel_ID');
            $table->string('Kod');
            $table->string('Nev');
            $table->dateTime('ModDatum');
            $table->dateTime('FelvDatum');

            $table->primary([
                'UgyfelDolgozoKategoria_ID',
                'UgyfelDolgozoKategoriaTetel_ID',
            ], 'ugyfel_dolgozo_kategoria_tetel_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugyfel_dolgozo_kategoria_tetel');
    }
}
