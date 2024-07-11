<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carts = Cart::all();


        $carts->each(function (Cart $cart) {

            CartItem::factory()->count(10)->create([
                'cart_id' => $cart->id,
            ]);
        });
    }
}
