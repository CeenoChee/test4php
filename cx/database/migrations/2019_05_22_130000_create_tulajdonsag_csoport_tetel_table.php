<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTulajdonsagCsoportTetelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tulajdonsag_csoport_tetel')) {
            Schema::create('tulajdonsag_csoport_tetel', function (Blueprint $table) {
                $table->bigInteger('TulajdonsagCsoport_ID');
                $table->bigInteger('Tulajdonsag_ID');
                $table->integer('Sorrend');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['TulajdonsagCsoport_ID', 'Tulajdonsag_ID'], 'tcs_tetel_tulajdonsagcsoport_id_tulajdonsag_id_primary');
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
        Schema::dropIfExists('tulajdonsag_csoport_tetel');
    }
}
