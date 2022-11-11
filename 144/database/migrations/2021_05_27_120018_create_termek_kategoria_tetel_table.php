<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermekKategoriaTetelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termek_kategoria_tetel', function (Blueprint $table) {
            $table->bigInteger('TermekKategoria_ID');
            $table->bigInteger('TermekKategoriaTetel_ID');
            $table->string('Nev');
            $table->string('Kod');
            $table->dateTime('FelvDatum')->nullable();
            $table->dateTime('ModDatum')->nullable();

            $table->primary(['TermekKategoria_ID', 'TermekKategoriaTetel_ID'], 'termekkategoriatetel_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('termek_kategoria_tetel');
    }
}
