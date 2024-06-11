<?php

namespace Database\Seeders;

use App\Models\VariantAttributeValue;
use Illuminate\Database\Seeder;

class VariantAttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        VariantAttributeValue::factory(40)->create();
    }
}
