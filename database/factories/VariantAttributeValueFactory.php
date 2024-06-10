<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use App\Models\Variant;
use App\Models\VariantAttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariantAttributeValueFactory extends Factory
{
    protected $model = VariantAttributeValue::class;

    public function definition(): array
    {
        $variantId = Variant::inRandomOrder()->first()->id;
        $attributeValueId = AttributeValue::inRandomOrder()->first()->id;
        return [
            'attribute_value_id' => $attributeValueId,
            'variant_id' => $variantId,
        ];
    }
}
