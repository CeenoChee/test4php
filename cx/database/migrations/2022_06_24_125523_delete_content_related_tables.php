<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DeleteContentRelatedTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('content_elements');
        Schema::dropIfExists('content_versions');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('contents');
    }

    public function down()
    {
    }
}
