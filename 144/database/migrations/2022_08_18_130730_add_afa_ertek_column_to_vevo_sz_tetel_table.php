<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAfaErtekColumnToVevoSzTetelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('vevo_sz_tetel', function (Blueprint $table) {
            $table->float('AfaErtek', 15, 4)->nullable()->after('AfaKulcs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('vevo_sz_tetel', function (Blueprint $table) {
            $table->dropColumn('AfaErtek');
        });
    }
}
