<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUgyfelCimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ugyfel_cim')) {
            Schema::create('ugyfel_cim', function (Blueprint $table) {
                $table->bigInteger('Ugyfel_ID');
                $table->bigInteger('UgyfelCim_ID');
                $table->string('Nev');
                $table->bigInteger('Orszag_ID');
                $table->string('Helyseg');
                $table->string('UtcaHSzam');
                $table->string('IrSzam');
                $table->softDeletes();
                $table->timestamps();

                $table->primary(['Ugyfel_ID', 'UgyfelCim_ID'], 'udc_ugyfel_id_ugyfelcim_id_primary');
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
        Schema::dropIfExists('ugyfel_cim');
    }
}
