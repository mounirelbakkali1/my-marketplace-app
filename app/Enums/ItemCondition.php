<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class ItemCondition extends Enum
{
    const NEW = 'new';
    const USED = 'used';
    const LIKE_NEW = 'like_new';
    const GOOD = 'good';

    public static function getValues(): array
    {
        return [
            self::NEW,
            self::USED,
            self::LIKE_NEW,
            self::GOOD,
        ];
    }

}
