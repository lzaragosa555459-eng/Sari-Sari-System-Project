<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventory')->insert([
            [
                'product_id' => 1,
                'quantity_on_hand' => 45, // 50 - 5
                'reorder_level' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'quantity_on_hand' => 27, // 30 - 3
                'reorder_level' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
