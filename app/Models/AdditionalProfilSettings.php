<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalProfilSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'intro',
        'featured_items',
    ];

    public function FeaturedItems()
    {
        return $this->hasMany(FeaturedItem::class);
    }
    public function address()
    {
        return $this->hasOne(Address::class);
    }

}
// what is my username for github?































