<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class InventoryController extends Controller
{
    public function index(){

        $products = DB::select("
            SELECT 
                p.id,
                p.product_name,
                p.price,
                p.expiration_date,
                c.category_name,
                i.quantity_on_hand,
                i.reorder_level,
                b.brand_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN inventory i ON p.id = i.product_id
        ");

        $totalProducts = DB::selectOne("
            SELECT COUNT(*) as total FROM products
        ");

        $lowStock = DB::selectOne("
            SELECT COUNT(*) as total
            FROM inventory
            WHERE quantity_on_hand <= reorder_level
        ");

        $outOfStock = DB::selectOne("
            SELECT COUNT(*) as total
            FROM inventory
            WHERE quantity_on_hand = 0
        ");

        return view('inventory', compact('totalProducts','lowStock','outOfStock', 'products'));
    }
}
