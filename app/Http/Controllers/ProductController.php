<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * 📦 List all products with pagination.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = Product::latest()->paginate(15);

        return ProductResource::collection($products);
    }

    /**
     * 🔍 Show a specific product by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json([
                'success' => true,
                'product' => new ProductResource($product),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }
    }

    /**
     * ➕ Store a new product.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        // 🧩 Prepare translatable fields
        $data['title'] = [
            'en' => $data['title_en'],
            'ar' => $data['title_ar'],
        ];
        $data['description'] = [
            'en' => $data['description_en'],
            'ar' => $data['description_ar'],
        ];

        // 🧹 Remove non-database fields
        unset($data['title_en'], $data['title_ar'], $data['description_en'], $data['description_ar']);

        // 💾 Create product
        $product = Product::create($data);

        // 🖼️ Add image if exists
        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('images');
        }

        // ✅ Return response
        return response()->json([
            'message' => 'Product created successfully',
            'product' => new ProductResource($product),
        ], 201);
    }

    /**
     * 🗑️ Delete a product by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);

            // This will trigger the booted deleting() method in the Product model
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 🗑️ Bulk delete products by IDs.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function bulkDelete(\Illuminate\Http\Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No product IDs provided',
            ], 400);
        }

        try {
            $products = Product::whereIn('id', $ids)->get();

            foreach ($products as $product) {
                $product->delete(); // triggers booted() deleting method
            }

            return response()->json([
                'success' => true,
                'message' => count($products) . ' products deleted successfully',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting products: ' . $e->getMessage(),
            ], 500);
        }
    }
}
