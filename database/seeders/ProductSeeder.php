<?php

namespace Database\Seeders;

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
        $sub_categories = SubCategory::all();

        $sub_categories->each(function (SubCategory $sub_category) {
            Product::factory(10)->create(['category_id' => $sub_category->id]);
        });
    }
}
