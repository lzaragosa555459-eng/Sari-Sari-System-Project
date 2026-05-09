<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // CREATE PRODUCT
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'expiration_date' => 'nullable|date',
            'initial_stock' => 'nullable|integer|min:0',
        ]);

        // 1. Create product
        $product = Product::create([
            'product_name' => $request->product_name,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'expiration_date' => $request->expiration_date,
        ]);

        // 2. Create inventory (linked automatically)
        Inventory::create([
            'product_id' => $product->id,
            'quantity_on_hand' => $request->initial_stock ?? 0,
            'reorder_level' => 10,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    // UPDATE PRODUCT (MODAL EDIT)
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'expiration_date' => 'nullable|date',
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'product_name' => $request->product_name,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'expiration_date' => $request->expiration_date,
        ]);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    // DELETE PRODUCT
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // OPTIONAL SAFETY: delete inventory first
        Inventory::where('product_id', $product->id)->delete();

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}