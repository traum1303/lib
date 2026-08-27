<?php declare(strict_types=1);

namespace App\DTO\Authors;

use App\DTO\Books\BookListDTO;
use App\Enums\Gender;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Collection;

final readonly class AuthorIndexDTO
{
    public int $id;
    public string $firstName;
    public string $secondName;
    public string $fullName;
    public Collection $books;
    public Gender $gender;
    public string $pic;

    public function __construct(
        int $id,
        string $firstName,
        string $secondName,
        Collection $books,
        string $pic,
        Gender $gender
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->secondName = $secondName;
        $this->fullName = "$this->firstName $this->secondName";
        $this->books = $books;
        $this->pic = $pic;
        $this->gender = $gender;
    }

    public static function fromModel(Author $author): self
    {
        return new self(
            id: $author->id,
            firstName: $author->first_name,
            secondName: $author->second_name,
            books: $author->books->map(fn (Book $book) => BookListDTO::fromModel($book)),
            pic: $author->pic,
            gender: $author->gender
        );
    }
}
