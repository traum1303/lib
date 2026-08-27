<?php declare(strict_types=1);

namespace App\DTO\Search;

final readonly class SearchDTO
{
    public function __construct(
        public string $query,
        public array $excludeIds,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            query: trim((string) ($data['query'] ?? '')),
            excludeIds: array_map('intval', $data['exclude'] ?? []),
        );
    }
}
