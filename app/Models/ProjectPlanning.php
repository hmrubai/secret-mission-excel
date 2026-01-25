<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPlanning extends Model
{
    protected $fillable = [
        'project_id',
        'planning_type_id',
        'description',
        'start_date',
        'end_date',
        'duration_days',
        'exclude_weekends',
        'exclude_holidays',
        'progress',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'exclude_weekends' => 'boolean',
        'exclude_holidays' => 'boolean',
        'progress' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function planningType()
    {
        return $this->belongsTo(PlanningType::class);
    }
}
