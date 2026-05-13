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
        $cart = Session::get('cart', []);

        $products = DB::table('products')
            ->join('inventory', 'products.id', '=', 'inventory.product_id')
            ->select('products.*', 'inventory.quantity_on_hand')
            ->get()
            ->map(function ($product) use ($cart) {

                $cartQty = isset($cart[$product->id])
                    ? $cart[$product->id]['quantity']
                    : 0;

                $product->available_stock = $product->quantity_on_hand - $cartQty;

                return $product;
            })
            ->filter(function ($product) {
                return $product->available_stock > 0;
            })
            ->values();

        $customers = DB::select("
            SELECT u.id as user_id, u.name FROM users u
            JOIN customers c ON u.id = c.user_id
        ");

        return view('employee.pos', [
            'products' => $products,
            'cart' => $cart,
            'customers' => $customers
        ]);
    }

    // ➕ Add to cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = DB::selectOne("
            SELECT p.*, i.quantity_on_hand
            FROM products p
            JOIN inventory i ON p.id = i.product_id
            WHERE p.id = ?
        ", [$request->product_id]);

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        $qty = (int) $request->quantity;

        if ($qty > $product->quantity_on_hand) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = Session::get('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {

            $newQty = $cart[$id]['quantity'] + $qty;

            if ($newQty > $product->quantity_on_hand) {
                return back()->with('error', 'Quantity exceeds available stock.');
            }

            $cart[$id]['quantity'] = $newQty;

        } else {

            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->product_name,
                'price'    => $product->price,
                'quantity' => $qty,
            ];
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Added to cart.');
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
            return back()->with('error', 'Cart is empty.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $paymentMethod = $request->payment_method;
        $isCredit = $paymentMethod === 'credit';

        $amountPaid = 0;
        $change = 0;

        // CASH ONLY VALIDATION
        if ($paymentMethod === 'cash') {

            $amountPaid = $request->amount_paid ?? 0;

            if ($amountPaid < $total) {
                return back()->with('error', 'Insufficient payment.');
            }

            $change = $amountPaid - $total;
        }

        // 1. CREATE SALE (NO SIDE EFFECTS YET)
        DB::insert("
            INSERT INTO sales (
                customer_id, employee_id, sale_date,
                total_amount, amount_paid, `change`,
                payment_method, created_at, updated_at
            )
            VALUES (?, ?, CURDATE(), ?, ?, ?, ?, NOW(), NOW())
        ", [
            $request->customer_id ?? null,
            auth()->id(),
            $total,
            $amountPaid,
            $change,
            $paymentMethod,
        ]);

        $saleId = DB::getPdo()->lastInsertId();

        // 2. SALE DETAILS + INVENTORY
        foreach ($cart as $item) {

            DB::insert("
                INSERT INTO sale_details (sale_id, product_id, quantity, created_at, updated_at)
                VALUES (?, ?, ?, NOW(), NOW())
            ", [
                $saleId,
                $item['id'],
                $item['quantity'],
            ]);

            DB::update("
                UPDATE inventory
                SET quantity_on_hand = quantity_on_hand - ?
                WHERE product_id = ?
            ", [
                $item['quantity'],
                $item['id']
            ]);
        }

        // 3. CASH UPDATE ONLY IF CASH
        if ($paymentMethod === 'cash') {

            $cash = DB::selectOne("SELECT * FROM store_cash LIMIT 1");

            DB::update("
                UPDATE store_cash
                SET current_balance = current_balance + ?,
                    total_income = total_income + ?,
                    updated_at = NOW()
                WHERE id = ?
            ", [
                $total,
                $total,
                $cash->id
            ]);

            // receipt
            Session::forget('cart');

            Session::put('receipt', [
                'items' => $cart,
                'subtotal' => $total,
                'total' => $total,
                'paid' => $amountPaid,
                'change' => $change,
            ]);

            return back()->with('showReceipt', true);
        }

        // 4. CREDIT FLOW (NO CASH UPDATE!)
        if ($isCredit) {

            Session::put('credit_checkout', [
                'sale_id' => $saleId,
                'total' => $total,
                'cart' => $cart
            ]);

            Session::forget('cart');

            return redirect()
                ->route('pos')
                ->with('openCreditModal', true);
        }
    }

    // 🧹 Clear cart
    public function clearCart()
    {
        Session::forget('cart');
        return back();
    }

}