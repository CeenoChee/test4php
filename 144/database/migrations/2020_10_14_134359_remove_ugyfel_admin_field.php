<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUgyfelAdminField extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ugyfel_dolgozo', function (Blueprint $table) {
            $table->dropColumn('UgyfelAdmin');
            $table->string('WebLogin')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ugyfel_dolgozo', function (Blueprint $table) {
            $table->boolean('UgyfelAdmin');
            $table->string('WebLogin')->change();
        });
    }
}
