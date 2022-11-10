<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTulajdonsagForditasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tulajdonsag_forditas')) {
            Schema::create('tulajdonsag_forditas', function (Blueprint $table) {
                $table->bigInteger('Tulajdonsag_ID');
                $table->bigInteger('Nyelv_ID');
                $table->string('Cimke');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Tulajdonsag_ID', 'Nyelv_ID']);
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
        Schema::dropIfExists('tulajdonsag_forditas');
    }
}
