<?php declare(strict_types=1);

namespace App\DTO\BookIssues;

use App\Enums\BookIssueStatus;
use Carbon\CarbonImmutable;

final readonly class UpdateBookIssueDTO
{
    public function __construct(
        public CarbonImmutable $issuedAt,
        public ?CarbonImmutable $returnTo,
        public BookIssueStatus $status,
    ) {}

    public static function fromArray(array $validated): self
    {
        return new self(
            issuedAt: CarbonImmutable::parse($validated['issued_at']),
            returnTo: CarbonImmutable::parse($validated['return_to']),
            status: BookIssueStatus::from((int)$validated['status']),
        );
    }
}
