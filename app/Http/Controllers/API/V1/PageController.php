<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductShowResource;
use App\Http\Resources\SubCategoryListResource;
use App\Http\Resources\VariantProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Variant;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

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
            'categories' => CategoryResource::collection($categories)
        ]);
    }

    public function getFilteredProducts(Request $request)
    {
        try {
            // get all categories
            $categories = Category::all();
            $subcategories = Subcategory::select(['id', 'name', 'slug'])->get();

            // Todo ==> Filtering products
            $products = Product::filter(request([
                'category', 'sub_category', 'min', 'max', 'sort'
            ]))->paginate(12)->withQueryString();

            return response()->json([
                'categories' => CategoryListResource::collection($categories),
                'sub_categories' => SubCategoryListResource::collection($subcategories),
                'filtered_products' => [
                    'data' => ProductResource::collection($products),
                    'pagination' => [
                        'total' => $products->total(),
                        'per_page' => $products->perPage(),
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'from' => $products->firstItem(),
                        'to' => $products->lastItem(),
                        "prev_page_url" => $products->previousPageUrl(),
                        "next_page_url" => $products->nextPageUrl(),
                    ],
                ],

            ], 200);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 500, 'Something went wrong');
        }
    }


    public function productDetails(Product $product)
    {
        // Eager load attributes and variants along with the product
        // get the product attributes
        $product = $product->load(['attributes.attributeValues.variants']);

        $productVariants = Variant::where('product_id', $product->id)->with('attributeValues.attribute')->get();

        return response()->json([
            'product' => new ProductShowResource($product),
            'product_variants' => VariantProductResource::collection($productVariants)
        ], 200);
    }


}
