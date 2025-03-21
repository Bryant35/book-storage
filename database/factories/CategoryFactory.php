<?php

namespace Database\Factories;

use App\Models\Category;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    // Define the model that the factory is for
    protected $model = Category::class;

    // Define the fake data
    public function definition()
    {
        $faker = FakerFactory::create('id_ID');

        return [
            'name' => $faker->word(),  // Random category name, e.g., "Technology"
        ];
    }
}
