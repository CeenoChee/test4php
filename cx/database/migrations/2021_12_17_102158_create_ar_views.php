<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateArViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(file_get_contents(base_path('database/migrations/views/view_termek_ar.sql')));
        DB::statement(file_get_contents(base_path('database/migrations/views/view_termek_ugyfel_ar.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_termek_ar');
        DB::statement('DROP VIEW IF EXISTS view_termek_ugyfel_ar');
    }
}
