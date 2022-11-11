<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMegrendelesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('megrendeles')) {
            Schema::create('megrendeles', function (Blueprint $table) {
                $table->bigInteger('AruforgBiz_ID');
                $table->integer('Ev');
                $table->string('Sorozat');
                $table->integer('Sorszam');
                $table->bigInteger('Ugyfel_ID');
                $table->bigInteger('UgyfelDolgozo_ID');
                $table->string('Fuvar');
                $table->float('FuvarOsszeg', 15, 4)->default(0);
                $table->integer('Deviza_ID');
                $table->integer('FizetesiMod_ID');
                $table->integer('Szallitas')->nullable();
                $table->string('SzallNev')->nullable();
                $table->bigInteger('SzallOrszag_ID')->nullable();
                $table->string('SzallHelyseg')->nullable();
                $table->string('SzallUtcaHSzam')->nullable();
                $table->string('SzallIrSzam')->nullable();
                $table->text('Megjegyzes');
                $table->boolean('Visszaru');
                $table->boolean('Resszallitas');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['AruforgBiz_ID']);
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
        Schema::dropIfExists('megrendeles');
    }
}
