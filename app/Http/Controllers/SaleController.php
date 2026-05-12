<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
       
        $sales = DB::table('sales as s')
            ->leftJoin('customers as c', 's.customer_id', '=', 'c.id')
            ->leftJoin('users as u', 'c.user_id', '=', 'u.id')
            ->leftJoin('users as emp', 's.employee_id', '=', 'emp.id')
            ->select(
                's.*',
                'u.name as customer_name',
                'u.email as customer_email',
                'emp.name as employee_name'
            )
            ->orderBy('s.created_at', 'desc')
            ->paginate(6);
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

        return view('sales', compact('sales', 'items'));
    }

}
