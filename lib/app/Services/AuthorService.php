<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\Authors\AuthorDTO;
use App\DTO\Authors\AuthorIndexDTO;
use App\DTO\Books\BookSearchDTO;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AuthorService
{
    public function index(int $perPage = 15): LengthAwarePaginator
    {
        return Author::query()
            ->with('books')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->through(fn (Author $author) => AuthorIndexDTO::fromModel($author));
    }

    public function getBooksForCreate(array $bookIds = []): Collection
    {
        if (empty($bookIds)) {
            return collect();
        }

        return $this->getBooksByIds($bookIds);
    }

    public function getBooksForEdit(Author $author, array $bookIds = []): Collection
    {
        if (!empty($bookIds)) {
            return $this->getBooksByIds($bookIds);
        }

        return $author->load('books')->books
            ->map(fn (Book $book) => BookSearchDTO::fromModel($book));
    }

    public function create(AuthorDTO $dto): Author
    {
        return DB::transaction(function () use ($dto) {
            $author = Author::query()->create([
                'first_name' => $dto->firstName,
                'second_name' => $dto->secondName,
                'gender' => $dto->gender,
            ]);

            $author->books()->sync($dto->bookIds);

            return $author;
        });
    }

    public function update(Author $author, AuthorDTO $dto): Author
    {
        return DB::transaction(function () use ($author, $dto) {
            $author->update([
                'first_name' => $dto->firstName,
                'second_name' => $dto->secondName,
                'gender' => $dto->gender,
            ]);

            $author->books()->sync($dto->bookIds);

            return $author->refresh();
        });
    }

    public function destroy(Author $author): void
    {
        $author->delete();
    }

    private function getBooksByIds(array $ids): Collection
    {
        return Book::query()
            ->whereIn('id', $ids)
            ->get()
            ->map(fn (Book $book) => BookSearchDTO::fromModel($book));
    }
}
