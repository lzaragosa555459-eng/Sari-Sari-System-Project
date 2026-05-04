<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->search ?? '';

    $products = DB::select("
        SELECT 
            p.id,
            p.product_name AS name,
            p.price,
            i.quantity_on_hand
        FROM products p
        LEFT JOIN inventory i ON i.product_id = p.id
        WHERE p.product_name LIKE ?
    ", ["%{$search}%"]);

        return view('customer.order', compact('products'));
    }
}
