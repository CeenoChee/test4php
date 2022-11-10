<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMennyisegEgysegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mennyiseg_egyseg')) {
            Schema::create('mennyiseg_egyseg', function (Blueprint $table) {
                $table->bigInteger('MennyisegEgyseg_ID');
                $table->string('Nev');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary([
                    'MennyisegEgyseg_ID']);
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
        Schema::dropIfExists('mennyiseg_egyseg');
    }
}
