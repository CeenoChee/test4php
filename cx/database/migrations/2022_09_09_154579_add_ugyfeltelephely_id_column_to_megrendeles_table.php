<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUgyfelTelephelyIdColumnToMegrendelesTable extends Migration
{
    public function up()
    {
        Schema::table('megrendeles', function (Blueprint $table) {
            $table->bigInteger('UgyfelTelephely_ID')->after('Ugyfel_ID')->nullable();
        });
    }

    public function down()
    {
        Schema::table('megrendeles', function (Blueprint $table) {
            $table->dropColumn('UgyfelTelephely_ID');
        });
    }
}
