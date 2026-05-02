<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditController extends Controller
{
    public function index()
    {
        $credits = DB::select("
            SELECT 
                c.id,
                u.name AS customer_name,
                c.total_amount,
                COALESCE(SUM(cp.amount_paid), 0) AS amount_paid,
                c.total_amount - COALESCE(SUM(cp.amount_paid), 0) AS balance,
                c.due_date
            FROM credits c
            LEFT JOIN customers cust ON c.customer_id = cust.id
            LEFT JOIN users u ON cust.user_id = u.id
            LEFT JOIN credit_payments cp ON c.id = cp.credit_id
            GROUP BY 
                c.id,
                u.name,
                c.total_amount,
                c.due_date
        ");

        return view('credits', compact('credits'));
    }
}
