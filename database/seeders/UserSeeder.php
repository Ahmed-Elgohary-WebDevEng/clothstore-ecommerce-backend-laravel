<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // main account
        User::factory()->create([
            'first_name' => 'Ahmed',
            'last_name' => "Elgohary",
            'email' => 'test@example.com',
            'phone_number' => '01226538221',
            "password" => "password"
        ]);
        // fake user data
        User::factory(5)->create();

    }
}
