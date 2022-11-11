<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTudastarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tudastar')) {
            Schema::create('tudastar', function (Blueprint $table) {
                $table->bigInteger('Tudastar_ID');
                $table->string('Cim');
                $table->string('Eleres');
                $table->integer('Nyelv_ID');
                $table->mediumText('RovidLeiras');
                $table->mediumText('Leiras');
                $table->integer('Sorrend');
                $table->boolean('Publikus');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('Tudastar_ID');
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
        Schema::dropIfExists('tudastar');
    }
}
