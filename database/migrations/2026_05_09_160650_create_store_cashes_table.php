<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_cash', function (Blueprint $table) {
            $table->id();

            // Starting money (e.g. 500 pesos)
            $table->decimal('opening_balance', 10, 2)->default(0);

            // Current cash in drawer (updates daily)
            $table->decimal('current_balance', 10, 2)->default(0);

            // Total sales income for the day
            $table->decimal('total_income', 10, 2)->default(0);

            // Total expenses (withdrawals, etc.)
            $table->decimal('total_expense', 10, 2)->default(0);

            // Optional notes (e.g. "Day 1 cash start")
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_cash');
    }
};