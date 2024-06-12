<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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
            "attribute_name" => $this->attribute_name,
            "values" => $this->whenLoaded('attributeValues', function () {
                return $this->attributeValues()->pluck('attribute_value');
            }),
        ];
    }
}
