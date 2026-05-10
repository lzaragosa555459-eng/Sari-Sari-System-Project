<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{


    public function index()
    {
        $brands = DB::table('brands')->orderBy('id', 'desc')->paginate(6);
        $categories = DB::table('categories')->orderBy('id', 'desc')->paginate(6);
        $suppliers = DB::table('suppliers')->orderBy('id', 'desc')->paginate(6);
        $supplierProducts = DB::select("
            SELECT 
                sp.id,
                s.supplier_name,
                p.product_name,
                sp.cost_price,
                sp.lead_time
            FROM supplier_products sp
            JOIN suppliers s ON s.id = sp.supplier_id
            JOIN products p ON p.id = sp.product_id
        ");

        return view('maintenance', compact('brands', 'categories', 'suppliers','supplierProducts'));
    }
}
