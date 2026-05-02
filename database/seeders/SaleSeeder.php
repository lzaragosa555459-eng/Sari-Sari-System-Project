<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sales')->insert([
            [
                'id' => 1,
                'customer_id' => 1,
                'employee_id' => 2,
                'sale_date' => '2026-04-29',
                'total_amount' => 145.00,
                'amount_paid' => 150.00,
                'change' => 5.00,
                'payment_method' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'customer_id' => 2,
                'employee_id' => 2,
                'sale_date' => '2026-04-30',
                'total_amount' => 195.00,
                'amount_paid' => 100.00,
                'change' => 0.00,
                'payment_method' => 'credit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'customer_id' => 3,
                'employee_id' => 2,
                'sale_date' => '2026-05-01',
                'total_amount' => 80.00,
                'amount_paid' => 80.00,
                'change' => 0.00,
                'payment_method' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'customer_id' => 4,
                'employee_id' => 5,
                'sale_date' => '2026-05-02',
                'total_amount' => 300.00,
                'amount_paid' => 0.00,
                'change' => 0.00,
                'payment_method' => 'credit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'customer_id' => 5,
                'employee_id' => 5,
                'sale_date' => '2026-05-02',
                'total_amount' => 120.00,
                'amount_paid' => 60.00,
                'change' => 0.00,
                'payment_method' => 'credit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}