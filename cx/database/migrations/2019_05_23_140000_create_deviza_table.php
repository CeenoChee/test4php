<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevizaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('deviza')) {
            Schema::create('deviza', function (Blueprint $table) {
                $table->bigInteger('Deviza_ID');
                $table->string('Deviza');
                $table->string('Nev');
                $table->integer('Sorrend');
                $table->float('DevizaVeteliArfolyam')->nullable();
                $table->float('DevizaEladasiArfolyam')->nullable();
                $table->integer('Tizedesjegy');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('Deviza_ID');
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
        Schema::dropIfExists('deviza');
    }
}
