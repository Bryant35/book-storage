<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Books;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Create 50 books with fake data
        Books::factory(100)->create();
    }
}
