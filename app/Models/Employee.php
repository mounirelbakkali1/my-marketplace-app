<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends User
{
    use HasFactory;
    const TYPE = Role::EMPLOYEE;
    protected $table = 'users';
    // set type column to seller
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->role = self::TYPE;
        });
    }
}
