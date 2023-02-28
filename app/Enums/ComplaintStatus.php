<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class ComplaintStatus extends Enum
{
    const PENDING = 'pending';
    const ESCALATED = 'accepted';
    const REJECTED = 'rejected';

    public static function getValues(): array
    {
        return [
            self::PENDING,
            self::ESCALATED,
            self::REJECTED,
        ];
    }
}
