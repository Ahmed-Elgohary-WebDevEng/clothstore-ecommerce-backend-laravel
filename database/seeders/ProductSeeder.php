<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->create([
            'product_name' => 'product 1',
            'product_slug' => 'product-1-slug',
            'category_id' => Category::all()->random()->id,
        ]);
        $sub_categories = SubCategory::all();

        $sub_categories->each(function (SubCategory $sub_category) {
            Product::factory(10)->create(['category_id' => $sub_category->id]);
        });
    }
}
