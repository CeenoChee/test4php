<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUgyfelDolgozoBesorolasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ugyfel_dolgozo_besorolas')) {
            Schema::create('ugyfel_dolgozo_besorolas', function (Blueprint $table) {
                $table->bigInteger('Ugyfel_ID');
                $table->bigInteger('UgyfelDolgozo_ID');
                $table->bigInteger('UgyfelDolgozoKategoria_ID');
                $table->bigInteger('UgyfelDolgozoKategoriaTetel_ID');

                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Ugyfel_ID', 'UgyfelDolgozo_ID', 'UgyfelDolgozoKategoria_ID', 'UgyfelDolgozoKategoriaTetel_ID'], 'ugyfel_dolgozo_besorolasok_primary');
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
        Schema::dropIfExists('ugyfel_dolgozo_besorolas');
    }
}
