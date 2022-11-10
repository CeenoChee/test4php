<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToSortFieldInMediaModelTable extends Migration
{
    public function up()
    {
        Schema::table('media_model', function(Blueprint $table)
        {
            $table->index('sort');
        });
    }

    public function down()
    {
        Schema::table('media_model', function (Blueprint $table) {
            $table->dropIndex('media_model_sort_index');
        });
    }
}
