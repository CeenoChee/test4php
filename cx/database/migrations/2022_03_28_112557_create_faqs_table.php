<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(0);
            $table->timestamps();
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faq_id');
            $table->integer('Nyelv_ID');
            $table->string('name');
            $table->text('body');
            $table->timestamps();

            $table->foreign('faq_id')->references('id')->on('faqs')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::create('faq_faq_category', function (Blueprint $table) {
            $table->unsignedBigInteger('faq_id');
            $table->unsignedBigInteger('faq_category_id');
            $table->integer('sort')->default(1);
            $table->timestamps();

            $table->foreign('faq_id')->references('id')->on('faqs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('faq_category_id')->references('id')->on('faq_categories')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('faq_faq_category');
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faqs');
    }
}
