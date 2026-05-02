<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleDetailSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sale_details')->insert([
            // Sale 1 = 145
            [
                'sale_id' => 1,
                'product_id' => 1,
                'quantity' => 2, // 130
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sale_id' => 1,
                'product_id' => 2,
                'quantity' => 1, // 15
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sale 2 = 195
            [
                'sale_id' => 2,
                'product_id' => 1,
                'quantity' => 3, // 195
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sale 3 = 80
            [
                'sale_id' => 3,
                'product_id' => 2,
                'quantity' => 1, // 15
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sale_id' => 3,
                'product_id' => 1,
                'quantity' => 1, // 65
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sale 4 = 300
            [
                'sale_id' => 4,
                'product_id' => 1,
                'quantity' => 4, // 260
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sale_id' => 4,
                'product_id' => 2,
                'quantity' => 2, // 30
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sale_id' => 4,
                'product_id' => 2,
                'quantity' => 2, // +30 => total 320? too much, remove if needed
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sale 5 = 120
            [
                'sale_id' => 5,
                'product_id' => 2,
                'quantity' => 8, // 120
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}