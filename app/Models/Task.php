<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{   
    protected $fillable = [
        'project_id',
        'project_module_id',
        'title',
        'description',
        'status',
        'start_date',
        'deadline',
        'is_completed',
        'completed_at',
        'priority',
        'progress',
        'created_by',
    ];

    protected $casts = [
        'start_date'   => 'date',
        'deadline'     => 'date',
        'is_completed' => 'boolean',
        'progress'     => 'integer',
    ];


    /* ---------------- Relations ---------------- */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function module()
    {
        return $this->belongsTo(ProjectModule::class, 'project_module_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_assignments')
            ->withPivot(['is_primary', 'assigned_at'])
            ->withTimestamps();
    }

    public function logs()
    {
        return $this->hasMany(TaskLog::class);
    }

    /* =======================
     | Assignment Methods
     ======================= */

    /**
     * Assign a user to the task
     */
    public function assignUser(int $userId, bool $isPrimary = false, $instructions = null): void
    {
        $this->assignees()->syncWithoutDetaching([
            $userId => [
                'is_primary' => $isPrimary,
                'assigned_at' => now(),
                'instructions' => $instructions,
            ]
        ]);

        // Optional: Log assignment
        $this->logs()->create([
            'user_id' => Auth::id(),
            'action'  => 'assigned',
            'new_value' => [
                'assigned_user_id' => $userId,
                'is_primary' => $isPrimary,
            ],
        ]);
    }

    /**
     * Remove a user from the task
     */
    public function removeUser(int $userId): void
    {
        $this->assignees()->detach($userId);

        // Optional: Log removal
        $this->logs()->create([
            'user_id' => Auth::id(),
            'action'  => 'unassigned',
            'old_value' => [
                'removed_user_id' => $userId,
            ],
        ]);
    }

    /* ---------------- Model Events ---------------- */

    protected static function booted()
    {
        /**
         * BEFORE UPDATE
         * Handle status → completion logic
         */
        static::updating(function (Task $task) {

            // If status changed to completed
            if ($task->isDirty('status') && $task->status === 'completed') {
                $task->is_completed = true;
                $task->completed_at = now();
                $task->progress = 100;
            }

            // If task reopened from completed
            if (
                $task->isDirty('status') &&
                $task->getOriginal('status') === 'completed' &&
                $task->status !== 'completed'
            ) {
                $task->is_completed = false;
                $task->completed_at = null;
            }
        });

        /**
         * AFTER CREATE
         */
        static::created(function (Task $task) {
            TaskLog::create([
                'task_id' => $task->id,
                'user_id' => Auth::id() ?? $task->created_by,
                'action'  => 'created',
                'new_value' => $task->fresh()->toArray(),
            ]);
        });

        /**
         * AFTER UPDATE
         */
        static::updated(function (Task $task) {

            $changes = $task->getChanges();
            $original = $task->getOriginal();

            // Remove noise fields
            unset($changes['updated_at']);

            if (empty($changes)) {
                return;
            }

            TaskLog::create([
                'task_id'   => $task->id,
                'user_id'   => Auth::id(),
                'action'    => 'updated',
                'old_value' => array_intersect_key($original, $changes),
                'new_value' => $changes,
            ]);
        });
    }
}
