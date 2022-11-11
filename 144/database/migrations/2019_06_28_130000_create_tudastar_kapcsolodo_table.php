<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTudastarKapcsolodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tudastar_kapcsolodo')) {
            Schema::create('tudastar_kapcsolodo', function (Blueprint $table) {
                $table->bigInteger('Tudastar_ID');
                $table->bigInteger('KapcsolodoTudastar_ID');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Tudastar_ID', 'KapcsolodoTudastar_ID']);
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
        Schema::dropIfExists('tudastar_kapcsolodo');
    }
}
