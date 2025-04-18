<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the individual seeders
        $this->call([
            CategorySeeder::class,
            AuthorSeeder::class,
            BookSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
