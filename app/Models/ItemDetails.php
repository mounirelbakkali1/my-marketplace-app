<?php

namespace App\Models;

use App\Enums\ItemCondition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function explode;

class ItemDetails extends Model
{
    use HasFactory;

    protected $fillable=[
        'item_id',
        'color',
        'size',
        'stock',
        'description',
        'condition',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getSizeAttribute($value)
    {
        return explode(',',$value)[0] . ' x ' . explode(',',$value)[1] . ' cm';
    }

   /* protected $casts = [
        'condition' => ItemCondition::class,
    ];*/
}
