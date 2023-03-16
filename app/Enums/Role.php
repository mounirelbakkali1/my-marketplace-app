<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class Role extends Enum
{
    const ADMIN = 'admin';
    const SELLER = 'seller';
    const EMPLOYEE = 'employee';
    const CLIENT = 'client';

    public static function getValues(): array
    {
        return [
            self::ADMIN,
            self::SELLER,
            self::CLIENT,
            self::EMPLOYEE,
        ];
    }
}
