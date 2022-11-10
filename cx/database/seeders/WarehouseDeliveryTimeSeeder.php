<?php

namespace Database\Seeders;

use App\Models\WarehouseDeliveryTime;
use Illuminate\Database\Seeder;

class WarehouseDeliveryTimeSeeder extends Seeder
{
    public function run()
    {
        if (! WarehouseDeliveryTime::where([['ForrasRaktar_ID', 11], ['CelRaktar_ID', 11]])->first()) {
            WarehouseDeliveryTime::factory()->create([
                'ForrasRaktar_ID' => 11,
                'CelRaktar_ID' => 11,
                'SzallIdoOra' => 0,
                'Hatarido' => '23:59:59',
            ]);
        }

        if (! WarehouseDeliveryTime::where([['ForrasRaktar_ID', 11], ['CelRaktar_ID', 15]])->first()) {
            WarehouseDeliveryTime::factory()->create([
                'ForrasRaktar_ID' => 11,
                'CelRaktar_ID' => 15,
                'SzallIdoOra' => 15,
                'Hatarido' => '13:00:00',
            ]);
        }

        if (! WarehouseDeliveryTime::where([['ForrasRaktar_ID', 15], ['CelRaktar_ID', 11]])->first()) {
            WarehouseDeliveryTime::factory()->create([
                'ForrasRaktar_ID' => 15,
                'CelRaktar_ID' => 11,
                'SzallIdoOra' => 13,
                'Hatarido' => '15:00:00',
            ]);
        }

        if (! WarehouseDeliveryTime::where([['ForrasRaktar_ID', 15], ['CelRaktar_ID', 15]])->first()) {
            WarehouseDeliveryTime::factory()->create([
                'ForrasRaktar_ID' => 15,
                'CelRaktar_ID' => 15,
                'SzallIdoOra' => 13,
                'Hatarido' => '15:00:00',
            ]);
        }

        if (! WarehouseDeliveryTime::where([['ForrasRaktar_ID', 20], ['CelRaktar_ID', 11]])->first()) {
            WarehouseDeliveryTime::factory()->create([
                'ForrasRaktar_ID' => 20,
                'CelRaktar_ID' => 11,
                'SzallIdoOra' => 456,
                'Hatarido' => '23:59:59',
            ]);
        }

        if (! WarehouseDeliveryTime::where([['ForrasRaktar_ID', 20], ['CelRaktar_ID', 15]])->first()) {
            WarehouseDeliveryTime::factory()->create([
                'ForrasRaktar_ID' => 20,
                'CelRaktar_ID' => 15,
                'SzallIdoOra' => 456,
                'Hatarido' => '23:59:59',
            ]);
        }
    }
}
