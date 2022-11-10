<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTudastarCsoportTudastarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tudastar_csoport_tudastar')) {
            Schema::create('tudastar_csoport_tudastar', function (Blueprint $table) {
                $table->bigInteger('TudastarCsoport_ID');
                $table->bigInteger('Tudastar_ID');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['TudastarCsoport_ID', 'Tudastar_ID']);
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
        Schema::dropIfExists('tudastar_csoport_tudastar');
    }
}
