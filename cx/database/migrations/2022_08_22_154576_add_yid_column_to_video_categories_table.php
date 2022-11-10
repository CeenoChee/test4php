<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYidColumnToVideoCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('video_categories', function (Blueprint $table) {
            $table->string('yid')->after('slug');
        });
    }

    public function down()
    {
        Schema::table('video_categories', function (Blueprint $table) {
            $table->dropColumn('yid');
        });
    }
}
