<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'street',
        'zip_code',
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}
