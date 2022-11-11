<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrszagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('orszag')) {
            Schema::create('orszag', function (Blueprint $table) {
                $table->bigInteger('Orszag_ID');
                $table->string('Nev');
                $table->string('KodAlpha2', 2);
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('Orszag_ID');
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
        Schema::dropIfExists('orszag');
    }
}