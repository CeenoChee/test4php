<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSzabadnapTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('szabadnap')) {
            Schema::create('szabadnap', function (Blueprint $table) {
                $table->bigInteger('Szabadnap_ID');
                $table->date('Datum');
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['Szabadnap_ID']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('szabadnap');
    }
}
