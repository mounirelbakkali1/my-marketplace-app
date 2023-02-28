<?php

namespace App\Models;

class FeaturedItem extends Item
{
    const TYPE = 'featured_item';
    protected $table = 'items';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $attributes['type'] = static::TYPE;
    }
}
