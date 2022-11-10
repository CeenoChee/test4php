<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameGyartoAndGyartoForditasTable extends Migration
{
    public function up()
    {
        Schema::rename('gyarto', 'manufacturers');
        Schema::rename('gyarto_forditas', 'manufacturer_translations');
    }

    public function down()
    {
        Schema::rename('manufacturers', 'gyarto');
        Schema::rename('manufacturer_translations', 'gyarto_forditas');
    }
}
