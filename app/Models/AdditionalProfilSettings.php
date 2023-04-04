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
    protected $hidden = [
        'seller_id',
        'address_id',
        'id',
        'created_at',
        'updated_at',
    ];

    public function FeaturedItems()
    {
        return $this->hasMany(FeaturedItem::class);
    }
    public function address()
    {
        return $this->hasOne(Address::class,'id','address_id');
    }
    public function seller()
    {
        return $this->hasOne(Seller::class, 'id', 'seller_id');
    }

}































