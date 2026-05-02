<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PosController extends Controller
{
    // 📦 Load POS page (products + cart)
    public function index()
    {
        $products = DB::select("
            SELECT p.*, i.quantity_on_hand
            FROM products p
            LEFT JOIN inventory i ON i.product_id = p.id
        ");

        $cart = Session::get('cart', []);

        return view('employee.pos', compact('products', 'cart'));
    }

    // ➕ Add to cart
    public function addToCart(Request $request)
    {
        $product = DB::selectOne("
            SELECT * FROM products WHERE id = ?
        ", [$request->product_id]);

        if (!$product) {
            return back();
        }

        $cart = Session::get('cart', []);

        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return back();
    }

    // ➖ Remove item
    public function removeItem($id)
    {
        $cart = Session::get('cart', []);

        unset($cart[$id]);

        Session::put('cart', $cart);

        return back();
    }

    // 🧾 Checkout / Save Sale
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return back();
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 1. Insert Sale
        DB::insert("
            INSERT INTO sales (customer_id, employee_id, sale_date, total_amount, amount_paid, `change`, payment_method, created_at, updated_at)
            VALUES (?, ?, CURDATE(), ?, ?, ?, ?, NOW(), NOW())
        ", [
            $request->customer_id ?? 1,
            auth()->id(),
            $total,
            $request->amount_paid ?? $total,
            ($request->amount_paid ?? $total) - $total,
            $request->payment_method,
        ]);

        $saleId = DB::getPdo()->lastInsertId();

        // 2. Insert Sale Details + Deduct Inventory
        foreach ($cart as $item) {

            DB::insert("
                INSERT INTO sale_details (sale_id, product_id, quantity, created_at, updated_at)
                VALUES (?, ?, ?, NOW(), NOW())
            ", [
                $saleId,
                $item['id'],
                $item['quantity'],
            ]);

            // deduct inventory
            DB::update("
                UPDATE inventory
                SET quantity_on_hand = quantity_on_hand - ?
                WHERE product_id = ?
            ", [
                $item['quantity'],
                $item['id']
            ]);
        }

        // 3. Clear cart
        Session::forget('cart');

        return redirect()->back()->with('success', 'Sale completed!');
    }

    // 🧹 Clear cart
    public function clearCart()
    {
        Session::forget('cart');
        return back();
    }
}