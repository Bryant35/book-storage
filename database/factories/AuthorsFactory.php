<?php

namespace Database\Factories;

use App\Models\Authors;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorsFactory extends Factory
{
    // Define the model that the factory is for
    protected $model = Authors::class;

    // Define the fake data
    public function definition()
    {
        $faker = FakerFactory::create('id_ID');

        return [
            'name' => $faker->name(),  // Random author name, e.g., "John Doe"
        ];
    }
}
