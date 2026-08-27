<?php declare(strict_types=1);

namespace App\DTO\BookIssues;

final readonly class RenderIssueModalDTO
{
    public function __construct(
        public string $type,
        public ?int $id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            id: isset($data['id']) ? (int) $data['id'] : null
        );
    }
}
