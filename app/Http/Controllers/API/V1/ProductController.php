<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $featured_products = Product::orderBy('regular_price', 'desc')
            ->limit(6)->get();


        $new_products = Product::orderBy('created_at', 'desc')->limit(6)->get();

        // Structuring the response
        return response()->json([
            'featured_products' => ProductResource::collection($featured_products),
            'new_products' => ProductResource::collection($new_products),
        ]);
    }


    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
