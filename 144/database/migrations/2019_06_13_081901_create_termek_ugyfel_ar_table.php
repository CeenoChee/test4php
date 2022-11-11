<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekUgyfelArTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termek_ugyfel_ar')) {
            Schema::create('termek_ugyfel_ar', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('CsopFizetesiFeltetel_ID');
                $table->bigInteger('Deviza_ID');
                $table->float('UgyfelAr', 15, 4)->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'CsopFizetesiFeltetel_ID', 'Deviza_ID'], 'termek_ugyfel_ar_pks');
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
        Schema::dropIfExists('termek_ugyfel_ar');
    }
}
