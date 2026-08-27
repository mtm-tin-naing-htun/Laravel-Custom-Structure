<?php

namespace App\Enums;

use App\Enums\Contracts\HasLabel;

/**
 * Replaces the old GeneralConst::UNLOCK / LOCK / LOCK_STATUS constants.
 *
 * Note: the original LOCK_STATUS array labelled both values as
 * 'Admin' / 'User' (a copy-paste bug from ROLES). That is fixed here.
 */
enum LockStatusEnum: int implements HasLabel
{
    case UNLOCK = 0;
    case LOCK = 1;

    public function label(): string
    {
        return match ($this) {
            self::UNLOCK => 'Unlocked',
            self::LOCK => 'Locked',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function options(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn (self $case) => $case->label(), self::cases())
        );
    }
}
