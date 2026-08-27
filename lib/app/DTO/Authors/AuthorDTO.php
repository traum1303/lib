<?php declare(strict_types=1);

namespace App\DTO\Authors;

use App\Enums\Gender;

final readonly class AuthorDTO
{
    public function __construct(
        public string $firstName,
        public string $secondName,
        public Gender $gender,
        public array $bookIds,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            secondName: $data['second_name'],
            gender: Gender::tryFrom((int)$data['gender']),
            bookIds: array_map('intval', $data['searched_ids'] ?? []),
        );
    }
}
