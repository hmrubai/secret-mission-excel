<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'holidays';

    protected $fillable = [
        'date',
        'title',
        'type',
        'is_active',
    ];

    protected $casts = [
        'date'      => 'date',
        'title'     => 'string',
        'type'      => 'string',
        'is_active' => 'boolean',
    ];
}
