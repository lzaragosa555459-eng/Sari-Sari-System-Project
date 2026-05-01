<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'user_id' => 2,
                'position' => 'Cashier',
                'salary' => 350.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'position' => 'Sales Clerk',
                'salary' => 400.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}