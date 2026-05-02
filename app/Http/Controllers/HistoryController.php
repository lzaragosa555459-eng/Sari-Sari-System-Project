<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    // 📋 Show all sales history (employee view)
    public function index()
    {
        $sales = DB::select("
            SELECT 
                s.id,
                s.total_amount,
                s.amount_paid,
                s.change,
                s.payment_method,
                s.created_at,
                u.name AS customer_name
            FROM sales s
            LEFT JOIN customers c ON c.id = s.customer_id
            LEFT JOIN users u ON u.id = c.user_id
            WHERE DATE(sale_date) = CURDATE()
            ORDER BY s.created_at DESC
        ");

        return view('employee.history', compact('sales'));
    }

    // 🔍 View single receipt / sale details
    public function show($id)
    {
        $sale = DB::selectOne("
            SELECT 
                s.*,
                u.name AS customer_name
            FROM sales s
            LEFT JOIN customers c ON c.id = s.customer_id
            LEFT JOIN users u ON u.id = c.user_id
            WHERE s.id = ?
        ", [$id]);

        $items = DB::select("
            SELECT 
                sd.quantity,
                p.product_name,
                p.price,
                (sd.quantity * p.price) AS subtotal
            FROM sale_details sd
            JOIN products p ON p.id = sd.product_id
            WHERE sd.sale_id = ?
        ", [$id]);

        return view('employee.receipt', compact('sale', 'items'));
    }
}