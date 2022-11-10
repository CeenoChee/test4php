<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->integer('sort')->default(1);
            $table->boolean('active')->default(0);
            $table->date('valid_start')->nullable();
            $table->date('valid_end')->nullable();
            $table->timestamps();
        });

        Schema::create('card_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->text('description');
            $table->unsignedBigInteger('card_id');
            $table->integer('Nyelv_ID');
            $table->timestamps();

            $table->foreign('card_id')->references('id')->on('cards')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('card_translations');
        Schema::dropIfExists('cards');
    }
}
