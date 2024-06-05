<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();
        $product_price = $this->faker->randomFloat(2, 10, 100);
        return [
            'product_name' => $name,
            'product_slug' => Str::slug($name),
            'SKU' => strtoupper($this->faker->regexify('[A-Z]{3}-[0-9]{5}')),
            'regular_price' => $product_price,
            'discount_price' => $product_price * (1 - 0.05),
            'quantity' => $this->faker->numberBetween(1, 30),
            'description' => $this->faker->text(),
            'product_weight' => $this->faker->randomFloat(2, 10, 100),
            'product_note' => $this->faker->text(),
            'published' => $this->faker->boolean(),
        ];
    }
}
