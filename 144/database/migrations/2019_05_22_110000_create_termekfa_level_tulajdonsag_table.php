<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekfaLevelTulajdonsagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termekfa_level_tulajdonsag')) {
            Schema::create('termekfa_level_tulajdonsag', function (Blueprint $table) {
                $table->bigInteger('TermekfaLevel_ID');
                $table->bigInteger('Tulajdonsag_ID');
                $table->integer('Sorrend');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['TermekfaLevel_ID', 'Tulajdonsag_ID'], 'tfl_tulajdonsag_termekfalevel_id_tulajdonsag_id_primary');
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
        Schema::dropIfExists('termekfa_level_tulajdonsag');
    }
}
