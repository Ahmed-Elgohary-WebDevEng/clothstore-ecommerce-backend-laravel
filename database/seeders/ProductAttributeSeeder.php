<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    public function run(): void
    {
//        ProductAttribute::factory(10)->create();

        Product::all()->each(function (Product $product) {

            Attribute::all()->each(function (Attribute $attribute) use ($product) {
                ProductAttribute::factory()->create([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                ]);
            });
        });
        
    }
}
