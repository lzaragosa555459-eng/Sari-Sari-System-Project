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
                DATE_FORMAT(MIN(created_at), '%M %Y') AS label,
                SUM(total_amount) AS total
            FROM sales
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY YEAR(created_at), MONTH(created_at)
        ");


        return view('reports', compact('trendingProducts', 'monthlySales'));
    }
}
