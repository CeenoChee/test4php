<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUgyfelDolgozoKategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ugyfel_dolgozo_kategoria', function (Blueprint $table) {
            $table->bigInteger('UgyfelDolgozoKategoria_ID');
            $table->string('Nev');
            $table->dateTime('ModDatum');
            $table->dateTime('FelvDatum');

            $table->primary([
                'UgyfelDolgozoKategoria_ID',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugyfel_dolgozo_kategoria');
    }
}
