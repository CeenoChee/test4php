<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termek')) {
            Schema::create('termek', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->string('Kod');
                $table->string('Eleres');
                $table->string('Nev');
                $table->bigInteger('Gyarto_ID');
                $table->bigInteger('TulajdonsagCsoport_ID');
                $table->bigInteger('MennyisegEgyseg_ID')->nullable();
                $table->boolean('Aktiv');
                $table->boolean('Lathato');
                $table->boolean('Kifuto');
                $table->boolean('Ujdonsag');
                $table->boolean('ItTermek');
                $table->boolean('Projekt');
                $table->integer('MaxRendelheto')->nullable();
                $table->string('Garancia');
                $table->integer('SzallIdoOra')->nullable();

                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('Termek_ID');
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
        Schema::dropIfExists('termek');
    }
}
