<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockInSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stock_in')->insert([
            [
                'product_id' => 1,
                'quantity' => 50,
                'received_date' => now(),
                'reference_type' => 'Purchase',
                'reference_id' => 1001,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'quantity' => 30,
                'received_date' => now(),
                'reference_type' => 'Purchase',
                'reference_id' => 1002,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}