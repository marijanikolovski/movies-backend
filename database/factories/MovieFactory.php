<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(2, true),
            'description' => $this->faker->text($maxNbChars = 50),
            'cover_image' => $this->faker->imageUrl(800, 600),
            'genre_id' => Genre::inRandomOrder()->first()->id,
        ];
    }
}
