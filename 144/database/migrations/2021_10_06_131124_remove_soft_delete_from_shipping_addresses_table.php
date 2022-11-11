<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSoftDeleteFromShippingAddressesTable extends Migration
{
    public function up()
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

    public function down()
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}
