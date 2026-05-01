<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('brands')->insert([
            ['brand_name' => 'Coca Cola', 'created_at' => now(), 'updated_at' => now()],
            ['brand_name' => 'Nestle', 'created_at' => now(), 'updated_at' => now()],
            ['brand_name' => 'Lucky Me', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}