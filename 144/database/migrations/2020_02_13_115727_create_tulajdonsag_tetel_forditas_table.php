<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTulajdonsagTetelForditasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!Schema::hasTable('tulajdonsag_tetel_forditas')) {
            Schema::create('tulajdonsag_tetel_forditas', function (Blueprint $table) {
                $table->bigInteger('Tulajdonsag_ID');
                $table->bigInteger('TulajdonsagTetel_ID');
                $table->bigInteger('Nyelv_ID');
                $table->string('Nev');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Tulajdonsag_ID', 'TulajdonsagTetel_ID', 'Nyelv_ID'], 'tulajdonsag_tetel_forditas_primary');
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
		Schema::dropIfExists('tulajdonsag_tetel_forditas');
	}
}
