<?php declare(strict_types=1);

namespace App\DTO\Books;

final readonly class BookDTO
{
    public function __construct(
        public string $name,
        public int $publishYear,
        public string $isbn,
        public int $total,
        public array $authorIds,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            publishYear: (int) $data['publish_year'],
            isbn: $data['isbn'],
            total: (int) $data['total'],
            authorIds: array_map('intval', $data['searched_ids'] ?? []),
        );
    }
}
