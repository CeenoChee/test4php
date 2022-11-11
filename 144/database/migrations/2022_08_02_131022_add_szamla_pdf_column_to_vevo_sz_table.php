<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSzamlaPdfColumnToVevoSzTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // DB::statement('ALTER TABLE vevo_sz ADD SzamlaPdf binary(32) NULL AFTER Deviza_ID');

        Schema::table('vevo_sz', function (Blueprint $table) {
            // $table->char('SzamlaPdf', 32)->charset('binary')->nullable()->after('Deviza_ID');
            // $table->binary('SzamlaPdf')->nullable()->after('Deviza_ID');
        });

        DB::statement('ALTER TABLE vevo_sz ADD SzamlaPdf LONGBLOB AFTER Deviza_ID');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('ALTER TABLE vevo_sz DROP SzamlaPdf');

        // Schema::table('vevo_sz', function (Blueprint $table) {
        //     $table->dropColumn('SzamlaPdf');
        // });
    }
}
