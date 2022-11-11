<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            NewsletterSeeder::class,
            WarehouseDeliveryTimeSeeder::class,
            SettingSeeder::class,
        ]);

        if ($this->isEnvDev()) {
            $this->call([]);
        }
    }

    /**
     * Determine if the current environment is not production (is dev).
     */
    private function isEnvDev(): bool
    {
        return config('app.env') !== 'production';
    }
}
