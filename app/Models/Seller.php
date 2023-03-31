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

    /*public function __construct()
    {
        parent::__construct();
        $this->assignRole('seller');
    }*/


    public function AdditionalInfo()
    {
        return $this->hasOne(AdditionalProfilSettings::class,"seller_id","id");
    }
    // set type column to seller
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->role = self::TYPE;
        });
    }

}
