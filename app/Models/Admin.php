<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends User
{
    use HasFactory;
    const TYPE = 'admin';
    protected $table = 'users';
}
