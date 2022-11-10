<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSzemAtvevohelyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('szem_atvevohely')) {
            Schema::create('szem_atvevohely', function (Blueprint $table) {
                $table->bigInteger('SzemAtvevohely_ID');
                $table->string('Nev');
                $table->bigInteger('Orszag_ID');
                $table->string('Helyseg');
                $table->string('UtcaHSzam');
                $table->string('IrSzam');

                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('SzemAtvevohely_ID');
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
        Schema::dropIfExists('szem_atvevohely');
    }
}
