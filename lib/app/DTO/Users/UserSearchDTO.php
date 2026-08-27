<?php declare(strict_types=1);

namespace App\DTO\Users;

use App\Models\User;

final readonly class UserSearchDTO
{
    public int $id;
    public string $searchValue;
    public array $hiddenValues;

    public function __construct(
         int $id,
         string $searchValue,
    ) {
        $this->id = $id;
        $this->searchValue = $searchValue;
        $this->hiddenValues = ['reader_name' => $searchValue];
    }

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            searchValue: $user->name,
        );
    }
}
