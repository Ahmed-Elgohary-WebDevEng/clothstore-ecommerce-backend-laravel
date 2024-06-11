<?php

namespace Database\Seeders;

use App\Models\VariantAttributeValue;
use Illuminate\Database\Seeder;

class VariantAttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        VariantAttributeValue::factory(40)->create();


//        $variants = Variant::where('product_id', 1)->get();
//        $variants->each(function (Variant $variant) {
//            VariantAttributeValue::factory()->create([
//                'variant_id' => $variant->id,
//            ]);
//        });
//
//
//        AttributeValue::all()->each(function (AttributeValue $attributeValue) {
//            VariantAttributeValue::factory()->create([
//                'attribute_value_id' => $attributeValue->id,
//            ]);
//        });

    }
}
