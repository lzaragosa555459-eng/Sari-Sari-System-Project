<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $bookings = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.customer_id')
            ->leftJoin('customers', 'customers.user_id', '=', 'users.id')
            ->join('products', 'products.id', '=', 'bookings.product_id')
            ->select(
                'bookings.id',
                'users.name as customer_name',
                'customers.contact_number',
                'products.product_name',
                'bookings.quantity',
                'bookings.status'
            )
            ->get();

        return view('employee.book', compact('bookings'));
    }




    public function checkout($id)
    {
        // 1. Get booking with product + customer
        $booking = DB::table('bookings')
            ->where('id', $id)
            ->first();

        if (!$booking || $booking->status == 'completed') {
            return back()->with('error', 'Invalid or already checked out booking.');
        }

        // 2. Get product info
        $product = DB::table('products')
            ->where('id', $booking->product_id)
            ->first();

        $total = $product->price * $booking->quantity;

        // 3. CREATE SALE (header)
        $saleId = DB::table('sales')->insertGetId([
            'customer_id' => $booking->customer_id,
            'employee_id' => auth()->id(),
            'sale_date' => now(),
            'total_amount' => $total,
            'amount_paid' => $total,
            'change' => 0,
            'payment_method' => 'cash',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. CREATE SALE DETAILS
        DB::table('sale_details')->insert([
            'sale_id' => $saleId,
            'product_id' => $booking->product_id,
            'quantity' => $booking->quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. UPDATE BOOKING STATUS
        DB::table('bookings')
            ->where('id', $id)
            ->update([
                'status' => 'completed'
            ]);

        return back()->with('success', 'Checkout completed successfully!');
    }
}
