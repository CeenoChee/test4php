<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKosarTetelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('kosar_tetel')) {
            Schema::create('kosar_tetel', function (Blueprint $table) {
                $table->bigInteger('Kosar_ID');
                $table->bigInteger('Termek_ID');
                $table->integer('Mennyiseg');
                $table->string('Kod');
                $table->string('Nev');
                $table->float('ListaAr', 15, 4);
                $table->float('AkciosAr', 15, 4)->nullable();
                $table->float('UgyfelAr', 15, 4);
                $table->dateTime('SzallHatarido')->nullable();
                $table->timestamps();

                $table->primary(['Kosar_ID', 'Termek_ID']);
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
        Schema::dropIfExists('kosar_tetel');
    }
}
