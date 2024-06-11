<?php

namespace Tests\Feature;

use App\Http\Resources\CategoryListResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
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

    public function test_get_filtered_products_with_paginate()
    {
        // Arrange: Create some dummy products
        $products = Product::factory(12)->hasImages(4)->create();

        // Act: Make a GET request to the endpoint
        $response = $this->json('GET', route('page.get-filtered-products'));

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
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
                        'images' => [
                            '*' => [
                                'id',
                                'image_path',
                                'thumbnail',
                                'display_order'
                            ]
                        ]
                    ]
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links' => [
                        '*' => [
                            'url',
                            'label',
                            'active'
                        ]
                    ],
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]);
    }

    public function test_product_details_page_it_return_product_by_slug()
    {
        // Create a product
        $product = Product::factory()->hasImages(4)->create();

        // Create related attributes and attribute values
        $attributes = Attribute::factory()->count(4)->create();
        $attributeValues = [];
        foreach ($attributes as $attribute) {
            $values = AttributeValue::factory()->count(3)->create(['attribute_id' => $attribute->id]);
            $attributeValues = array_merge($attributeValues, $values->toArray());
        }

        // Attach attributes to the product
        foreach ($attributes as $attribute) {
            $product->attributes()->attach($attribute->id);
        }

        // Create variants for the product
        $variants = Variant::factory()->count(7)->create(['product_id' => $product->id]);
        foreach ($variants as $variant) {
            $values = collect($attributeValues)->random(3);
            $variant->attributeValues()->attach($values->pluck('id'));
        }

        // Make the request to the productDetails endpoint
        $response = $this->json('GET', route('page.product-details', ['product' => $product->product_slug]));

        // Assert the response status
        $response->assertStatus(200);


        // Assert the structure of the response
        $response->assertJsonStructure([
            'product' => [
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
                'attributes' => [
                    '*' => [
                        'id',
                        'attribute_name',
                        'values' => [
                            '*' => [
                                'id',
                                'attribute_id',
                                'attribute_value',
                            ],
                        ],
                    ],
                ],
            ],
            'product_variants' => [
                '*' => [
                    'id',
                    'product_id',
                    'price',
                    'quantity',
                    'attribute_values' => [
                        '*' => [
                            'id',
                            'attribute_id',
                            'attribute_value',
                            'attribute_name',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
