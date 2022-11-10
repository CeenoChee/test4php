<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSzabadnapTable extends Migration
{
    public function up()
    {
        Schema::table('szabadnap', function (Blueprint $table) {
            $table->boolean('inner');
        });
    }

    public function down()
    {
        Schema::table('szabadnap', function (Blueprint $table) {
            $table->dropColumn('inner');
        });
    }
}
