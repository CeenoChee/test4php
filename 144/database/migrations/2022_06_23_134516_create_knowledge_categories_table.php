<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('tudastar_csoport');

        Schema::create('knowledge_categories', function (Blueprint $table) {
            $table->id();
            $table->nestedSet();
            $table->timestamps();
        });

        Schema::create('knowledge_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('knowledge_category_id');
            $table->integer('Nyelv_ID');
            $table->string('name');
            $table->string('slug')->index();
            $table->text('brief')->nullable();
            $table->timestamps();

            $table->foreign('knowledge_category_id')->references('id')->on('knowledge_categories')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('knowledge_category_translations');
        Schema::dropIfExists('knowledge_categories');
    }
}
