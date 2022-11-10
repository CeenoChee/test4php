<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUgyfelTableWithCompetitorField extends Migration
{
    public function up()
    {
        Schema::table('ugyfel', function (Blueprint $table) {
            $table->boolean('Konkurencia')->default(0)->after('Viszontelado');
        });
    }

    public function down()
    {
        Schema::table('ugyfel', function (Blueprint $table) {
            $table->dropColumn('Konkurencia');
        });
    }
}
