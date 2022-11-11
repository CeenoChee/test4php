<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermekfaLevelForditasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('termekfa_level_forditas')) {
            Schema::create('termekfa_level_forditas', function (Blueprint $table) {
                $table->bigInteger('Nyelv_ID');
                $table->bigInteger('TermekfaLevel_ID');
                $table->string('Nev');
                $table->string('Eleres');
                $table->string('RovidLeiras');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Nyelv_ID', 'TermekfaLevel_ID']);
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
        Schema::dropIfExists('termekfa_level_forditas');
    }
}
