<?php declare(strict_types=1);

namespace App\DTO\Books;

use App\Models\Book;

final readonly class BookSearchDTO
{
    public int $id;
    public string $name;
    public string $isbn;
    public string $searchValue;
    public array $hiddenValues;

    public function __construct(
         int $id,
         string $name,
         string $isbn,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->isbn = $isbn;
        $this->searchValue = "$this->name ($this->isbn)";
        $this->hiddenValues = [
            'book_name' => $this->name,
            'book_isbn' => $this->isbn,
        ];
    }

    public static function fromModel(Book $book): self
    {
        return new self(
            id: $book->id,
            name: $book->name,
            isbn: $book->isbn,
        );
    }
}
