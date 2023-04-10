<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Admin extends User
{

    use HasFactory , HasRoles;
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
            $model->model_type = self::TYPE;
        });
    }
}
