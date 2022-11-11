<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUgyfelCimIdColumnToKosarTable extends Migration
{
    public function up()
    {
        Schema::table('kosar', function (Blueprint $table) {
            $table->bigInteger('UgyfelCim_ID')->after('UgyfelTelephely_ID')->nullable();
        });
    }

    public function down()
    {
        Schema::table('kosar', function (Blueprint $table) {
            $table->dropColumn('UgyfelCim_ID');
        });
    }
}
