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
                'bookings.customer_id',
                'users.name as customer_name',
                'customers.contact_number',
                'bookings.status',

                DB::raw("GROUP_CONCAT(products.product_name SEPARATOR ', ') as products"),
                DB::raw("GROUP_CONCAT(bookings.quantity SEPARATOR ', ') as quantities")
            )
            ->groupBy(
                'bookings.customer_id',
                'users.name',
                'customers.contact_number',
                'bookings.status'
            )
            ->get();

        return view('employee.book', compact('bookings'));
    }




    public function checkout($id)
    {
        // 1. Get booking header (customer only)
        $booking = DB::table('bookings')
            ->where('id', $id)
            ->first();

        if (!$booking || $booking->status == 'completed') {
            return back()->with('error', 'Invalid or already checked out booking.');
        }

        // 2. Get ALL items under this customer booking (IMPORTANT FIX)
        $items = DB::table('bookings')
            ->join('products', 'products.id', '=', 'bookings.product_id')
            ->where('bookings.customer_id', $booking->customer_id)
            ->where('bookings.status', '!=', 'completed')
            ->select(
                'bookings.product_id',
                'bookings.quantity',
                'products.price'
            )
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'No items found.');
        }

        // 3. Compute total
        $total = 0;

        foreach ($items as $item) {
            $total += $item->price * $item->quantity;
        }

        // 4. CREATE SALE (ONE customer only)
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

        // 5. CREATE SALE DETAILS (MANY PRODUCTS)
        foreach ($items as $item) {

            DB::table('sale_details')->insert([
                'sale_id' => $saleId,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. UPDATE BOOKING STATUS (ALL customer bookings)
        DB::table('bookings')
            ->where('customer_id', $booking->customer_id)
            ->update([
                'status' => 'completed'
            ]);

        return back()->with('success', 'Checkout completed successfully!');
    }
}
