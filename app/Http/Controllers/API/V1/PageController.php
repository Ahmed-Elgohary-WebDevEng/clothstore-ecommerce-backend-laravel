<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;

class PageController extends Controller
{
    public function homePage()
    {
        $featured_products = Product::orderBy('regular_price', 'desc')->limit(6)->get();

        $new_products = Product::orderBy('created_at', 'desc')->limit(6)->get();

        $categories = Category::all();

        // Structuring the response
        return response()->json([
            'featured_products' => ProductResource::collection($featured_products),
            'new_products' => ProductResource::collection($new_products),
            'categories' => CategoryResource::collection($categories)
        ]);
    }


    public function productDetails(Product $product)
    {
        return new ProductResource($product);
    }
}
