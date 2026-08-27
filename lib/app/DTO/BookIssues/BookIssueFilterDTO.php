<?php declare(strict_types=1);

namespace App\DTO\BookIssues;

use App\Enums\BookIssueStatus;
use App\Http\Requests\BookIssueIndexRequest;
use Carbon\CarbonImmutable;

final readonly class BookIssueFilterDTO
{
    public function __construct(
        public ?int $bookId,
        public ?string $bookName,
        public ?string $bookIsbn,

        public ?int $readerId,
        public ?string $readerName,

        public ?CarbonImmutable $issuedFrom,
        public ?CarbonImmutable $issuedTo,

        public ?CarbonImmutable $returnFrom,
        public ?CarbonImmutable $returnTo,

        public ?BookIssueStatus $status,
    ) {}

    public static function fromRequest(BookIssueIndexRequest $request): self
    {
        $data = $request->validated();
        return new self(
            bookId: isset($data['selected_id_book']) ? (int) $data['selected_id_book'] : null,
            bookName: $data['book_name'] ?? null,
            bookIsbn: $data['book_isbn'] ?? null,
            readerId: isset($data['selected_id_reader']) ? (int) $data['selected_id_reader'] : null,
            readerName: $data['reader_name'] ?? null,
            issuedFrom: isset($data['issued_from']) ? CarbonImmutable::parse($data['issued_from'])->startOfDay() : null,
            issuedTo: isset($data['issued_to']) ? CarbonImmutable::parse($data['issued_to'])->addDay()->startOfDay() : null,
            returnFrom: isset($data['return_from']) ? CarbonImmutable::parse($data['return_from'])->startOfDay() : null,
            returnTo: isset($data['return_to']) ? CarbonImmutable::parse($data['return_to'])->addDay()->startOfDay() : null,
            status: !empty($data['status']) ? BookIssueStatus::from((int)$data['status']) : null,
        );
    }
}
