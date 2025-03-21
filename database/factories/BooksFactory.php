<?php

namespace Database\Factories;

use App\Models\Authors;
use App\Models\Books;
use App\Models\Category;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BooksFactory extends Factory
{
    // Define the model that the factory is for
    protected $model = Books::class;

    // Define the fake data
    public function definition()
    {
        // Create the Faker instance with 'id_ID' locale for Bahasa Indonesia
        $faker = FakerFactory::create('id_ID');

        $authorIds = Authors::inRandomOrder()->take(rand(1, 3))->pluck('author_id')->toArray();

        return [
            'category_id' => Category::inRandomOrder()->first()->category_id,  // Randomly pick a category
            'author_id' => $authorIds, // Randomly pick an author
            'title' => $faker->sentence(4),  // Generate a random book title in Indonesian
            'content' => $faker->text(),    // Generate random content in Indonesian
        ];
    }
}
