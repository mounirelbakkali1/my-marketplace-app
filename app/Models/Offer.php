<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    public function Item()
    {
        return $this->belongsTo(Item::class);
    }



    public function getStartDateAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }




    protected $fillable = [
        'item_id',
        'discount',
        'start_date',
        'end_date',
    ];
}
