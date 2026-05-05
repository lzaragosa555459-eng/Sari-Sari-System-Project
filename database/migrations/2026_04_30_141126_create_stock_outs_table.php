<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_out', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')
                ->constrained('inventory')
                ->onDelete('cascade');
            $table->integer('quantity');
            $table->enum('reason', [
                'sold',
                'damaged',
                'expired',
                'returned_to_supplier',
                'adjustment',
                'lost',
                'theft',
                'transfer_out'
            ])->default('sold');
            $table->date('transaction_date');
            $table->enum('reference_type', ['sale','damage','adjustment']);
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
