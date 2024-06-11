<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "product_id" => $this->product_id,
            "price" => $this->price,
            "quantity" => $this->quantity,
//            "attribute_values" => $this->attributeValues,
            "attribute_values" => $this->whenLoaded('attributeValues',
                AttributeValueResource::collection($this->attributeValues)),
        ];
    }
}
