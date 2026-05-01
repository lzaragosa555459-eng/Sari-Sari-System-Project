<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\SaleSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SaleDetailSeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\CreditSeeder;
use Database\Seeders\SupplierProductSeeder;
use Database\Seeders\CreditPaymentSeeder;
use Database\Seeders\StockInSeeder;
use Database\Seeders\StockOutSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            EmployeeSeeder::class,
            SaleSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            SaleDetailSeeder::class,
            SupplierSeeder::class,
            CreditSeeder::class,
            SupplierProductSeeder::class,
            CreditPaymentSeeder::class,
            StockInSeeder::class,
            StockOutSeeder::class,
        ]);
    }
}
