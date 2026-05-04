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
                'balance' => 45,
                'due_date' => now()->addDays(7),
                'status' => 'partial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sale_id' => 4,
                'balance' => 270,
                'due_date' => now()->addDays(5),
                'status' => 'partial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sale_id' => 5,
                'balance' => 50,
                'due_date' => now()->subDays(2),
                'status' => 'partial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}