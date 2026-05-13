<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
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

        $product = DB::selectOne("
            SELECT 
                p.*,
                i.quantity_on_hand
            FROM products p
            JOIN inventory i
                ON p.id = i.product_id
            WHERE p.id = ?
        ", [$request->product_id]);

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        // CHECK STOCK
        if ($request->quantity > $product->quantity_on_hand) {
            return back()->with('error', 'Not enough stock available.');
        }

        $id = $product->id;

        // GROUPING LOGIC
        if (!isset($cart[$id])) {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 0,
                'subtotal' => 0
            ];
        }

        // ADD TO CART
        $cart[$id]['quantity'] += $request->quantity;

        // UPDATE SUBTOTAL
        $cart[$id]['subtotal'] =
            $cart[$id]['price'] * $cart[$id]['quantity'];

        // SAVE SESSION
        session()->put('cart', $cart);

        // MINUS STOCK
        DB::update("
            UPDATE inventory
            SET quantity_on_hand = quantity_on_hand - ?
            WHERE product_id = ?
        ", [
            $request->quantity,
            $product->id
        ]);

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
        // Get cart items from session
        $cart = session('cart', []);

        // Restore quantities to the inventory table
        foreach ($cart as $productId => $item) {
            // Find the inventory record for this product
            $inventory = Inventory::where('product_id', $productId)->first();

            if ($inventory) {
                // Add the reserved quantity back to quantity_on_hand
                $inventory->quantity_on_hand += $item['quantity'];
                $inventory->save();
            }
        }

        // Remove cart data from session
        $request->session()->forget('cart');
        $request->session()->forget('total');

        return redirect()
            ->route('order')
            ->with('success', 'Order has been cancelled and inventory has been restored.');
    }
}