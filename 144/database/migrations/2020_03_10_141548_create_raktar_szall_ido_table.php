<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaktarSzallIdoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('raktar_szall_ido')) {
            Schema::create('raktar_szall_ido', function (Blueprint $table) {
                $table->bigInteger('ForrasRaktar_ID');
                $table->bigInteger('CelRaktar_ID');
                $table->integer('SzallIdoOra');
                $table->time('Hatarido');

                $table->primary(['ForrasRaktar_ID', 'CelRaktar_ID']);
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
        Schema::dropIfExists('raktar_szall_ido');
    }
}
