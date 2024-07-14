<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_cart_items_with_products()
    {
        // create user factory
        $user = User::factory()->create();
        // mock authentication
        $this->actingAs($user);
        // create cart for the user
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        // create product factory
        $products = Product::factory(3)->create();
        // Create cart items and associate them with the cart
        $cartItems = $products->map(function ($product) use ($cart) {
            return CartItem::factory()->create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 10),
            ]);
        });


        // send a get request
        $response = $this->getJson(route('cart.items.index'));

        // Asser the response
        $response->assertStatus(200);

        $response->assertJsonStructure([
            "status",
            "message",
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'cart_items_count',
                    'cart_items' => [
                        '*' => [
                            'id',
                            'quantity',
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
                                    ]
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }


    /**
     * test store function
     * @return void
     */
    public function test_store_method_updates_quantity_if_cart_item_exists()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a product
        $product = Product::factory()->create();

        // create a cart
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        // Create a cart item for the user
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1, // Initial quantity
        ]);

        // Simulate a request to update the cart item
        $response = $this->actingAs($user)
            ->postJson(route('cart.items.store'), [
                'product_id' => $product->id,
                'quantity' => 3, // New quantity to update
            ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Request was successful',
                'message' => 'Cart item quantity updated',
                'data' => null,
            ]);

        // Assert that the cart item quantity was updated
        $this->assertEquals(4, $cartItem->fresh()->quantity); // Expected new quantity
    }

    public function test_store_method_adds_new_cart_item_if_not_exists()
    {
        // Create a user
        $user = User::factory()->create();

        // create a cart
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        // Create a product
        $product = Product::factory()->create();

        // Simulate a request to add a new cart item
        $response = $this->actingAs($user)
            ->postJson(route('cart.items.store'), [
                'product_id' => $product->id,
                'quantity' => 2, // Quantity to add
            ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Request was successful',
                'message' => 'Cart item added successfully',
                'data' => null,
            ]);

        // Assert that a new cart item was created
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $user->cart->id,
            'product_id' => $product->id,
            'quantity' => 2, // Expected quantity
        ]);
    }


    public function test_update_method_updates_cart_item_quantity()
    {
        // Create a user
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        // Create a cart item for the user
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1, // Initial quantity
        ]);

        // Simulate a request to update the cart item
        $response = $this->actingAs($user)
            ->putJson(route('cart.items.update', $cartItem->id), [
                'quantity' => 3, // New quantity to update
            ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Request was successful',
                'message' => 'Product quantity updated successfully',
                'data' => null,
            ]);

        // Assert that the cart item quantity was updated
        $this->assertEquals(3, $cartItem->fresh()->quantity); // Expected new quantity
    }

    public function test_update_method_fails_validation_if_quantity_is_missing()
    {
        // Create a user
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        $product = Product::factory()->create();

        // Create a cart item for the user
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1, // Initial quantity
        ]);

        // Simulate a request with missing quantity
        $response = $this->actingAs($user)
            ->putJson(route('cart.items.update', $cartItem->id), []);

        // Assert the response
        $response->assertStatus(422); // Validation error expected
    }

    /**
     * Remove item from cart test
     * @return void
     */
    public function test_destroy_method_deletes_cart_items()
    {
        // create user
        $user = User::factory()->create();
        // create cart for this user
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        // create a product
        $product = Product::factory()->create();
        // create cart item for the user
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 4
        ]);

        // acting as auth user and send the request to delete
        $response = $this
            ->actingAs($user)
            ->deleteJson(route('cart.items.destroy', $cartItem->id));

        // check the returned json
        $response
            ->assertStatus(204);

        // 6- check if it is deleted from database
        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id,
        ]);
    }

    public function test_clear_method_clears_user_cart()
    {
        // create user
        $user = User::factory()->create();
        // create cart for this user
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        // create a product
        $product = Product::factory()->create();
        // create cart item for the user
        $cartItem = CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 4
        ]);

        // simulate to request to clear the cart
        $response = $this
            ->actingAs($user)
            ->deleteJson(route('cart.items.clear'));

        $response
            ->assertStatus(204);

        // Assert that all cart items were deleted
        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $user->cart->id,
        ]);
    }

}
