<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockOutSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stock_out')->insert([
            [
                'product_id' => 1,
                'quantity' => 5,
                'reason' => 'Sold',
                'transaction_date' => now(),
                'reference_type' => 'sale',
                'reference_id' => 2001,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,  
                'quantity' => 3,
                'reason' => 'Sold',
                'transaction_date' => now(),
                'reference_type' => 'sale',
                'reference_id' => 2002,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}