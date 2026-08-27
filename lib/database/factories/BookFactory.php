<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'publish_year' => $this->faker->numberBetween(1900, (int) date('Y')),
            'isbn' => $this->faker->unique()->isbn13(),
            'total' => $this->faker->numberBetween(0, 100),
        ];
    }
}
