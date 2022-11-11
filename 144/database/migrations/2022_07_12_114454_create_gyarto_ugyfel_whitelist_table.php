<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGyartoUgyfelWhitelistTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('gyarto_ugyfel_whitelist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blacklisted_manufacturer_id');
            $table->bigInteger('Ugyfel_ID');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('blacklisted_manufacturer_id')->references('id')->on('blacklisted_manufacturers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('Ugyfel_ID')->references('Ugyfel_ID')->on('ugyfel')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('gyarto_ugyfel_whitelist');
    }
}
