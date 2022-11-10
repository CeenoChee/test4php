<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAkciosArIdToTermekArTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('termek_ar', function (Blueprint $table) {
            $table->integer('AkciosAr_ID')->nullable()->after('Termek_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('termek_ar', function (Blueprint $table) {
            $table->removeColumn('AkciosAr_ID');
        });
    }
}
