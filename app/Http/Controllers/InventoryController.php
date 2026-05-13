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
        // Validate the input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the inventory record for the selected product
        $inventory = Inventory::where('product_id', $id)->first();

        if (!$inventory) {
            return back()->with('error', 'Inventory not found.');
        }

        // Update the current stock quantity
        $inventory->quantity_on_hand += $request->quantity;
        $inventory->save();

        // Record the stock-in transaction
        DB::table('stock_in')->insert([
            'inventory_id'   => $inventory->id,
            'quantity'       => $request->quantity,
            'received_date'  => now()->toDateString(),
            'reference_type' => 'restock',
            'reference_id'   => time(), // Generates a simple unique reference number
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return back()->with('success', 'Product restocked successfully.');
    }
    public function movements()
    {
        $movements = DB::select("
            SELECT
                p.product_name,
                si.quantity,
                'Stock In' AS movement_type,
                si.reference_type,
                si.reference_id,
                si.created_at AS movement_date
            FROM stock_in si
            INNER JOIN inventory i ON si.inventory_id = i.id
            INNER JOIN products p ON i.product_id = p.id

            UNION ALL

            SELECT
                p.product_name,
                so.quantity,
                'Stock Out' AS movement_type,
                so.reference_type,
                so.reference_id,
                so.created_at AS movement_date
            FROM stock_out so
            INNER JOIN inventory i ON so.inventory_id = i.id
            INNER JOIN products p ON i.product_id = p.id

            ORDER BY movement_date DESC
        ");

        return view('movements', compact('movements'));
    }

}
