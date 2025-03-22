<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {

        // Create Admin Role
        $user = User::create([
            "name"=> "Admin",
            "username"=> "admin",
            "password"=> bcrypt("admin"),
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
        $user->assignRole('Admin');

        // Create 10 fake users using the UserFactory
        User::factory(10)->create()->each(function ($user) {
            // Role Array (Admin tidak masuk karena admin cuma 1)
            $roles = ['Editor', 'Reader'];

            // Random pilih role
            $randomRole = $roles[array_rand($roles)];

            // Assign role to user
            $user->assignRole($randomRole);
        });

    }
}
