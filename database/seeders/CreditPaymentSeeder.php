<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreditPaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('credit_payments')->insert([
            [
                'credit_id' => 1,
                'amount_paid' => 50.00,
                'payment_date' => now()->toDateString(),
                'method' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'credit_id' => 1,
                'amount_paid' => 30.00,
                'payment_date' => now()->subDays(1)->toDateString(),
                'method' => 'GCash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'credit_id' => 2,
                'amount_paid' => 100.00,
                'payment_date' => now()->subDays(2)->toDateString(),
                'method' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}