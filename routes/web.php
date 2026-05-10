<?php

use App\Http\Controllers\CreditController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProductController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');

    Route::get('/sales', [SaleController::class, 'index'])->name('sales');

    Route::get('/credits', [CreditController::class, 'index'])->name('credits');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');

    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::post('/credit-pay', [CreditController::class, 'store_payment'])->name('credit.pay');

});
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/employee-dashboard', [DashboardController::class, 'employee_index'])->name('employee-dashboard');
    Route::get('/employee-pos', [PosController::class, 'index'])->name('pos');

    Route::post('/employee-pos/add', [PosController::class, 'addToCart'])->name('pos.add');

    Route::post('/employee-pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    Route::get('/employee-pos/remove/{id}', [PosController::class, 'removeItem'])->name('pos.remove');

    Route::get('/employee-pos/clear', [PosController::class, 'clearCart'])->name('pos.clear');

    Route::get('/employee/history', 
        [HistoryController::class, 'index']
    )->name('history');

    Route::get('/employee/transactions/{id}', 
        [HistoryController::class, 'show']
    )->name('employee.transactions.show');

    Route::middleware(['auth', 'role:2'])->group(function () {

        Route::get('/employee/transactions', 
            [HistoryController::class, 'index']
        )->name('employee.transactions');

        Route::get('/employee/receipt-data/{id}', function ($id) {

            $sale = DB::selectOne("
                SELECT s.*, u.name AS customer_name
                FROM sales s
                LEFT JOIN customers c ON c.id = s.customer_id
                LEFT JOIN users u ON u.id = c.user_id
                WHERE s.id = ?
            ", [$id]);

            $items = DB::select("
                SELECT 
                    p.product_name,
                    sd.quantity,
                    (sd.quantity * p.price) AS subtotal
                FROM sale_details sd
                JOIN products p ON p.id = sd.product_id
                WHERE sd.sale_id = ?
            ", [$id]);

            return response()->json([
                'sale' => $sale,
                'items' => $items
            ]);

        });

    });

    Route::get('/employee-book', [BookController::class, 'index'])->name('book');
    Route::post('/employee/bookings/checkout/{customerId}', [BookController::class, 'checkout'])
        ->name('employee.bookings.checkout');

    Route::post('/employee/credit', [CreditController::class, 'store'])->name('credit.store');
});

Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/customer/dashboard', [DashboardController::class, 'customer_index'])->name('customer-dashboard');
    Route::get('/customer/order', [OrderController::class, 'index'])->name('order');
    Route::get('/customer/cart', [CartController::class, 'index'])
    ->name('customer.cart.index');
    Route::post('/customer/cart', [CartController::class, 'store'])
    ->name('customer.cart.store');
    Route::post('/customer/cart/checkout', [CartController::class, 'checkout'])
        ->name('customer.cart.checkout');
    Route::get('/customer/history', [HistoryController::class, 'history_customer'])->name('customer-history');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart-clear');
    
});
require __DIR__.'/auth.php';
