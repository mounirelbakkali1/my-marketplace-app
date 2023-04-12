<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class ItemStatus extends Enum
{
    const AVAILABLE = 'available';
    const SOLD = 'sold';
    const PENDING = 'pending';
    const SUSPENDED = 'suspended';

    public static function getValues(): array
    {
        return [
            self::AVAILABLE,
            self::SOLD,
            self::PENDING,
            self::SUSPENDED,
        ];
    }
}
