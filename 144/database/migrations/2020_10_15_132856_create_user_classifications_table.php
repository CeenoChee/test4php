<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_classifications', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('UgyfelDolgozoKategoria_ID');
            $table->bigInteger('UgyfelDolgozoKategoriaTetel_ID');

            $table->primary([
                'user_id',
                'UgyfelDolgozoKategoria_ID',
                'UgyfelDolgozoKategoriaTetel_ID',
            ], 'user_classifications_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_classifications');
    }
}
