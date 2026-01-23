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
            'price' => 999.00,
        ]);

        \App\Models\Product::create([
            'name' => 'Silver Plan',
            'description' => 'Standard plan with essential features',
            'price' => 499.00,
        ]);

        \App\Models\Product::create([
            'name' => 'Bronze Plan',
            'description' => 'Basic plan for getting started',
            'price' => 199.00,
        ]);
    }
}
