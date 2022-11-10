<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecondaryEmailField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ugyfel_dolgozo', function (Blueprint $table) {
            $table->string('MasodlagosEmail')->after('WebLogin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ugyfel_dolgozo', function (Blueprint $table) {
            $table->removeColumn('MasodlagosEmail');
        });
    }
}
