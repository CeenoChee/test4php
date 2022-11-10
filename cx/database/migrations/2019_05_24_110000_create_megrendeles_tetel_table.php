<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMegrendelesTetelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('megrendeles_tetel')) {
            Schema::create('megrendeles_tetel', function (Blueprint $table) {
                $table->bigInteger('AruforgBiz_ID');
                $table->bigInteger('AruforgBizTetel_ID');
                $table->bigInteger('Termek_ID');
                $table->integer('Mennyiseg');
                $table->float('Egysegar', 15, 4);
                $table->float('UgyfelAr', 15, 4);
                $table->dateTime('SzallHatarido')->nullable();
                $table->integer('Rendelt');
                $table->integer('Visszaigazolt');
                $table->integer('Diszponalt');
                $table->integer('Visszamondott');
                $table->integer('Elutasitott');
                $table->integer('Teljesitett');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['AruforgBiz_ID', 'AruforgBizTetel_ID']);
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
        Schema::dropIfExists('megrendeles_tetel');
    }
}
