<?php declare(strict_types=1);

namespace App\DTO\BookIssues;

use App\DTO\Books\BookSearchDTO;
use App\DTO\Users\UserSearchDTO;
use App\Enums\BookIssueStatus;
use App\Models\BookIssue;

final readonly class BookIssueSearchDTO
{
    public function __construct(
        public int $id,
        public string $returnTo,
        public string $issuedAt,
        public BookIssueStatus $status,
        public BookSearchDTO $book,
        public UserSearchDTO $reader
    ) {}

    public static function fromModel(BookIssue $bookIssue): self
    {
        return new self(
            id: $bookIssue->id,
            returnTo: $bookIssue->return_to->format('Y-m-d'),
            issuedAt: $bookIssue->created_at->format('Y-m-d'),
            status: $bookIssue->status,
            book: BookSearchDTO::fromModel($bookIssue->book),
            reader: UserSearchDTO::fromModel($bookIssue->reader)
        );
    }
}
