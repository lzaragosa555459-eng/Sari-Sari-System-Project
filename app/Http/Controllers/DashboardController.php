<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalsalesTransactionToday = DB::selectOne("
            SELECT COUNT(*) AS total_transaction_Today FROM sales 
            WHERE DATE(sale_date) = CURDATE()
        ")->total_transaction_Today;

        $totalSalesToday = DB::selectOne("
            SELECT SUM(total_amount) AS total_sales_today
            FROM sales
            WHERE DATE(sale_date) = CURDATE()
        ")->total_sales_today;

        $totalAmount = DB::selectOne("
            SELECT SUM(total_amount) as total FROM sales
        ");

        $totalSalesThisMonth = DB::selectOne("
            SELECT COALESCE(SUM(total_amount), 0) AS total_sales_this_month
            FROM sales
            WHERE MONTH(sale_date) = MONTH(CURDATE())
            AND YEAR(sale_date) = YEAR(CURDATE())
        ")->total_sales_this_month;


        $netCashKeptToday = DB::selectOne("
            SELECT COALESCE(SUM(amount_paid - `change`), 0) AS net_cash_kept_today
            FROM sales
            WHERE payment_method = 'cash'
            AND DATE(sale_date) = CURDATE()
        ")->net_cash_kept_today;

        $totalOutstandingCredit = DB::selectOne("
            SELECT COALESCE(SUM(balance), 0) AS total_outstanding_credit
            FROM credits
            WHERE balance > 0
        ")->total_outstanding_credit;

        $sales = DB::select("
            SELECT DATE(sale_date) as date,
                SUM(total_amount) as total
            FROM sales
            GROUP BY DATE(sale_date)
            ORDER BY date ASC
        ");

        $labels = [];
        $data = [];

        foreach ($sales as $sale) {
            $labels[] = $sale->date;
            $data[] = $sale->total;
        }

        return view('dashboard', compact(
            'totalSalesToday',
            'totalAmount', 
            'totalsalesTransactionToday', 
            'totalSalesThisMonth', 'netCashKeptToday', 
            'totalOutstandingCredit',
            'labels', 
            'data'
        ));
    }
}
