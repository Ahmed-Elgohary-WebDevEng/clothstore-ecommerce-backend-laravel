<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        Attribute::all()->each(function (Attribute $attribute) {

            $name = $attribute->attribute_name;

            $colors = ['#ffff66', '#1245ff', '#we3423', '#12qw34'];
            $sizes = ['small', 'medium', 'large'];
            $capacities = ['500ml', '1500ml', '1.5L'];
            $materials = ['cotton', 'plastic', 'metal'];

            if ($name === 'size') {
                foreach ($sizes as $item) {

                    AttributeValue::factory()->create([
                        'attribute_id' => $attribute->id,
                        'attribute_value' => $item
                    ]);
                }
            }

            if ($name === 'color') {
                foreach ($colors as $item) {

                    AttributeValue::factory()->create([
                        'attribute_id' => $attribute->id,
                        'attribute_value' => $item
                    ]);
                }
            }
            if ($name === 'capacity') {
                foreach ($capacities as $item) {

                    AttributeValue::factory()->create([
                        'attribute_id' => $attribute->id,
                        'attribute_value' => $item
                    ]);
                }
            }
            if ($name === 'material') {
                foreach ($materials as $item) {

                    AttributeValue::factory()->create([
                        'attribute_id' => $attribute->id,
                        'attribute_value' => $item
                    ]);
                }
            }


        });
    }
}
