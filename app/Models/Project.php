<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'project_type_id',
        'vendor_id',
        'priority',
        'start_date',
        'end_date',
        'onhold_postponed_date',
        'deadline',
        'status',
        'progress',
        'is_archived',
    ];

    protected $casts = [
        'deadline' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'onhold_postponed_date' => 'date',
        'progress' => 'integer',
        'is_archived' => 'boolean',
    ];

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
