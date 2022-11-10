<?php

namespace Database\Seeders;

use App\Models\Newsletter;
use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Newsletter::where('name', 'TECHNICAL')->count() == 0) {
            Newsletter::create(
                [
                    'name' => 'TECHNICAL',
                    'label' => 'Műszaki',
                    'description' => '',
                ]
            );
        }

        if (Newsletter::where('name', 'MARKETING')->count() == 0) {
            Newsletter::create(
                [
                    'name' => 'MARKETING',
                    'label' => 'Kereskedelmi',
                    'description' => '',
                ]
            );
        }
    }
}
