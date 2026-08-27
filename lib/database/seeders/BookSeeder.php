<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::query()->inRandomOrder()->limit(5)->get();

        Book::factory(500)->create()->each(function (Book $book) use ($authors) {
            $countAuthors = mt_rand(1,5);
            $book->authors()->saveMany($authors->random($countAuthors));
        });
    }
}
