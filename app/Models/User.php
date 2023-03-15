<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const TYPE = Role::CLIENT;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $attributes['type'] = static::TYPE;
    }

    // set type column to seller
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->role = self::TYPE;
        });
    }


    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }
}
