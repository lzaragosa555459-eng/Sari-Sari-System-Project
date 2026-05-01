<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'user_id' => 1,
                'contact_number' => '09123456789',
                'address' => 'Davao City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'contact_number' => '09234567890',
                'address' => 'Toril, Davao City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'contact_number' => '09345678901',
                'address' => 'Buhangin, Davao City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'contact_number' => '09456789012',
                'address' => 'Panabo City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'contact_number' => '09567890123',
                'address' => 'Tagum City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,
                'contact_number' => '09678901234',
                'address' => 'Digos City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}