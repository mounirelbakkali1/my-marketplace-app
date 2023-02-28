<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class ItemStatus extends Enum
{
    const AVAILABLE = 'available';
    const SOLD = 'sold';
    const PENDING = 'pending';

    public static function getValues(): array
    {
        return [
            self::AVAILABLE,
            self::SOLD,
            self::PENDING,
        ];
    }
}
