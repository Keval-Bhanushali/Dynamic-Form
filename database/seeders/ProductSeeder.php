<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::create([
            'name' => 'Gold Plan',
            'description' => 'Premium plan with all features',
            'device_limit' => 4,
            'price' => 999.00,
        ]);

        \App\Models\Product::create([
            'name' => 'Silver Plan',
            'description' => 'Standard plan with essential features',
            'device_limit' => 2,
            'price' => 499.00,
        ]);

        \App\Models\Product::create([
            'name' => 'Bronze Plan',
            'description' => 'Basic plan for getting started',
            'device_limit' => 1,
            'price' => 199.00,
        ]);
    }
}
