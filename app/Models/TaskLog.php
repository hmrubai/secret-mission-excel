<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'action',
        'old_value',
        'new_value',
    ];

    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
