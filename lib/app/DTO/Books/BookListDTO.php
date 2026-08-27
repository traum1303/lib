<?php declare(strict_types=1);

namespace App\DTO\Books;

use App\Models\Book;

final readonly class BookListDTO
{
    public int $id;
    public string $value;

    public function __construct(
         int $id,
         string $name,
    ) {
        $this->id = $id;
        $this->value = $name;
    }

    public static function fromModel(Book $book): self
    {
        return new self(
            id: $book->id,
            name: $book->name,
        );
    }
}
