<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function asset;

class Image extends Model
{
    use HasFactory;
    protected $fillable=[
        'image',
        'item_id',
    ];

    public function getImgeAttribute($value)
    {
        return asset('storage/items/'.$value);
    }
}
