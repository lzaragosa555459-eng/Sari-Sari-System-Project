<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = DB::select("
            SELECT 
                s.*,
                u.name as customer_name,
                u.email as customer_email,
                emp.name as employee_name
            FROM sales s
            LEFT JOIN customers c ON s.customer_id = c.id
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN users emp ON s.employee_id = emp.id
            ORDER BY s.sale_date DESC
        ");

        return view('sales', compact('sales'));
    }

}
