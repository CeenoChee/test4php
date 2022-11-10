<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DeleteUserClassificationsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('user_classifications');
    }
}
