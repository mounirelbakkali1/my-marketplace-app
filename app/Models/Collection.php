<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'image',
        'description'
    ];
    public function Items()
    {
        return $this->hasMany(Item::class);
    }
}
