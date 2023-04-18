<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ComplaintResolved extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'complaints_resolved';

    protected $fillable = [
        'complaint_id',
        'resolved_by',
        'resolved_note',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->useLogName('Employee')
            ->setDescriptionForEvent(fn(string $eventName) => "This employee has resolved a complaint.");
    }
}
