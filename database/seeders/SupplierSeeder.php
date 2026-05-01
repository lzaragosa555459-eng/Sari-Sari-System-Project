<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
public function run(): void
{
    DB::table('suppliers')->insert([
        [
            'supplier_name' => 'Coca Cola PH',
            'contact_number' => '09111111111',
            'address' => 'Davao City',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'supplier_name' => 'Nestlé Philippines',
            'contact_number' => '09222222222',
            'address' => 'Manila',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'supplier_name' => 'Universal Robina Corporation (URC)',
            'contact_number' => '09333333333',
            'address' => 'Quezon City',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'supplier_name' => 'Monde Nissin',
            'contact_number' => '09444444444',
            'address' => 'Laguna',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'supplier_name' => 'Local Davao Distributor',
            'contact_number' => '09555555555',
            'address' => 'Davao City',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}
}   
