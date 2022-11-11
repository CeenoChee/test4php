<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTableDropProperties extends Migration
{
    public function up()
    {
        Schema::dropIfExists('properties');

        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key');
                $table->string('value');

                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('settings');

        if (!Schema::hasTable('properties')) {
            Schema::create('properties', function (Blueprint $table) {
                $table->string('name');
                $table->longText('value');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();

                $table->primary('name');
            });
        }
    }
}
