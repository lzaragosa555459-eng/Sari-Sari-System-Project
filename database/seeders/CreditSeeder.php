<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreditSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('credits')->insert([
            [
                'customer_id' => 1,
                'sale_id' => 1,
                'total_amount' => 150.00,
                'balance' => 150.00,
                'due_date' => now()->addDays(7),
                'status' => 'unpaid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 2,
                'sale_id' => 2,
                'total_amount' => 200.00,
                'balance' => 100.00,
                'due_date' => now()->addDays(5),
                'status' => 'partial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'sale_id' => 3,
                'total_amount' => 80.00,
                'balance' => 0.00,
                'due_date' => now()->subDays(2),
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 4,
                'sale_id' => 4,
                'total_amount' => 300.00,
                'balance' => 300.00,
                'due_date' => now()->addDays(10),
                'status' => 'unpaid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 5,
                'sale_id' => 5,
                'total_amount' => 120.00,
                'balance' => 60.00,
                'due_date' => now()->addDays(3),
                'status' => 'partial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}