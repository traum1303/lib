<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\Authors\AuthorSearchDTO;
use App\DTO\Books\BookSearchDTO;
use App\DTO\Search\SearchDTO;
use App\DTO\Users\UserSearchDTO;
use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Collection;

class SearchService
{
    public function authors(SearchDTO $dto): Collection
    {
        $query = Author::query();

        if ($dto->query !== '') {
            $query->where(function ($query) use ($dto) {
                $query
                    ->where('first_name', 'like', "%{$dto->query}%")
                    ->orWhere('second_name', 'like', "%{$dto->query}%");
            });
        }

        if ($dto->excludeIds !== []) {
            $query->whereNotIn('id', $dto->excludeIds);
        }

        return $query
            ->orderBy('id')
            ->limit(10)
            ->get()
            ->map(fn (Author $author) => AuthorSearchDTO::fromModel($author));
    }

    public function books(SearchDTO $dto): Collection
    {
        $query = Book::query();

        if ($dto->query !== '') {
            $query->where(function ($query) use ($dto) {
                $query
                    ->where('name', 'like', "%{$dto->query}%")
                    ->orWhere('isbn', 'like', "%{$dto->query}%");
            });
        }

        if ($dto->excludeIds !== []) {
            $query->whereNotIn('id', $dto->excludeIds);
        }

        return $query
            ->orderBy('id')
            ->limit(10)
            ->get()
            ->map(
                fn (Book $book) =>
                BookSearchDTO::fromModel($book)
            );
    }

    public function readers(SearchDTO $dto): Collection
    {
        $query = User::query();

        if ($dto->query !== '') {
            $query->where(
                'name',
                'like',
                "%{$dto->query}%"
            );
        }

        if ($dto->excludeIds !== []) {
            $query->whereNotIn('id', $dto->excludeIds);
        }

        return $query
            ->orderBy('id')
            ->limit(10)
            ->get()
            ->map(
                fn (User $user) =>
                UserSearchDTO::fromModel($user)
            );
    }
}
