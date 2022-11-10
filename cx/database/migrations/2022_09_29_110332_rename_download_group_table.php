<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameDownloadGroupTable extends Migration
{
    public function up()
    {
        Schema::rename('download_groups', 'download_categories');

        Schema::rename('download_has_download_group', 'download_download_category');
    }

    public function down()
    {
        Schema::rename('download_categories', 'download_groups');

        Schema::rename('download_download_category', 'download_has_download_group');
    }
}
