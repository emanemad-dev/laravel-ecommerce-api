<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 🧾 Create an order from the user's cart.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // ✅ Get the user's cart with all items and related products
        $cart = $user->cart()->with('items.product')->first();

        // ❌ Return error if cart is empty
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // 🔍 Check stock for each product before creating the order
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->quantity) {
                return response()->json([
                    'message' => "Not enough stock for product {$item->product->title_en}"
                ], 400);
            }
        }

        // 🧮 Calculate total price of the order
        $total = $cart->items->sum(fn($item) => $item->unit_price * $item->quantity);

        // 📝 Create the order in the database
        $order = $user->orders()->create([
            'total_price' => $total
        ]);

        // 🔄 Copy cart items to order_items and update product stock
        foreach ($cart->items as $item) {
            // ➡️ Add each cart item to the order
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->unit_price,
            ]);

            // ⬇️ Deduct the purchased quantity from product stock
            $product = $item->product;
            $product->quantity -= $item->quantity;
            $product->save();
        }

        // 🗑️ Clear the cart items after creating the order
        $cart->items()->delete();

        // ✅ Return a JSON response with order details
        return response()->json([
            'message' => 'Order created successfully',
            'order_id' => $order->id,
            'total' => $order->total_price,
        ], 201);
    }

    /**
     * 📦 List all orders of the authenticated user.
     */
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->get();

        return response()->json($orders);
    }

    /**
     * 🔍 Show details of a specific order.
     */
    public function show(Request $request, $id)
    {
        $order = $request->user()
            ->orders()
            ->with('items.product')
            ->findOrFail($id);

        return response()->json($order);
    }
}
