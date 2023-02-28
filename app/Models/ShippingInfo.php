<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingInfo extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function adress(){
        return $this->hasOne(Adress::class);
    }



    protected $fillable = [
        'name',
        'phone',
        'address',
    ];
}
