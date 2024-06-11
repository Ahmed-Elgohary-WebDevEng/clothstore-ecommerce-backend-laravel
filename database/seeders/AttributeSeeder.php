<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = ['color', 'size', 'capacity', 'material'];

        foreach ($attributes as $attribute) {

            Attribute::factory()->create([
                'attribute_name' => $attribute,
            ]);
        }

    }
}
