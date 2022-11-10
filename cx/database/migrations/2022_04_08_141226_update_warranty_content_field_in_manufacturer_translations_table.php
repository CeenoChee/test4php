<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWarrantyContentFieldInManufacturerTranslationsTable extends Migration
{
    public function up()
    {
        Schema::table('manufacturer_translations', function (Blueprint $table) {
            $table->text('warranty_content')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('manufacturer_translations', function (Blueprint $table) {
            $table->text('warranty_content')->nullable(false)->change();
        });
    }
}
