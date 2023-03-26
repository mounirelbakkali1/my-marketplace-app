<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends User
{

    use HasFactory;
    const TYPE = Role::ADMIN;
    protected $table = 'users';
    // set type column to seller
    public function __construct()
    {
        $this->assignRole('admin');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->role = self::TYPE;
        });
    }
}
