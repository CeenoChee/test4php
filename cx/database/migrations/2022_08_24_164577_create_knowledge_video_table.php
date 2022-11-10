<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeVideoTable extends Migration
{
    public function up()
    {
        Schema::create('knowledge_video', function (Blueprint $table) {
            $table->unsignedBigInteger('knowledge_id');
            $table->unsignedBigInteger('video_id');

            $table->nullableTimestamps();

            $table->primary(['knowledge_id', 'video_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('knowledge_video');
    }
}
