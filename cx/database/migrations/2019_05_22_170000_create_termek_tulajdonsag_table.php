<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekTulajdonsagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termek_tulajdonsag')) {
            Schema::create('termek_tulajdonsag', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('Tulajdonsag_ID');
                $table->bigInteger('TulajdonsagTetel_ID');
                $table->string('Szoveg')->nullable();
                $table->float('Szam', 15, 4)->nullable();
                $table->boolean('Logikai')->nullable();
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'Tulajdonsag_ID', 'TulajdonsagTetel_ID'], 'tt_termek_id_tulajdonsag_id_tulajdonsagtetel_id_primary');
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
        Schema::dropIfExists('termek_tulajdonsag');
    }
}
