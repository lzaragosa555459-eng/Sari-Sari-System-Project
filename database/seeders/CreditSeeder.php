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
                'sale_id' => 2,
                'balance' => 70,
                'due_date' => now()->addDays(7),
            ],
            [
                'sale_id' => 4,
                'balance' => 100,
                'due_date' => now()->addDays(5),
            ],
            [
                'sale_id' => 5,
                'balance' => 80,
                'due_date' => now()->subDays(2),
            ],
            [
                'sale_id' => 4,
                'balance' => 300,
                'due_date' => now()->addDays(10),
            ],
        ]);
    }
}