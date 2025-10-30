<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * 🛒 Add products to the user's cart
     */
    public function add(StoreCartRequest $request): JsonResponse
    {
        $user = $request->user();

        // ✅ Get the user's cart or create a new one
        $cart = $user->cart()->firstOrCreate([]);

        // 🔍 Extract product IDs from request
        $productIds = collect($request->items)->pluck('product_id');

        // 🧩 Get all products in one query for performance
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($request->items as $item) {
            $product = $products[$item['product_id']];

            // 🔹 Determine quantity to add (default to 1 if not provided)
            $qty = isset($item['quantity']) && $item['quantity'] > 0 ? $item['quantity'] : 1;

            // 🔹 Get current cart item if exists
            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            // 🔹 Calculate new quantity without exceeding stock
            $newQuantity = $cartItem ? $cartItem->quantity + $qty : $qty;
            if ($newQuantity > $product->quantity) {
                return response()->json([
                    'message' => "Cannot add more than available stock for {$product->title_en}"
                ], 400);
            }

            // 🔄 Add or update the cart item
            $cart->items()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'quantity' => $newQuantity,
                    'unit_price' => $product->price,
                ]
            );
        }

        // 🔄 Reload cart items with product relations
        $cart->load('items.product');

        // ✅ Return updated cart
        return response()->json([
            'message' => 'Items added to cart successfully',
            'cart' => new CartResource($cart),
        ], 200);
    }

    /**
     * 👁️ View cart contents
     */
    public function view(Request $request): CartResource
    {
        $cart = $request->user()->cart()->with('items.product')->firstOrCreate([]);
        return new CartResource($cart);
    }

    /**
     * ❌ Remove specific product from cart
     */
    public function remove(Request $request, int $productId): JsonResponse
    {
        $cart = $request->user()->cart;

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $deleted = $cart->items()->where('product_id', $productId)->delete();

        return response()->json([
            'message' => $deleted ? 'Item removed successfully' : 'Item not found',
            'cart' => new CartResource($cart->load('items.product')),
        ]);
    }
}
