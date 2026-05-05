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
}
