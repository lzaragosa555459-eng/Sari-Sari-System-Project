<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Store_cash;
class DashboardController extends Controller
{
    public function index()
    {
        // 📦 TOTAL SALES (ALL TRANSACTIONS)
        $totalSalesToday = DB::selectOne("
            SELECT COALESCE(SUM(total_amount), 0) AS total
            FROM sales
            WHERE DATE(sale_date) = CURDATE()
        ")->total;

        $totalSalesThisMonth = DB::selectOne("
            SELECT COALESCE(SUM(total_amount), 0) AS total
            FROM sales
            WHERE MONTH(sale_date) = MONTH(CURDATE())
            AND YEAR(sale_date) = YEAR(CURDATE())
        ")->total;

        $totalAllTimeSales = DB::selectOne("
            SELECT COALESCE(SUM(total_amount), 0) AS total
            FROM sales
        ")->total;


        // 💰 CASH COLLECTED (REAL MONEY TODAY)
        $cashCollectedToday = DB::selectOne("
            SELECT COALESCE(SUM(amount_paid - `change`), 0) AS total
            FROM sales
            WHERE payment_method = 'cash'
            AND DATE(sale_date) = CURDATE()
        ")->total;


        // 🧾 CREDIT PAYMENTS (UTANG COLLECTION)
        $creditPaymentsToday = DB::selectOne("
            SELECT COALESCE(SUM(amount_paid), 0) AS total
            FROM credit_payments
            WHERE DATE(payment_date) = CURDATE()
        ")->total;

        $creditPaymentsThisMonth = DB::selectOne("
            SELECT COALESCE(SUM(amount_paid), 0) AS total
            FROM credit_payments
            WHERE MONTH(payment_date) = MONTH(CURDATE())
            AND YEAR(payment_date) = YEAR(CURDATE())
        ")->total;


        // 📊 TOTAL REVENUE (REAL INCOME)
        $totalRevenueToday = $cashCollectedToday + $creditPaymentsToday;

        $totalRevenueAllTime = DB::selectOne("
            SELECT 
                COALESCE(SUM(total_amount), 0) +
                (
                    SELECT COALESCE(SUM(amount_paid), 0)
                    FROM credit_payments
                ) AS total
            FROM sales
        ")->total;


        // 🧾 TRANSACTIONS
        $totalTransactionsToday = DB::selectOne("
            SELECT COUNT(*) AS total
            FROM sales
            WHERE DATE(sale_date) = CURDATE()
        ")->total;


        // 📉 OUTSTANDING CREDIT
        $totalOutstandingCredit = DB::selectOne("
            SELECT COALESCE(SUM(x.balance), 0) AS total
            FROM (
                SELECT
                    c.id,
                    (s.total_amount - COALESCE(SUM(cp.amount_paid - cp.`change`), 0)) AS balance
                FROM credits c
                LEFT JOIN sales s ON c.sale_id = s.id
                LEFT JOIN credit_payments cp ON c.id = cp.credit_id
                GROUP BY c.id, s.total_amount
            ) x
        ")->total;

        // 📊 CHART DATA (SALES ONLY)
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


        $totalNet = Store_cash::first();

        return view('dashboard', compact(
            'totalSalesToday',
            'totalSalesThisMonth',
            'totalAllTimeSales',

            'cashCollectedToday',

            'creditPaymentsToday',
            'creditPaymentsThisMonth',

            'totalRevenueToday',
            'totalRevenueAllTime',

            'totalTransactionsToday',
            'totalOutstandingCredit',

            'labels',
            'data',
            'totalNet'
        ));
    }



    public function employee_index(){
        $todaySales = DB::selectOne("
            SELECT SUM(total_amount) as total
            FROM sales
            WHERE DATE(sale_date) = CURDATE()
        ");

        $todayTransactions = DB::selectOne("
            SELECT COUNT(*) as total
            FROM sales
            WHERE DATE(sale_date) = CURDATE()
        ");

        $recentSales = DB::select("
            SELECT s.*, u.name as customer_name
            FROM sales s
            JOIN customers c ON c.id = s.customer_id
            JOIN users u ON u.id = c.user_id
            WHERE DATE(s.sale_date) = CURDATE()
            ORDER BY s.id DESC
            LIMIT 10
        ");

        $lowStock = DB::select("
            SELECT p.product_name, i.quantity_on_hand
            FROM inventory i
            JOIN products p ON p.id = i.product_id
            WHERE i.quantity_on_hand <= i.reorder_level
        ");

        $cashSales = DB::selectOne("
            SELECT SUM(total_amount) as total
            FROM sales
            WHERE payment_method = 'cash'
            AND DATE(sale_date) = CURDATE()
        ");

         return view('employee.dashboard', compact('todaySales', 'todayTransactions', 'recentSales', 'lowStock', 'cashSales'));
    }
    public function customer_index(){
        return view('customer.dashboard');
    }
}
