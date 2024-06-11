<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantAttributeValue;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    public function run(): void
    {
        Variant::factory(4)->create([
            'product_id' => 1
        ]);

        AttributeValue::all()->each(function (AttributeValue $attributeValue) {
            VariantAttributeValue::factory()->create([
                'attribute_value_id' => $attributeValue->id
            ]);
        });

        Product::all()->each(function (Product $product) {
            Variant::factory()->count(3)->create(['product_id' => $product->id]);
        });
    }
}
