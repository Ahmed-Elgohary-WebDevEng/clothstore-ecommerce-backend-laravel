<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::random(3),
            'description' => $this->faker->text(),
            'icon' => $this->faker->imageUrl,
            'image_path' => $this->faker->imageUrl,
            'active' => $this->faker->boolean(),
        ];
    }
}
