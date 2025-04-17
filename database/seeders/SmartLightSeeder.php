<?php

namespace Database\Seeders;

use App\Models\SmartLight;
use Illuminate\Database\Seeder;

class SmartLightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample smart lights for testing
        $smartLights = [
            [
                'name' => 'Living Room Main',
                'status' => 'On',
                'location' => 'Living Room',
                'brightness' => 85,
            ],
            [
                'name' => 'Kitchen Ceiling',
                'status' => 'On',
                'location' => 'Kitchen',
                'brightness' => 100,
            ],
            [
                'name' => 'Bedroom Lamp',
                'status' => 'Off',
                'location' => 'Master Bedroom',
                'brightness' => 50,
            ],
            [
                'name' => 'Bathroom Light',
                'status' => 'Off',
                'location' => 'Bathroom',
                'brightness' => 70,
            ],
            [
                'name' => 'Office Desk Lamp',
                'status' => 'On',
                'location' => 'Home Office',
                'brightness' => 65,
            ],
        ];

        // Insert data into database
        foreach ($smartLights as $light) {
            SmartLight::create($light);
        }
    }
}
