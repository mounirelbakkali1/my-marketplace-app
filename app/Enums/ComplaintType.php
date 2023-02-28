<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class ComplaintType extends Enum
{
    const PRODUCT_QUALITY = 'product_quality';
    const SERVICE_QUALITY = 'service_quality';
    const DELIVERY_ISSUE = 'delivery_issue';
    const OTHER = 'other';

    public static function getValues(): array
    {
        return [
            self::PRODUCT_QUALITY,
            self::SERVICE_QUALITY,
            self::DELIVERY_ISSUE,
            self::OTHER,
        ];
    }
}
