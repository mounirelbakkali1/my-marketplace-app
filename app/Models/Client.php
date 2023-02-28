<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends User
{
    use HasFactory;
    const TYPE = 'client';
    protected $table = 'users';

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
