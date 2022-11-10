<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekBesorolasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!Schema::hasTable('termek_besorolas')) {
            Schema::create('termek_besorolas', function (Blueprint $table) {
                $table->bigInteger('Termek_ID');
                $table->bigInteger('TermekKategoria_ID');
                $table->bigInteger('TermekKategoriaTetel_ID');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Termek_ID', 'TermekKategoria_ID', 'TermekKategoriaTetel_ID'], 'termek_besorolasok_primary');
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
		Schema::dropIfExists('termek_besorolas');
	}
}
