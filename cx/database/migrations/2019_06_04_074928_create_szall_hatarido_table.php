<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSzallHataridoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('szall_hatarido')) {
            Schema::create('szall_hatarido', function (Blueprint $table) {
                $table->bigInteger('AruforgBiz_ID');
                $table->bigInteger('AruforgBizTetel_ID');
                $table->bigInteger('AruforgBizValasz_ID');
                $table->bigInteger('AruforgBizValaszTetel_ID');
                $table->bigInteger('Termek_ID');
                $table->bigInteger('Raktar_ID');
                $table->integer('SzabadMennyiseg');
                $table->dateTime('SzallHatIdo')->nullable();
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['AruforgBiz_ID', 'AruforgBizTetel_ID', 'AruforgBizValasz_ID', 'AruforgBizValaszTetel_ID'], 'szall_haterido_view_primary');
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
        Schema::dropIfExists('szall_hatarido');
    }
}
