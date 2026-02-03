<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\ProjectManpower;
use App\Http\Traits\HelperTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskService
{
    use HelperTrait;

    public function index(Request $request): Collection|LengthAwarePaginator|array
    {
        $query = Task::query();

        //condition data 
        $this->applyActive($query, $request);

        // Select specific columns
        $query->select(['*']);

        // Sorting
        $this->applySorting($query, $request);

        // Searching
        $searchKeys = ['title']; // Define the fields you want to search by
        $this->applySearch($query, $request->input('search'), $searchKeys);

        // Pagination
        return $this->paginateOrGet($query, $request);
    }

    public function addTasks(Request $request)
    {
        if (!$request->title) {
            throw new \InvalidArgumentException('Task title is required.');
        }

        if (Task::where('title', $request->title)->where('project_id', $request->project_id)->where('project_module_id', $request->project_module_id)->exists()) {
            throw new \InvalidArgumentException('Task with the same title already exists.');
        }

        $data = $this->prepareTaskData($request);

        return Task::create($data);
    }

    private function prepareTaskData(Request $request, bool $isNew = true): array
    {
        // Get the fillable fields from the model
        $fillable = (new Task())->getFillable();

        // Extract relevant fields from the request dynamically
        $data = $request->only($fillable);

        if (!$request->priority) {
            $data['priority'] = 'Low';
        }

        if($request->status == null) {
            $data['status'] = 'pending';
        }

        // Add created_by and created_at fields for new records
        if ($isNew) {
            $data['created_by'] = Auth::id();
            $data['created_at'] = now();
        }

        return $data;
    }

    public function getTaskDetails(int $id): Task
    {
        return Task::with([
            'module', 
            'creator', 
            'assignments',
            'assignments.user:id,name,email,profile_picture,user_type,phone'
        ])->findOrFail($id);
    }

    public function updateTask(Request $request, int $id)
    {
        $task = Task::findOrFail($id);
        $updateData = $this->prepareTaskData($request, false);
        
         $updateData = array_filter($updateData, function ($value) {
            return !is_null($value);
        });
        $task->update($updateData);

        return $task;
    }

    public function destroy(int $id): bool
    {
        $task = Task::findOrFail($id);
        $task->name .= '_' . Str::random(8);
        $task->deleted_at = now();

        return $task->save();
    }

    public function updateProgressAndStatus($request, int $taskId): Task 
    {
        $task = Task::findOrFail($taskId);
        $data = $request->only(['status', 'progress']);
        // Remove nulls (PATCH-style behavior)
        $data = array_filter($data, fn ($v) => $v !== null);

        /*
        * NOTE:
        * - is_completed
        * - completed_at
        * - progress = 100
        * are handled automatically in Task model booted()
        */

        $task->update($data);
        return $task->fresh();
    }

    public function markTaskAsCompleted($task_id)
    {   
        $task = Task::findOrFail($task_id);

        if ($task->status === 'completed') {
            return $task->fresh();
        }

        $task->status = 'completed';
        // Other fields like is_completed, completed_at, progress are handled in the model booted()
        $task->save();

        return $task->fresh();
    }

    public function allTaskListByModule($project_module_id)
    {
        return Task::with([
            'module', 
            'creator', 
            'assignments',
            'assignments.user:id,name,email,profile_picture,user_type,phone'
        ])->where('project_module_id', $project_module_id)->get();
    }

    public function assignMemberToTask(Request $request)
    {
        $user_id = $request->user_id;
        $task_id = $request->task_id;
        $instructions = $request->instructions ?? null;
        $is_primary = $request->is_primary ?? false;

        if (empty($user_id)) {
            throw new \InvalidArgumentException('User ID cannot be empty.');
        }

        if (empty($task_id)) {
            throw new \InvalidArgumentException('Task ID cannot be empty.');
        }

        $task = Task::findOrFail($task_id);

        if ($task->assignees()->where('user_id', $user_id)->exists()) {
            throw new \InvalidArgumentException('User is already assigned to the task.');
        }

        $task->assignUser($user_id, $is_primary, $instructions);

        return true;
    }

    public function removeMemberFromTask(Request $request)
    {
        $user_id = $request->user_id;
        $task_id = $request->task_id;

        if (empty($user_id)) {
            throw new \InvalidArgumentException('User ID cannot be empty.');
        }

        if (empty($task_id)) {
            throw new \InvalidArgumentException('Task ID cannot be empty.');
        }

        $task = Task::findOrFail($task_id);

        $task->removeUser($user_id);

        return true;
    }

    public function assignSelfToTask(Request $request): bool
    {
        $user_id = Auth::id();
        $task_id = $request->task_id;
        $instructions = $request->instructions ?? null;
        $is_primary = $request->is_primary ?? false;

        if (empty($user_id)) {
            throw new \InvalidArgumentException('User ID is required.');
        }

        if (empty($task_id)) {
            throw new \InvalidArgumentException('Task ID is required.');
        }

        $task = Task::findOrFail($task_id);

        // 1️⃣ Check if user is engaged in this project
        $isEngaged = ProjectManpower::where('project_id', $task->project_id)
            ->where('user_id', $user_id)
            ->exists();

        if (!$isEngaged) {
            throw new \InvalidArgumentException('You are not engaged in this project.');
        }

        if ($task->assignees()->where('user_id', $user_id)->exists()) {
            throw new \InvalidArgumentException('User is already assigned to the task.');
        }

        $task->assignUser($user_id, $is_primary, $instructions);

        return true;
    }
}
