<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAttributeFactory extends Factory
{
    protected $model = ProductAttribute::class;

    public function definition(): array
    {
        $productId = Product::inRandomOrder()->first()->id;
        $attributeId = Attribute::inRandomOrder()->first()->id;
        return [
            'product_id' => $productId,
            'attribute_id' => $attributeId,
        ];
    }
}
