<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekKiegeszitotermekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termek_kiegeszitotermek')) {
            Schema::create('termek_kiegeszitotermek', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('KiegeszitoTermek_ID');
                $table->integer('Sorrend');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'KiegeszitoTermek_ID']);
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
        Schema::dropIfExists('termek_kiegeszitotermek');
    }
}
