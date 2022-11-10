<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGyartoTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('gyarto')) {
            Schema::create('gyarto', function (Blueprint $table) {
                $table->bigInteger('Gyarto_ID');
                $table->string('Nev');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('Gyarto_ID');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('gyarto');
    }
}
