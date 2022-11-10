<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermekfaLevelTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('termekfa_level')) {
            Schema::create('termekfa_level', function (Blueprint $table) {
                $table->bigInteger('TermekfaLevel_ID');
                $table->bigInteger('FelsoTermekfaLevel_ID');
                $table->integer('Szint');
                $table->integer('Bal');
                $table->integer('Jobb');
                $table->string('Kod');
                $table->string('Nev');
                $table->integer('Sorrend')->nullable();
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary('TermekfaLevel_ID');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('termekfa_level');
    }
}
