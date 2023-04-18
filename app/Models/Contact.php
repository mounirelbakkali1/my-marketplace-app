<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Contact extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'contacts';
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'priority',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->useLogName('User')
            ->setDescriptionForEvent(fn(string $eventName) => "This user {$eventName}. a contact.");
    }
}
