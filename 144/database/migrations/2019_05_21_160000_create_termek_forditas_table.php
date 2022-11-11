<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekForditasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termek_forditas')) {
            Schema::create('termek_forditas', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('Nyelv_ID');
                $table->string('Nev');
                $table->text('RovidLeiras');
                $table->text('Leiras');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'Nyelv_ID']);
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
        Schema::dropIfExists('termek_forditas');
    }
}
