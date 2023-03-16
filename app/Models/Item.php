<?php

namespace App\Models;

use App\Enums\ItemStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use willvincent\Rateable\Rateable;

class Item extends Model
{
    use HasFactory, SoftDeletes , Rateable;
    const TYPE = 'item';


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $attributes['type'] = static::TYPE;
    }

    public function Seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
    public function Collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function ItemDetails()
    {
        return $this->hasOne(ItemDetails::class);
    }

    protected $fillable=[
            'name',
            'price',
            'primary_image',
            'status',
            'category_id',
            'collection_id',
            'seller_id',
    ];

    public function getPriceAttribute($value)
    {
        return number_format($value, 2).' DH';
    }

    public function getPrimaryImageAttribute($value)
    {
        return asset('storage/items/'.$value);
    }
    protected $casts = [
        'status' => ItemStatus::class,
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];

}
