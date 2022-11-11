<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePhoneFaxFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'ugyfel_dolgozo',
            function (Blueprint $table) {
                $table->string('WebLogin')->nullable()->change();
                $table->string('Telefon')->nullable()->change();
                $table->string('Mobil')->nullable()->change();
                $table->string('Fax')->nullable()->change();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'ugyfel_dolgozo',
            function (Blueprint $table) {
                $table->string('WebLogin')->change();
                $table->string('Telefon')->change();
                $table->string('Mobil')->change();
                $table->string('Fax')->change();
            }
        );
    }
}
