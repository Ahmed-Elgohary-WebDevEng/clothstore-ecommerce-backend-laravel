<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // generate factory for product
        Attribute::factory(3)->has(Product::factory()->count(2))->create();

        // generate factory for variant
        Attribute::factory(3)->has(Variant::factory()->count(2))->create();

        // generate fake data for product_attributes table
        $products = Product::all();

        $products->each(function (Product $product) {
            $product->attributes()->createMany(Attribute::factory()->count(3)->make()->toArray());
        });


    }
}
