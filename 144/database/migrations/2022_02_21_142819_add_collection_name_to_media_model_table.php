<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollectionNameToMediaModelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('media_model', function (Blueprint $table) {
            $table->string('collection_name')->default('default')->after('sort');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('media_model', function (Blueprint $table) {
            $table->dropColumn('collection_name');
        });
    }
}
