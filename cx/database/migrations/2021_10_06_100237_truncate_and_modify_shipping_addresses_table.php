<?php

use Database\Seeders\FillShippingAddressSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TruncateAndModifyShippingAddressesTable extends Migration
{
    public function up()
    {
        DB::table('shipping_addresses')->truncate();

        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->bigInteger('UgyfelTelephely_ID')->after('UgyfelCim_ID')->nullable();
            $table->bigInteger('Ugynok_ID')->after('UgyfelTelephely_ID')->nullable();
            $table->boolean('Szerkesztheto')->after('Ugynok_ID')->default(1);
            $table->boolean('Hasznalhato')->after('Szerkesztheto')->default(1);
            $table->boolean('AlapCim')->after('Hasznalhato')->default(0);
        });

        resolve(FillShippingAddressSeeder::class)->run();
    }

    public function down()
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->removeColumn('UgyfelTelephely_ID');
            $table->removeColumn('Ugynok_ID');
            $table->removeColumn('Szerkesztheto');
            $table->removeColumn('Hasznalhato');
            $table->removeColumn('AlapCim');
        });

        DB::table('shipping_addresses')->truncate();
    }
}
