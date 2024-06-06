<?php

namespace Database\Seeders;

use App\Models\Gallary;
use App\Models\Product;
use Illuminate\Database\Seeder;

class GallarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        $products->each(function ($product) {
            Gallary::factory(random_int(1, 6))->create(['product_id' => $product->id]);
        });
    }
}
