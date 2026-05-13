<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        $products = DB::select("
            SELECT 
                p.id,
                p.product_name,
                p.price,
                p.expiration_date,
                c.category_name,
                b.brand_name,
                COALESCE(i.quantity_on_hand, 0) AS quantity_on_hand,
                COALESCE(i.reorder_level, 0) AS reorder_level
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN inventory i ON p.id = i.product_id
            ORDER BY p.product_name DESC
        ");

        $totalProducts = DB::selectOne("
            SELECT COUNT(*) AS total FROM products
        ");

        $lowStock = DB::selectOne("
            SELECT COUNT(*) AS total
            FROM inventory
            WHERE quantity_on_hand <= reorder_level
            AND quantity_on_hand > 0
        ");

        $outOfStock = DB::selectOne("
            SELECT COUNT(*) AS total
            FROM inventory
            WHERE quantity_on_hand = 0
        ");

        $brands = DB::select("
            SELECT * FROM brands
        ");

        $categories = DB::select("
            SELECT * FROM categories
        ");

        return view('inventory', compact(
            'totalProducts',
            'lowStock',
            'outOfStock',
            'products',
            'brands',
            'categories'
        ));
    }


    public function restock(Request $request, $id)
    {
        $inventory = Inventory::where('product_id', $id)->first();

        if (!$inventory) {
            return back()->with('error', 'Inventory not found.');
        }

        $inventory->quantity_on_hand += $request->quantity;
        $inventory->save();

        return back()->with('success', 'Product restocked successfully.');
    }


}
