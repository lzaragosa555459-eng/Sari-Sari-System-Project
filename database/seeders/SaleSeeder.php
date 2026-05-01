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
                'customer_id' => 1,
                'employee_id' => 2,
                'sale_date' => now()->subDays(3),
                'total_amount' => 130.00,
                'amount_paid' => 150.00,
                'change' => 20.00,
                'payment_method' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 2,
                'employee_id' => 2,
                'sale_date' => now()->subDays(2),
                'total_amount' => 200.00,
                'amount_paid' => 100.00,
                'change' => 0.00,
                'payment_method' => 'credit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'employee_id' => 2,
                'sale_date' => now()->subDay(),
                'total_amount' => 80.00,
                'amount_paid' => 80.00,
                'change' => 0.00,
                'payment_method' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 4,
                'employee_id' => 5,
                'sale_date' => now(),
                'total_amount' => 300.00,
                'amount_paid' => 0.00,
                'change' => 0.00,
                'payment_method' => 'credit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 5,
                'employee_id' => 5,
                'sale_date' => now(),
                'total_amount' => 120.00,
                'amount_paid' => 60.00,
                'change' => 0.00,
                'payment_method' => 'credit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 6,
                'employee_id' => 5,
                'sale_date' => now()->subHours(5),
                'total_amount' => 55.00,
                'amount_paid' => 60.00,
                'change' => 5.00,
                'payment_method' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 1,
                'employee_id' => 4,
                'sale_date' => now()->subHours(1),
                'total_amount' => 95.00,
                'amount_paid' => 100.00,
                'change' => 5.00,
                'payment_method' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}