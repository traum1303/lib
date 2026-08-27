<?php declare(strict_types=1);

namespace App\DTO\Authors;

use App\Models\Author;

final readonly class AuthorSearchDTO
{
    public int $id;
    public string $firstName;
    public string $secondName;
    public string $searchValue;
    public array $hiddenValues;

    public function __construct(
         int $id,
         string $firstName,
         string $secondName,
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->secondName = $secondName;
        $this->searchValue = "$this->firstName $this->secondName";
        $this->hiddenValues = [];
    }

    public static function fromModel(Author $author): self
    {
        return new self(
            id: $author->id,
            firstName: $author->first_name,
            secondName: $author->second_name,
        );
    }
}
