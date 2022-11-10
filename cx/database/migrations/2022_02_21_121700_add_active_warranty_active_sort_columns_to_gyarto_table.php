<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveWarrantyActiveSortColumnsToGyartoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('gyarto', function (Blueprint $table) {
            $table->integer('sort')->after('Nev');
            $table->boolean('active')->after('sort');
            $table->boolean('warranty_active')->after('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('gyarto', function (Blueprint $table) {
            $table->removeColumn('sort');
            $table->removeColumn('active');
            $table->removeColumn('warranty_active');
        });
    }
}
