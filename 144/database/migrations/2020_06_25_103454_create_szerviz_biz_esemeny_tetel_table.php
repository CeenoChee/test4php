<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSzervizBizEsemenyTetelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('szerviz_biz_esemeny_tetel')) {
            Schema::create('szerviz_biz_esemeny_tetel', function (Blueprint $table) {
                $table->bigInteger('SzervizBiz_ID');
                $table->bigInteger('SzervizBizEsemeny_ID');
                $table->bigInteger('Termek_ID');
                $table->float('NettoEgysegar', 15, 4);
                $table->float('Mennyiseg');
                $table->bigInteger('Garancialis');
                $table->dateTime('FelvDatum')->nullable();
                $table->dateTime('ModDatum')->nullable();

                $table->primary([
                    'SzervizBiz_ID',
                    'SzervizBizEsemeny_ID',
                    'Termek_ID'], 'szb_id_szbe_id_t_id_primary');
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
        Schema::dropIfExists('szerviz_biz_esemeny_tetel');
    }
}
