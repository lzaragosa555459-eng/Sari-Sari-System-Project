<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $trendingProducts = DB::select
        ("
        SELECT 
            p.id,
            p.product_name,
            SUM(sd.quantity) AS total_sold,
            SUM(sd.quantity * p.price) AS total_revenue
        FROM sale_details sd
        JOIN products p ON p.id = sd.product_id
        GROUP BY p.id, p.product_name
        ORDER BY total_sold DESC
        LIMIT 10
        ");

    $monthlySales = DB::select("
        SELECT
            DATE_FORMAT(months.month_start, '%M %Y') AS label,
            (
                COALESCE(sales_totals.total_sales, 0) +
                COALESCE(credit_totals.total_credit_payments, 0)
            ) AS total
        FROM (
            /* Get all months that exist in either table */
            SELECT DATE_FORMAT(created_at, '%Y-%m-01') AS month_start
            FROM sales

            UNION

            SELECT DATE_FORMAT(created_at, '%Y-%m-01') AS month_start
            FROM credit_payments
        ) AS months

        /* Monthly totals from sales.amount_paid */
        LEFT JOIN (
            SELECT
                DATE_FORMAT(created_at, '%Y-%m-01') AS month_start,
                SUM(amount_paid) AS total_sales
            FROM sales
            GROUP BY DATE_FORMAT(created_at, '%Y-%m-01')
        ) AS sales_totals
            ON months.month_start = sales_totals.month_start

        /* Monthly totals from credit_payments.amount_paid */
        LEFT JOIN (
            SELECT
                DATE_FORMAT(created_at, '%Y-%m-01') AS month_start,
                SUM(amount_paid) AS total_credit_payments
            FROM credit_payments
            GROUP BY DATE_FORMAT(created_at, '%Y-%m-01')
        ) AS credit_totals
            ON months.month_start = credit_totals.month_start

        /* No GROUP BY needed because UNION already returns one row per month */
        ORDER BY months.month_start
    ");


        return view('reports', compact('trendingProducts', 'monthlySales'));
    }
}
