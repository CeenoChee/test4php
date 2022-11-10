<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        if (Setting::where('key', Setting::MAINTENANCE_MODE)->count() > 0) {
            return;
        }

        Setting::create([
            'key' => Setting::MAINTENANCE_MODE,
            'value' => 'false',
        ]);
    }
}
