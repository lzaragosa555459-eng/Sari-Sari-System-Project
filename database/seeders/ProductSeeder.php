<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'product_name' => 'Coke 1.5L',
                'category_id' => 2,
                'brand_id' => 1,
                'price' => 65.00,
                'expiration_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Lucky Me Pancit Canton',
                'category_id' => 1,
                'brand_id' => 3,
                'price' => 15.00,
                'expiration_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}