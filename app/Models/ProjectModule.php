<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModule extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'description',
        'estimated_days',
        'created_by',
    ];

    protected $casts = [
        'estimated_days' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
