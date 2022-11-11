<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKosarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('kosar')) {
            Schema::create('kosar', function (Blueprint $table) {

                $table->bigIncrements('Kosar_ID');
                $table->integer('Ev')->nullable();
                $table->integer('Sorszam')->nullable();

                $table->bigInteger('Ugyfel_ID');
                $table->bigInteger('UgyfelDolgozo_ID');

                $table->integer('Fuvar')->nullable();
                $table->float('FuvarOsszeg', 15, 4)->default(0);

                $table->integer('Deviza_ID');
                $table->integer('FizetesiMod_ID')->nullable();
                $table->integer('UgyfelCim_ID')->nullable();
                $table->integer('SzemAtvevohely_ID')->nullable();
                $table->integer('Szallitas')->nullable();
                $table->boolean('Visszaru')->nullable();
                $table->text('Megjegyzes')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('kosar');
    }
}
