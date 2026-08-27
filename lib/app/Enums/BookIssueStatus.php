<?php

namespace App\Enums;

enum BookIssueStatus: int
{
    case LOST = 0;
    case ISSUED = 1;
    case OVERDUE = 2;
    case REPLACED = 3;

    public function toText(): string
    {
        return match ($this) {
            self::LOST => 'Утеряна',
            self::ISSUED => 'Выдана',
            self::OVERDUE => 'Просрочена',
            self::REPLACED => 'Замена',
        };
    }

    public static function fromRequest(?string $value): ?self
    {
        return match ($value) {
            '0' => self::LOST,
            '1' => self::ISSUED,
            '2' => self::OVERDUE,
            '3' => self::REPLACED,
            default => null,
        };
    }
}
