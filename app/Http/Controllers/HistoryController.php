<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    // 📋 Show all sales history (employee view)
    public function index()
    {
        $sales = DB::table('sales as s')
            ->leftJoin('customers as c', 'c.id', '=', 's.customer_id')
            ->leftJoin('users as u', 'u.id', '=', 'c.user_id')
            ->select(
                's.id',
                's.total_amount',
                's.payment_method',
                's.sale_date',
                'u.name as customer_name'
            )
            ->orderBy('s.created_at', 'desc')
            ->get();

        $items = DB::table('sale_details as sd')
            ->join('products as p', 'p.id', '=', 'sd.product_id')
            ->select(
                'sd.sale_id',
                'p.product_name',
                'sd.quantity',
                DB::raw('(sd.quantity * p.price) as subtotal')
            )
            ->get()
            ->groupBy('sale_id');

        return view('employee.history', compact('sales', 'items'));
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
    //customer history view
    public function history_customer(){

        $sales = DB::table('sales')
                ->where('customer_id', auth()->id())
                ->get();

            $paidCount = DB::table('sales')
                ->where('customer_id', auth()->id())
                ->where('payment_method', 'cash')
                ->count();

            $creditCount = DB::table('sales')
                ->where('customer_id', auth()->id())
                ->where('payment_method', 'credit')
                ->count();

            return view('customer.history', compact(
                'sales',
                'paidCount',
                'creditCount'
            ));
    }
}