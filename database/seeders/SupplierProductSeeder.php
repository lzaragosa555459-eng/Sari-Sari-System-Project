<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('supplier_products')->insert([
            [
                'supplier_id' => 1,
                'product_id' => 1,
                'cost_price' => 55.00,
                'lead_time' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 1,
                'product_id' => 2,
                'cost_price' => 12.00,
                'lead_time' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 2,
                'product_id' => 1,
                'cost_price' => 54.00,
                'lead_time' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
