<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_model', function (Blueprint $table) {
            $table->unsignedBigInteger('media_id');
            $table->morphs('model');
            $table->integer('sort')->default(1);

            $table->nullableTimestamps();

            $table->primary(['media_id', 'model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_model');
    }
}
