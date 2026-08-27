<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\BookIssues\BookIssueFilterDTO;
use App\DTO\BookIssues\BookIssueSearchDTO;
use App\DTO\BookIssues\RenderIssueModalDTO;
use App\DTO\BookIssues\StoreBookIssueDTO;
use App\DTO\BookIssues\UpdateBookIssueDTO;
use App\DTO\Books\BookSearchDTO;
use App\Exceptions\BookIssueException;
use App\Models\Book;
use App\Models\BookIssue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isInstanceOf;

class BookIssueService
{
    public function index(BookIssueFilterDTO $filters, int $perPage)
    {
        return BookIssue::query()->with(['book', 'reader'])
            ->when($filters->bookId, function (Builder $query) use ($filters) {
                $query->where('book_id', $filters->bookId);
            })
            ->when(!$filters->bookId && $filters->bookName, function (Builder $query) use ($filters) {
                $query->whereHas('book', function ($bookQuery) use ($filters) {
                    $bookQuery->where('name', 'like', '%' . $filters->bookName . '%');
                });
            })
            ->when(!$filters->bookId && $filters->bookIsbn, function (Builder $query) use ($filters) {
                $query->whereHas('book', function ($bookQuery) use ($filters) {
                    $bookQuery->where('isbn', 'like', '%' . $filters->bookIsbn . '%');
                });
            })
            ->when($filters->readerId, function (Builder $query) use ($filters) {
                $query->where('user_id', $filters->readerId);
            })
            ->when(!$filters->readerId && $filters->readerName, function (Builder $query) use ($filters) {
                $query->whereHas('reader', function ($readerQuery) use ($filters) {
                    $readerQuery->where('name', 'like', '%' . $filters->readerName . '%');
                });
            })
            ->when($filters->issuedFrom, function ($query) use ($filters) {
                $query->where('created_at', '>=', $filters->issuedFrom);
            })
            ->when($filters->issuedTo, function (Builder $query) use ($filters) {
                $query->where('created_at', '<', $filters->issuedTo);
            })
            ->when($filters->returnFrom, function (Builder $query) use ($filters) {
                $query->where('return_to', '>=', $filters->returnFrom);
            })
            ->when($filters->returnTo, function (Builder $query) use ($filters) {
                $query->where('return_to', '<', $filters->returnTo);
            })
            ->when($filters->status, function (Builder $query) use ($filters) {
                $query->where('status', $filters->status->value);
            })
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function store(StoreBookIssueDTO $dto): BookIssue
    {
        return DB::transaction(function () use ($dto) {
            $book = Book::query()->lockForUpdate()->findOrFail($dto->bookId);

            if ($book->total <= 0) {
                throw new BookIssueException(
                    "Больше не осталось экземпляров книги «{$book->name}» для выдачи"
                );
            }

            $book->decrement('total');

            try {
                return BookIssue::query()->create([
                    'book_id' => $book->id,
                    'user_id' => $dto->readerId,
                    'return_to' => $dto->returnTo,
                    'created_at' => $dto->issuedAt,
                    'status' => $dto->status,
                ]);
            } catch (QueryException|UniqueConstraintViolationException $e) {

                $msg = "Не удалось оформить выдачу книги «{$book->name}».";

                if ($e instanceOf UniqueConstraintViolationException) {
                    $msg .= ' Такая выдача уже существует для выбранного пользователя.';
                }

                throw new BookIssueException(
                    $msg,
                    previous: $e
                );
            }
        });
    }

    public function update(BookIssue $issue, UpdateBookIssueDTO $dto): BookIssue
    {
        $issue->update([
            'return_to' => $dto->returnTo,
            'created_at' => $dto->issuedAt,
            'status' => $dto->status,
        ]);

        return $issue->refresh();
    }

    public function destroy(BookIssue $issue): string
    {
        return DB::transaction(function () use ($issue) {
            $issue->load('book');

            $book = Book::query()
                ->whereKey($issue->book_id)
                ->lockForUpdate()
                ->firstOrFail();

            $book->increment('total');

            $issue->delete();

            return $book->name;
        });
    }

    public function renderModal(RenderIssueModalDTO $dto): array
    {
        return match ($dto->type) {
            'issue' => [
                'bookIssue' => BookIssueSearchDTO::fromModel(
                    BookIssue::query()->with(['book', 'reader'])->findOrFail($dto->id)
                ),
            ],

            'book' => [
                'book' => BookSearchDTO::fromModel(
                    Book::query()->findOrFail($dto->id)
                ),
            ],

            default => [],
        };
    }

}
