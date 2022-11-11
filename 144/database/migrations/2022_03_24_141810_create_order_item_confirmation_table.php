<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemConfirmationTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('order_item_confirmation')) {
            Schema::create('order_item_confirmation', function (Blueprint $table) {
                $table->bigInteger('AruforgBiz_ID');
                $table->bigInteger('AruforgBizTetel_ID');
                $table->bigInteger('AruforgBizTetelVisszaigazolas_ID');
                $table->bigInteger('Szallitas');
                $table->bigInteger('Fuvardij_ID');
                $table->bigInteger('Termek_ID');
                $table->integer('Mennyiseg');
                $table->integer('Rendelt');
                $table->integer('Visszaigazolt');
                $table->integer('Diszponalt');
                $table->integer('Visszamondott');
                $table->integer('Elutasitott');
                $table->integer('Teljesitett');
                $table->dateTime('VisszaigazolasDatum');
                $table->dateTime('TeljesitesDatum');
                $table->float('Egysegar', 15, 4);
                $table->float('UgyfelAr', 15, 4);
                $table->dateTime('FelvDatum');
                $table->dateTime('ModDatum');

                $table->primary(['AruforgBiz_ID', 'AruforgBizTetel_ID', 'AruforgBizTetelVisszaigazolas_ID'], 'Pk_order_confirmation');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('order_item_confirmation');
    }
}
