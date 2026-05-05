<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = collect($cart)->sum('subtotal');

        return view('customer.cart', compact('cart', 'total'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        $product = DB::table('products')
            ->where('id', $request->product_id)
            ->first();

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        $id = $product->id;

        // GROUPING LOGIC (key part)
        if (!isset($cart[$id])) {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 0,
                'subtotal' => 0
            ];
        }

        $cart[$id]['quantity'] += $request->quantity;
        $cart[$id]['subtotal'] = $cart[$id]['price'] * $cart[$id]['quantity'];

        session()->put('cart', $cart);

        return back()->with('success', 'Added to cart!');
    }


    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Cart is empty.');
        }

        $customerId = auth()->id();

        foreach ($cart as $item) {
            DB::table('bookings')->insert([
                'customer_id' => $customerId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // clear cart after saving
        session()->forget('cart');

        return redirect()->route('order')->with('success', 'Booking placed successfully!');
    }
    public function clear(Request $request)
        {
            // Remove the cart and total from the session
            $request->session()->forget('cart');
            $request->session()->forget('total');

            // Optional: If you use a specific session key like 'shopping_cart'
            // session()->forget('shopping_cart');

            return redirect()->route('order')->with('success', 'Order has been cancelled and cart is cleared.');
        }
}