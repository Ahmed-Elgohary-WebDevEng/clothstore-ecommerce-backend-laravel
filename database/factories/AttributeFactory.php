<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameArr = ['color', 'size', 'capacity', 'material'];
        $attributeName = $this->faker->randomElement($nameArr);

        $attributeValue = '';

        if ($attributeName === 'color') {
            $attributeValue = $this->faker->hexColor();
        }

        if ($attributeName === 'size') {
            $attributeValue = $this->faker->randomElement(['SM', 'MD', 'LG', 'XL', 'XXL']);
        }

        if ($attributeName === 'capacity') {
            $attributeValue = $this->faker->randomFloat(2, 0, 5).' L';
        }
        if ($attributeName === 'material') {
            $attributeValue = $this->faker->randomElement(['Cotton', 'Metal', 'Plastic']);
        }


        return [
            'attribute_name' => $attributeName,
            'attribute_value' => $attributeValue,
            'color' => $this->faker->hexColor()
        ];
    }
}
