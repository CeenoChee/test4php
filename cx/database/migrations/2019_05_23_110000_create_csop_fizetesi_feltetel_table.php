<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsopFizetesiFeltetelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('csop_fizetesi_feltetel')) {
            Schema::create('csop_fizetesi_feltetel', function (Blueprint $table) {
                $table->bigInteger('CsopFizetesiFeltetel_ID');
                $table->string('Nev');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('CsopFizetesiFeltetel_ID');
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
        Schema::dropIfExists('csop_fizetesi_feltetel');
    }
}
