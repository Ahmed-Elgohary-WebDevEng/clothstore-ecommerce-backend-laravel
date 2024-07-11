<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Cart */
class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'cart_items_count' => $this->whenLoaded('cartItems', $this->cartItems()->sum('quantity')),

            "cart_items" => $this->whenLoaded('cartItems', CartItemResource::collection($this->cartItems)),
        ];
    }
}
