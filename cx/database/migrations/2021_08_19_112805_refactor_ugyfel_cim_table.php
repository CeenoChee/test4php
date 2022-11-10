<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorUgyfelCimTable extends Migration
{
    public function up()
    {
        Schema::rename('ugyfel_cim', 'shipping_addresses');

        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->string('Telefon')->after('IrSzam')->nullable();
            $table->string('Email')->after('Telefon')->nullable();
            $table->string('Megjegyzes')->after('Email')->nullable();
        });
    }

    public function down()
    {
        Schema::rename('shipping_addresses', 'ugyfel_cim');

        Schema::table('ugyfel_cim', function (Blueprint $table) {
            $table->dropColumn('Telefon');
            $table->dropColumn('Email');
            $table->dropColumn('Megjegyzes');
        });
    }
}
