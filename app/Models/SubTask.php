<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    protected $fillable = [
        'task_id',
        'title',
        'description',
        'status',
        'priority',
        'is_completed',
        'completed_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function booted()
    {
        static::created(function ($subTask) {
            self::updateTaskProgress($subTask->task_id);
        });

        static::updated(function ($subTask) {
            self::updateTaskProgress($subTask->task_id);
        });

        static::deleted(function ($subTask) {
            self::updateTaskProgress($subTask->task_id);
        });
    }

    private static function updateTaskProgress($taskId)
    {
        if (!$taskId) {
            return;
        }

        $task = Task::find($taskId);
        if (!$task) {
            return;
        }

        $totalSubTasks = SubTask::where('task_id', $taskId)->count();
        $completedSubTasks = SubTask::where('task_id', $taskId)
            ->where('is_completed', true)
            ->count();

        $progress = $totalSubTasks > 0 ? round(($completedSubTasks / $totalSubTasks) * 100) : 0;

        $updateData = [
            'progress' => $progress,
        ];

        if ($progress == 100) {
            $updateData['status'] = 'completed';
            $updateData['is_completed'] = true;
            $updateData['completed_at'] = now();
        } else {
            // Only update status if it was completed before, otherwise keep 'pending' or whatever it is?
            // Requirement says: "depending on the total completed subtask, the progress, is_completed, completed_at of a task will be updated like ProjectModule."
            // In ProjectModule we just updated progress.
            // But here the user provided code previously had logic to set 'in_progress'. 
            // "if (allCompleted) ... else ... 'status' => 'in_progress'"
            // So if not 100%, it should be 'in_progress' (unless it is 0%? maybe 'pending'? sticking to user's previous logic pattern which implies active tracking).
            // Actually, if I start adding subtasks, the task is effectively in progress.
            
            $updateData['status'] = 'in_progress';
            $updateData['is_completed'] = false;
            $updateData['completed_at'] = null;
        }

        $task->update($updateData);
    }
}
