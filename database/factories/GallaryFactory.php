<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallary>
 */
class GallaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'image_path' => $this->faker->imageUrl,
            'thumbnail' => $this->faker->boolean(),
            'display_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
