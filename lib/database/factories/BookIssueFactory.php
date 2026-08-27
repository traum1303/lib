<?php

namespace Database\Factories;

use App\Enums\BookIssueStatus;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookIssue>
 */
class BookIssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::query()->inRandomOrder()->first()->id,
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(BookIssueStatus::cases()),
            'created_at' => $this->faker->date(),
            'return_to' => $this->faker->date(),
        ];
    }
}
