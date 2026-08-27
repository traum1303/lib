<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\Authors\AuthorSearchDTO;
use App\DTO\Books\BookDTO;
use App\Enums\BookIssueStatus;
use App\Exceptions\BookException;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookService
{
    public function index(int $perPage = 15): LengthAwarePaginator
    {
        return Book::query()
            ->with('authors')
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function getAuthorsForCreate($authorIds = []): Collection
    {
        if (empty($authorIds)) {
            return collect();
        }

        return $this->getAuthorsByIds($authorIds);
    }

    public function getAuthorsForEdit(Book $book, array $authorIds = []): Collection
    {
        if ($authorIds !== null) {
            return $this->getAuthorsByIds($authorIds);
        }

        return $book->load('authors')->authors
            ->map(fn (Author $author) => AuthorSearchDTO::fromModel($author));
    }

    public function create(BookDTO $dto): Book
    {
        return DB::transaction(function () use ($dto) {
            $book = Book::query()->create([
                'name' => $dto->name,
                'publish_year' => $dto->publishYear,
                'isbn' => $dto->isbn,
                'total' => $dto->total,
            ]);

            $book->authors()->sync($dto->authorIds);

            return $book;
        });
    }

    public function update(Book $book, BookDTO $dto): Book
    {
        return DB::transaction(function () use ($book, $dto) {
            $book->update([
                'name' => $dto->name,
                'publish_year' => $dto->publishYear,
                'isbn' => $dto->isbn,
                'total' => $dto->total,
            ]);

            $book->authors()->sync($dto->authorIds);

            return $book->refresh();
        });
    }

    public function destroy(Book $book): void
    {
        if ($book->issues()->where('status', BookIssueStatus::ISSUED)->exists()) {
            throw new BookException(
                "Книгу «{$book->name}» нельзя удалить, пока она выдана."
            );
        }

        $book->delete();
    }

    private function getAuthorsByIds(array $ids): Collection
    {
        return Author::query()
            ->whereIn('id', $ids)
            ->get()
            ->map(fn (Author $author) => AuthorSearchDTO::fromModel($author));
    }
}
