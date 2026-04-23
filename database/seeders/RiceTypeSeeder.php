<?php

namespace Database\Seeders;

use App\Models\RiceType;
use Illuminate\Database\Seeder;

class RiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $riceTypes = [
            [
                'name' => 'Jasmine',
                'description' => 'Premium jasmine rice with fragrant aroma',
                'stock_kg' => 30,
                'price_per_kilo' => 50.00,
                'is_active' => true,
            ],
            [
                'name' => 'Dinorado',
                'description' => 'Golden dinorado rice, excellent quality',
                'stock_kg' => 0,
                'price_per_kilo' => 45.00,
                'is_active' => true,
            ],
            [
                'name' => 'Sinandomeng',
                'description' => 'Local sinandomeng variety rice',
                'stock_kg' => 50,
                'price_per_kilo' => 35.00,
                'is_active' => true,
            ],
            [
                'name' => 'Brown Rice',
                'description' => 'Healthy brown rice with high fiber',
                'stock_kg' => 25,
                'price_per_kilo' => 55.00,
                'is_active' => true,
            ],
        ];

        foreach ($riceTypes as $riceType) {
            RiceType::create($riceType);
        }
    }
}
