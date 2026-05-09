<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreCash;
use App\Models\Store_cash;

class StoreCashSeeder extends Seeder
{
    public function run(): void
    {
        Store_cash::create([
            'opening_balance' => 500,
            'current_balance' => 500,
            'total_income' => 0,
            'total_expense' => 0,
            'description' => 'Initial capital for sari-sari store',
        ]);
    }
}