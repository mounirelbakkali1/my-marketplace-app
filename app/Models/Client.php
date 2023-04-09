<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends User
{


    use HasFactory;
    const TYPE = Role::CLIENT;
    protected $table = 'users';

    public function __construct()
    {
        $this->assignRole('client');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    // set type column to seller
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->model_type = self::TYPE;
        });
    }


}
