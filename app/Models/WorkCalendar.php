<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkCalendar extends Model
{
    protected $table = 'work_calendars';

    protected $fillable = [
        'weekends',
        'work_start_time',
        'work_end_time',
        'is_active',
    ];

    protected $casts = [
        'weekends'        => 'array',   // JSON → array [0–6]
        'work_start_time' => 'string',  // HH:MM
        'work_end_time'   => 'string',  // HH:MM
        'is_active'       => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($calendar) {
            if ($calendar->is_active) {
                static::where('id', '!=', $calendar->id)
                    ->update(['is_active' => false]);
            }
        });
    }
}
