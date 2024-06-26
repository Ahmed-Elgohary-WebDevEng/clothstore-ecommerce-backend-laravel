<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductShowResource;
use App\Http\Resources\VariantProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use App\Traits\HttpResponses;

class PageController extends Controller
{
    use HttpResponses;

    public function homePage()
    {
        $featured_products = Product::orderBy('regular_price', 'desc')->limit(6)->get();

        $new_products = Product::orderBy('created_at', 'desc')->limit(6)->get();

        $categories = Category::all();

        // Structuring the response
        return response()->json([
            'featured_products' => ProductResource::collection($featured_products),
            'new_products' => ProductResource::collection($new_products),
            'categories' => CategoryListResource::collection($categories)
        ]);
    }


    public function productDetails(Product $product)
    {
        // Eager load attributes and variants along with the product
        // get the product attributes
        $product = $product->load(['attributes.attributeValues']);

        $productVariants = Variant::where('product_id', $product->id)->with('attributeValues.attribute')->get();

        return response()->json([
            'product' => new ProductShowResource($product),
            'product_variants' => VariantProductResource::collection($productVariants)
        ], 200);
    }


}
