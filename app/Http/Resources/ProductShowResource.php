<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'product_slug' => $this->product_slug,
            'SKU' => $this->SKU,
            'regular_price' => $this->regular_price,
            'discount_price' => $this->discount_price,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'product_weight' => $this->product_weight,
            'product_note' => $this->product_note,
            'published' => $this->published,
            'images' => GallaryResource::collection($this->images)
        ];
    }
}
