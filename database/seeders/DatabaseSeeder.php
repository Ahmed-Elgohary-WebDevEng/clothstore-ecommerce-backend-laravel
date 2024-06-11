<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UserAddressSeeder::class,
            CartSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            GallarySeeder::class,
            AttributeSeeder::class,
            ProductAttributeSeeder::class,
            AttributeValueSeeder::class,
            VariantSeeder::class,
            VariantAttributeValueSeeder::class
        ]);

    }
}
