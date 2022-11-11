<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGyartoForditasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('gyarto_forditas', function (Blueprint $table) {
            $table->charset = 'utf8mb4';

            $table->id();
            $table->bigInteger('Gyarto_ID');
            $table->integer('Nyelv_ID');
            $table->string('link');
            $table->text('warranty_content');
            $table->timestamps();

            $table->foreign('Gyarto_ID')->references('Gyarto_ID')->on('gyarto')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('gyarto_forditas');
    }
}
