<?php

namespace Tests\Feature;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_it_returns_featured_and_new_products(): void
    {
        // Mock the Product model
        $products = Product::factory()->count(12)->make();

        // Act: call the index route
        $response = $this->getJson(route('products.index'));

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
            ]);

        // Get the products sorted by regular_price descending
        $featuredProducts = Product::orderBy('regular_price', 'desc')->limit(6)->get();
        // Get the products sorted by created_at descending
        $newProducts = Product::orderBy('created_at', 'desc')->limit(6)->get();

        // Convert to resources
        $featuredProductsResource = ProductResource::collection($featuredProducts)->response()->getData(true);
        $newProductsResource = ProductResource::collection($newProducts)->response()->getData(true);

        $response->assertJson([
            'featured_products' => $featuredProductsResource['data'],
            'new_products' => $newProductsResource['data'],
        ]);
    }


    public function test_it_return_product_by_slug()
    {
        // Arrange: create a product
        $product = Product::factory()->create();

        // Act: call the show route
        $response = $this->getJson(route('products.show', $product->product_slug));

        // Assert: check the status and structure of the response
        $response->assertStatus(200)
            ->assertJsonStructure([
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
                    'images'
                ]
            ]);

        // Convert the product to a resource
        $productResource = (new ProductResource($product))->response()->getData(true);

        // Assert the product data
        $response->assertJson([
            'data' => $productResource['data'],
        ]);
    }
}
