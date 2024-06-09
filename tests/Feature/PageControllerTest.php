<?php

namespace Tests\Feature;

use App\Http\Resources\CategoryListResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Gallary;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_home_page_it_returns_featured_and_new_products_and_categories(): void
    {
        // Mock the Product model
        Product::factory(12)->hasImages(4)->create();
        Category::factory(5)->create();


        // Act: call the index route
        $response = $this->getJson(route('page.home-page'));

        // Assert: check the structure and data of the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'featured_products' => [
                    '*' => [
                        'id',
                        'product_name',
                        'product_slug',
                        'SKU',
                        'regular_price',
                        'discount_price',
                        'quantity',
                        'description',
                        'product_weight',
                        'product_note',
                        'published',
                        'images'
                    ]
                ],
                'new_products' => [
                    '*' => [
                        'id',
                        'product_name',
                        'product_slug',
                        'SKU',
                        'regular_price',
                        'discount_price',
                        'quantity',
                        'description',
                        'product_weight',
                        'product_note',
                        'published',
                        'images'
                    ]
                ],
                'categories' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                        'image_path',
                    ]
                ]
            ]);

        // Get the products sorted by regular_price descending
        $featuredProducts = Product::orderBy('regular_price', 'desc')->limit(6)->get();
        // Get the products sorted by created_at descending
        $newProducts = Product::orderBy('created_at', 'desc')->limit(6)->get();
        $categories = Category::all();

        // Convert to resources
        $featuredProductsResource = ProductResource::collection($featuredProducts)->response()->getData(true);
        $newProductsResource = ProductResource::collection($newProducts)->response()->getData(true);
        $categoriesResource = CategoryListResource::collection($categories)->response()->getData(true);

        $response->assertJson([
            'featured_products' => $featuredProductsResource['data'],
            'new_products' => $newProductsResource['data'],
            'categories' => $categoriesResource['data']
        ]);
    }


    public function test_product_details_page_it_return_product_by_slug()
    {
        // Arrange: create a product
        $product = Product::factory()->create();

        // Add images to the product
        $images = Gallary::factory()->count(3)->create([
            'product_id' => $product->id,
        ]);
        // Act: call the show route
        $response = $this->getJson(route('page.product-details', $product->product_slug));

        // Assert the response status
        $response->assertStatus(200);

        // Assert the response structure
        $response->assertJsonStructure([
            'data' => [
                'id',
                'product_name',
                'product_slug',
                'SKU',
                'regular_price',
                'discount_price',
                'quantity',
                'description',
                'product_weight',
                'product_note',
                'published',
                'images' => [
                    '*' => [
                        'id',
                        'image_path',
                        'thumbnail',
                        'display_order',
                    ],
                ],
            ],
        ]);
    }
}
