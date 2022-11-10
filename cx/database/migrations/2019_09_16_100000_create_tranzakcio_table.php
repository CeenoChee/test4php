<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranzakcioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tranzakcio')) {
            Schema::create('tranzakcio', function (Blueprint $table) {
                $table->bigIncrements('Tranzakcio_ID');
                $table->bigInteger('Ugyfel_ID');
                $table->bigInteger('UgyfelDolgozo_ID');
                $table->float('NettoOsszeg', 15, 4);
                $table->float('BruttoOsszeg', 15, 4);
                $table->bigInteger('Deviza_ID');
                $table->string('Tipus')->nullable();
                $table->string('Adat')->nullable();
                $table->string('ResponseCode')->nullable();
                $table->string('TransactionID')->nullable();
                $table->string('Event')->nullable();
                $table->string('Merchant')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('tranzakcio');
    }
}
