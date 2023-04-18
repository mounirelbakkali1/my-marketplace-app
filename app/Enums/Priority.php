<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class Priority extends Enum
{
    const LOW = 'low';
    const MEDIUM = 'medium';
    const HIGH = 'high';

    public static function getValues(): array
    {
        return [
            self::LOW,
            self::MEDIUM,
            self::HIGH,
        ];
    }

}
