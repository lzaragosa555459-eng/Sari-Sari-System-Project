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
                'total_amount' => 150,
                'balance' => 70,
                'due_date' => now()->addDays(7),
            ],
            [
                'customer_id' => 2,
                'sale_id' => 2,
                'total_amount' => 200,
                'balance' => 100,
                'due_date' => now()->addDays(5),
            ],
            [
                'customer_id' => 3,
                'sale_id' => 3,
                'total_amount' => 80,
                'balance' => 80,
                'due_date' => now()->subDays(2),
            ],
            [
                'customer_id' => 4,
                'sale_id' => 4,
                'total_amount' => 300,
                'balance' => 300,
                'due_date' => now()->addDays(10),
            ],
            [
                'customer_id' => 5,
                'sale_id' => 5,
                'total_amount' => 120,
                'balance' => 120,
                'due_date' => now()->addDays(3),
            ],
        ]);
    }
}