<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEszamlazasColumnToUgyfelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ugyfel', function (Blueprint $table) {
            $table->boolean('ESzamlazas')->default(0)->after('Ugynok_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ugyfel', function (Blueprint $table) {
            $table->dropColumn('ESzamlazas');
        });
    }
}
