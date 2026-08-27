<?php

namespace App\Enums;

use App\Enums\Contracts\HasLabel;

/**
 * Replaces the old GeneralConst::ADMIN / USER / ROLES constants.
 * Backed by the same tinyInteger values already stored in `users.role`,
 * so no migration/data change is required.
 */
enum UserRoleEnum: int implements HasLabel
{
    case ADMIN = 0;
    case USER = 1;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::USER => 'User',
        };
    }

    /**
     * ['value' => 'label'] map, e.g. for <select> options or old ROLES array usages.
     *
     * @return array<int, string>
     */
    public static function options(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn (self $case) => $case->label(), self::cases())
        );
    }

    /**
     * Plain list of backing values, e.g. for `in:` validation rules.
     *
     * @return array<int, int>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
