<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        $products->each(function (Product $product) {
            Variant::factory(2)->create(['product_id' => $product->id]);
        });
        
        Variant::factory(3)->has(Attribute::factory()->count(2))->create();

    }
}
