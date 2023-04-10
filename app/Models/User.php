<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes,HasRoles,LogsActivity;

    const TYPE = Role::CLIENT;

    protected $guard_name = 'api';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'updated_at',
        'deleted_at',
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
            $model->model_type = self::TYPE;
        });
    }


    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }




    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        $roles = $this->roles->pluck('name');
        return [
            'email' => $this->email,
            'role' => count($roles) > 0 ? $roles[0] : null,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->useLogName('User')
            ->setDescriptionForEvent(fn(string $eventName) => "This user {$eventName}.");
    }
}
