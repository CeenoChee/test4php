<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTulajdonsagTetelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tulajdonsag_tetel')) {
            Schema::create('tulajdonsag_tetel', function (Blueprint $table) {
                $table->bigInteger('Tulajdonsag_ID');
                $table->bigInteger('TulajdonsagTetel_ID');
                $table->string('Nev');
                $table->integer('Sorrend');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Tulajdonsag_ID', 'TulajdonsagTetel_ID']);
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
        Schema::dropIfExists('tulajdonsag_tetel');
    }
}
