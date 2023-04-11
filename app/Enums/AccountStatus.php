<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class AccountStatus extends Enum
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const SUSPENDED = 'suspended';
    const BANNED = 'banned';

    public static function getValues(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
            self::SUSPENDED,
            self::BANNED,
        ];
    }
}
