<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewsColumnToKnowledgesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('knowledges', function (Blueprint $table) {
            $table->integer('views')->default(0)->after('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('knowledges', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
}
