<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTudastarCsoportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tudastar_csoport')) {
            Schema::create('tudastar_csoport', function (Blueprint $table) {
                $table->bigInteger('TudastarCsoport_ID');
                $table->string('Nev');
                $table->string('Eleres');
                $table->integer('Nyelv_ID');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('TudastarCsoport_ID');
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
        Schema::dropIfExists('tudastar_csoport');
    }
}
