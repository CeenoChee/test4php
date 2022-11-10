<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeszletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('keszlet')) {
            Schema::create('keszlet', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('Raktar_ID');
                $table->integer('SzabadMennyiseg');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'Raktar_ID']);
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
        Schema::dropIfExists('keszlet');
    }
}
