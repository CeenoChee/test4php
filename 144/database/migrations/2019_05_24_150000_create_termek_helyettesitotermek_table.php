<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekHelyettesitotermekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termek_helyettesitotermek')) {
            Schema::create('termek_helyettesitotermek', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('HelyettesitoTermek_ID');
                $table->boolean('Ketiranyu');
                $table->integer('Sorrend');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'HelyettesitoTermek_ID'], 'tht_termek_id_helyettesitotermek_id_primary');
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
        Schema::dropIfExists('termek_helyettesitotermek');
    }
}
