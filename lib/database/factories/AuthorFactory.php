<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var Gender $gender */
        $gender = $this->faker->randomElement(Gender::cases());
        $genderToLower = mb_strtolower($gender->name);

        return [
            'first_name' => $this->faker->firstName($genderToLower),
            'second_name' => $this->faker->lastName($genderToLower),
            'gender' => $gender
        ];
    }
}
