<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class PlanningType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected static function booted()
    {
        static::creating(function ($type) {
            $type->slug = Str::slug($type->name);
        });

        static::updating(function ($type) {
            if ($type->isDirty('name')) {
                $type->slug = Str::slug($type->name);
            }
        });
    }

    public function plannings()
    {
        return $this->hasMany(ProjectPlanning::class);
    }
}
