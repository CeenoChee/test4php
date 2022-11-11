<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVevoSzTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vevo_sz')) {
            Schema::create('vevo_sz', function (Blueprint $table) {
                $table->bigInteger('VevoSz_ID');
                $table->bigInteger('Ev');
                $table->string('Sorozat');
                $table->integer('Sorszam');
                $table->bigInteger('Ugyfel_ID');
                $table->bigInteger('UgyfelDolgozo_ID')->nullable();
                $table->bigInteger('UgyfelTelephely_ID')->nullable();
                $table->bigInteger('FizetesiMod_ID');
                $table->float('Vegosszeg', 15, 4);
                $table->bigInteger('Deviza_ID');
                $table->float('Egyenleg', 15, 4);
                $table->dateTime('SzamlaDatum')->nullable();
                $table->dateTime('TeljesitesDatum')->nullable();
                $table->dateTime('EsedekessegDatum')->nullable();
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['VevoSz_ID']);
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
        Schema::dropIfExists('vevo_sz');
    }
}
