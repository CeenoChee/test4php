<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVevoSzTetelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vevo_sz_tetel')) {
            Schema::create('vevo_sz_tetel', function (Blueprint $table) {
                $table->bigInteger('VevoSz_ID');
                $table->bigInteger('VevoSzTetel_ID');
                $table->bigInteger('Termek_ID')->nullable();
                $table->text('Szoveg')->nullable();
                $table->float('NettoEgysegar', 15, 4)->nullable();
                $table->float('Mennyiseg', 15, 4)->nullable();
                $table->float('EngedmenySzazalek', 15, 4)->nullable();
                $table->float('EngedmenyOsszeg', 15, 4)->nullable();
                $table->float('NettoErtek', 15, 4)->nullable();
                $table->integer('MennyisegEgyseg_ID')->nullable();
                $table->tinyInteger('AfaKulcs')->nullable();
                $table->dateTime('ModDatum')->nullable();
                $table->dateTime('FelvDatum')->nullable();

                $table->primary([
                    'VevoSz_ID',
                    'VevoSzTetel_ID'
                ]);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vevo_sz_tetel');
    }
}
