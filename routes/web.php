<?php

use App\Http\Controllers\CreditController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');

    Route::get('/sales', [SaleController::class, 'index'])->name('sales');

    Route::get('/credits', [CreditController::class, 'index'])->name('credits');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');

});
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
});
require __DIR__.'/auth.php';
