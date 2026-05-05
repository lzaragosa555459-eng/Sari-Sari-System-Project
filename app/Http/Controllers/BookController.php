<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $sales = DB::select("
            SELECT 
                s.id AS sale_id,
                s.sale_date,
                s.total_amount,
                s.amount_paid,
                s.change,
                s.payment_method,

                u.id AS user_id,
                u.name,
                u.email,

                c.contact_number,
                c.address

            FROM sales s
            LEFT JOIN users u ON u.id = s.customer_id
            LEFT JOIN customers c ON c.user_id = u.id
            ORDER BY s.sale_date DESC
        ");

        return view('employee.book', compact('sales'));
    }
}
