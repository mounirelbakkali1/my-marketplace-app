<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends User
{
    use HasFactory;
    const TYPE = 'seller';
    protected $table = 'users';


    public function AdditionalInfo()
    {
        return $this->hasOne(AdditionalProfilSettings::class);
    }
}
