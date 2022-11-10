<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekKivaltotermekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termek_kivaltotermek')) {
            Schema::create('termek_kivaltotermek', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('KivaltoTermek_ID');
                $table->integer('Sorrend');
                $table->integer('Mennyiseg');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'KivaltoTermek_ID']);
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
        Schema::dropIfExists('termek_kivaltotermek');
    }
}
