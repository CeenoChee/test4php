<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsUnderSyncColumnToShippingAddressesTable extends Migration
{
    public function up()
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->boolean('is_under_sync')->after('Hasznalhato')->default(0);
        });
    }

    public function down()
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->dropColumn('is_under_sync');
        });
    }
}
