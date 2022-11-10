<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekKapcsolodotermekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termek_kapcsolodotermek')) {
            Schema::create('termek_kapcsolodotermek', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('KapcsolodoTermek_ID');
                $table->boolean('Ketiranyu');
                $table->integer('Sorrend');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'KapcsolodoTermek_ID']);
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
        Schema::dropIfExists('termek_kapcsolodotermek');
    }
}
