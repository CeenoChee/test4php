<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTulajdonsagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tulajdonsag')) {
            Schema::create('tulajdonsag', function (Blueprint $table) {
                $table->bigInteger('Tulajdonsag_ID');
                $table->string('Tipus');
                $table->string('Cimke');
                $table->string('BelsoNev');
                $table->string('MennyisegEgyseg')->nullable();
                $table->boolean('Publikus');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('Tulajdonsag_ID');
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
        Schema::dropIfExists('tulajdonsag');
    }
}
