<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('faq_categories', function (Blueprint $table) {
            $table->id();
            $table->nestedSet();
            $table->timestamps();
        });

        Schema::create('faq_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faq_category_id');
            $table->integer('Nyelv_ID')->comment('Ehhez a nyelvhez tartozik');
            $table->string('slug');
            $table->string('name');
            $table->timestamps();

            $table->foreign('faq_category_id')->references('id')->on('faq_categories')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('faq_category_translations');
        Schema::dropIfExists('faq_categories');
    }
}
