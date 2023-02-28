<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalProfilSettings extends Model
{
    use HasFactory ;
    protected $fillable=[
        'address',
        'phone',
        'intro',
        'featured_items',
    ];
}
