<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('tudastar');
        Schema::dropIfExists('tudastar_csoport_tudastar');
        Schema::dropIfExists('tudastar_kapcsolodo');

        Schema::create('knowledges', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(0);
            $table->date('published_at')->nullable()->comment('Publikalas kezdete');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('knowledge_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('brief')->nullable();
            $table->longText('body')->nullable();
            $table->longText('body_stripped')->nullable();
            $table->unsignedBigInteger('knowledge_id');
            $table->integer('Nyelv_ID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('knowledge_id')
                ->references('id')
                ->on('knowledges')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::create('knowledge_knowledge_category', function (Blueprint $table) {
            $table->unsignedBigInteger('knowledge_id');
            $table->unsignedBigInteger('knowledge_category_id');
            $table->integer('sort')->default(1);
            $table->timestamps();

            $table->foreign('knowledge_id')->references('id')->on('knowledges')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('knowledge_category_id')->references('id')->on('knowledge_categories')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('knowledge_knowledge_category');
        Schema::dropIfExists('knowledge_translations');
        Schema::dropIfExists('knowledges');
    }
}
