<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->integer('sort')->default(1);
            $table->boolean('active')->defualt(0);
            $table->date('valid_start')->nullable();
            $table->date('valid_end')->nullable();
            $table->timestamps();
        });

        Schema::create('banner_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->text('description');
            $table->unsignedBigInteger('banner_id');
            $table->integer('Nyelv_ID');
            $table->timestamps();

            $table->foreign('banner_id')->references('id')->on('banners')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('banner_translations');
        Schema::dropIfExists('banners');
    }
}
