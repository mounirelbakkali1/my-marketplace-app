<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends User
{
    use HasFactory;
    const TYPE = Role::SELLER;
    protected $table = 'users';




    public function AdditionalInfo()
    {
        return $this->hasOne(AdditionalProfilSettings::class);
    }
    // set type column to seller
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->role = self::TYPE;
        });
    }

}
