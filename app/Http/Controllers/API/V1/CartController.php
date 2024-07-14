<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $user_cart = auth()->user()->cart;

        if (!$user_cart) {
            $user_cart = Cart::create([
                'user_id' => auth()->user()->id,
            ]);
        }

        $cartItems = auth()->user()->cart()->with('cartItems.product')->get();

        return $this->success(CartResource::collection($cartItems));
    }

    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer'
        ]);

        try {
            // get the user cart
            $cart = auth()->user()->cart;

            // check if the product is in cart items
            $cart_item = CartItem::where('product_id', $request->input('product_id'))
                ->where('cart_id', $cart->id)
                ->first();

            if ($cart_item) {
                $cart_item->update([
                    'quantity' => $cart_item->quantity + $request->input('quantity')
                ]);

                return $this->success(null, 'Cart item quantity updated', 200);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $request->input('product_id'),
                    'quantity' => $request->input('quantity')
                ]);
                return $this->success(null, 'Cart item added successfully', 200);
            }
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 500);
        }

    }


    public function update(CartItem $item, Request $request)
    {
        $request->validate(['quantity' => 'required|integer']);

        try {
            $item->update([
                'quantity' => $request->input('quantity')
            ]);

            return $this->success(null, "Product quantity updated successfully", 200);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 500);
        }
    }

    public function destroy(CartItem $item)
    {
        $item->delete();
        return $this->success(null, "Product item deleted successfully", 204);
    }

    public function clear()
    {
        $user_cart = auth()->user()->cart;

        $user_cart->cartItems()->delete();

        return $this->success(null, "Cart cleared successfully", 204);
    }
}
