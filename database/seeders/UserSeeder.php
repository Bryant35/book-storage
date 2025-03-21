<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create 10 fake users using the UserFactory
        User::factory(10)->create();
    }
}
