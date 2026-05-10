<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{

    public function index()
    {
        $brands = DB::table('brands')->orderByDesc('id')->paginate(6);
        $categories = DB::table('categories')->orderByDesc('id')->paginate(6);
        $suppliers = DB::table('suppliers')->orderByDesc('id')->paginate(6);

        // ✅ ADD THIS
        $products = DB::table('products')->orderByDesc('id')->get();

        $supplierProducts = DB::select("
            SELECT 
                sp.id,
                sp.supplier_id,
                sp.product_id,
                s.supplier_name,
                p.product_name,
                sp.cost_price,
                sp.lead_time
            FROM supplier_products sp
            JOIN suppliers s ON s.id = sp.supplier_id
            JOIN products p ON p.id = sp.product_id
            ORDER BY sp.id DESC
        ");

        return view('maintenance', compact(
            'brands',
            'categories',
            'suppliers',
            'products',   // ✅ IMPORTANT FIX
            'supplierProducts'
        ));
    }
    public function store(Request $request)
    {
        DB::insert("
            INSERT INTO supplier_products (supplier_id, product_id, cost_price, lead_time, created_at, updated_at)
            VALUES (?, ?, ?, ?, NOW(), NOW())
        ", [
            $request->supplier_id,
            $request->product_id,
            $request->cost_price,
            $request->lead_time
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        DB::update("
            UPDATE supplier_products
            SET supplier_id = ?, product_id = ?, cost_price = ?, lead_time = ?, updated_at = NOW()
            WHERE id = ?
        ", [
            $request->supplier_id,
            $request->product_id,
            $request->cost_price,
            $request->lead_time,
            $id
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        DB::delete("DELETE FROM supplier_products WHERE id = ?", [$id]);

        return redirect()->back();
    }



    // STORE (ADD)
    public function storeSupplier(Request $request)
    {
        DB::insert("
            INSERT INTO suppliers (supplier_name, contact_number, address, created_at, updated_at)
            VALUES (?, ?, ?, NOW(), NOW())
        ", [
            $request->supplier_name,
            $request->contact_number,
            $request->address
        ]);

        return back()->with('success', 'Supplier added successfully');
    }

    // UPDATE
    public function updateSupplier(Request $request)
    {
        DB::update("
            UPDATE suppliers
            SET supplier_name = ?, contact_number = ?, address = ?, updated_at = NOW()
            WHERE id = ?
        ", [
            $request->supplier_name,
            $request->contact_number,
            $request->address,
            $request->id
        ]);

        return back()->with('success', 'Supplier updated successfully');
    }

    // DELETE
    public function deleteSupplier($id)
    {
        DB::delete("
            DELETE FROM suppliers WHERE id = ?
        ", [$id]);

        return back()->with('success', 'Supplier deleted successfully');
    }
}
