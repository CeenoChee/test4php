<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSzervizBizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('szerviz_biz')) {
            Schema::create('szerviz_biz', function (Blueprint $table) {
                $table->bigInteger('SzervizBiz_ID');
                $table->bigInteger('Ev');
                $table->string('Sorozat');
                $table->integer('Sorszam');
                $table->bigInteger('Ugyfel_ID');
                $table->bigInteger('UgyfelDolgozo_ID');
                $table->bigInteger('Deviza_ID');
                $table->string('GySzam');
                $table->text('EgyebHiba');
                $table->string('SzervizBerendezes');
                $table->string('SzervizTartozekok');
                $table->dateTime('BizDatum')->nullable();
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary(['SzervizBiz_ID']);
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
        Schema::dropIfExists('szerviz_biz');
    }
}
