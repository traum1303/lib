<?php declare(strict_types=1);

namespace App\DTO\BookIssues;

use App\Enums\BookIssueStatus;
use Carbon\CarbonImmutable;

final readonly class StoreBookIssueDTO
{
    public function __construct(
        public int $bookId,
        public int $readerId,
        public CarbonImmutable $issuedAt,
        public CarbonImmutable $returnTo,
        public BookIssueStatus $status,
    ) {}

    public static function fromArray(array $validated): self
    {
        return new self(
            bookId: (int) $validated['selected_id_book'],
            readerId: (int) $validated['selected_id_reader'],
            issuedAt: CarbonImmutable::parse($validated['issued_at']),
            returnTo: CarbonImmutable::parse($validated['return_to']),
            status: BookIssueStatus::from((int)$validated['status']),
        );
    }
}
