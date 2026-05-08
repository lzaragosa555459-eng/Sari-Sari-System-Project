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
            'bookings.created_at',

            DB::raw('SUM(bookings.quantity * products.price) as total'),

            DB::raw("GROUP_CONCAT(products.product_name SEPARATOR ', ') as products"),
            DB::raw("GROUP_CONCAT(bookings.quantity SEPARATOR ', ') as quantities")
        )
        ->groupBy(
            'bookings.customer_id',
            'users.name',
            'customers.contact_number',
            'bookings.status',
            'bookings.created_at'
        )
        ->orderBy('created_at','desc')
        ->get();

        return view('employee.book', compact('bookings'));
    }




    public function checkout(Request $request, $customerId)
    {
        // 1. Get ALL pending bookings for this customer
        $bookings = DB::table('bookings')
            ->join('products', 'products.id', '=', 'bookings.product_id')
            ->where('bookings.customer_id', $customerId)
            ->where('bookings.status', 'pending')
            ->select(
                'bookings.product_id',
                'bookings.quantity',
                'products.price'
            )
            ->get();

        if ($bookings->isEmpty()) {
            return back()->with('error', 'No pending bookings found.');
        }

        // 2. Compute total
        $total = 0;

        foreach ($bookings as $item) {
            $total += $item->price * $item->quantity;
        }

        // 3. GET CASH INPUT (FROM MODAL)
        $amountPaid = $request->amount_paid ?? 0;

        // validation (important for POS)
        if ($amountPaid < $total) {
            return back()->with('error', 'Insufficient payment.');
        }

        $change = $amountPaid - $total;

        // 4. CREATE SALE
        $saleId = DB::table('sales')->insertGetId([
            'customer_id' => $customerId,
            'employee_id' => auth()->id(),
            'sale_date' => now(),
            'total_amount' => $total,
            'amount_paid' => $amountPaid,
            'change' => $change,
            'payment_method' => 'cash',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. SALE DETAILS
        foreach ($bookings as $item) {

            DB::table('sale_details')->insert([
                'sale_id' => $saleId,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // deduct inventory
            DB::table('inventory')
                ->where('product_id', $item->product_id)
                ->decrement('quantity_on_hand', $item->quantity);
        }

        // 6. COMPLETE BOOKINGS
        DB::table('bookings')
            ->where('customer_id', $customerId)
            ->where('status', 'pending')
            ->update([
                'status' => 'completed'
            ]);

        return back()->with('success', 'Checkout completed successfully!');
    }
}
