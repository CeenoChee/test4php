<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSzervizBizEsemenyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('szerviz_biz_esemeny')) {
            Schema::create('szerviz_biz_esemeny', function (Blueprint $table) {
                $table->bigInteger('SzervizBiz_ID');
                $table->bigInteger('SzervizBizEsemeny_ID');
                $table->integer('Sorrend');
                $table->integer('EsemenyTipus');
                $table->string('Datum');
                $table->dateTime('ModDatum')->nullable();
                $table->dateTime('FelvDatum')->nullable();

                $table->primary(['SzervizBiz_ID', 'SzervizBizEsemeny_ID']);
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
        Schema::dropIfExists('szerviz_biz_esemeny');
    }
}
