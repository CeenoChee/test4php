<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekArTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termek_ar')) {
            Schema::create('termek_ar', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('Deviza_ID');
                $table->float('ListaAr', 15, 4)->nullable();
                $table->float('AkciosAr', 15, 4)->nullable();
                $table->string('AkcioNev')->nullable();
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'Deviza_ID']);
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
        Schema::dropIfExists('termek_ar');
    }
}
