<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;


    public function Users()
    {
        return $this->belongsToMany(User::class);
    }

    public function Messages()
    {
        return $this->HasMany(Message::class);
    }
}
