<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Authors;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        // Create 10 authors with fake data
        Authors::factory(30)->create();
    }
}
