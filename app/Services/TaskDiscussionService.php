<?php

namespace App\Services;

use App\Models\TaskDiscussion;
use App\Http\Traits\HelperTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskDiscussionService
{
    use HelperTrait;

    public function index(Request $request): Collection|LengthAwarePaginator|array
    {
        $query = TaskDiscussion::query();

        //condition data 
        $this->applyActive($query, $request);

        // Select specific columns
        $query->select(['*']);

        // Sorting
        $this->applySorting($query, $request);

        // Searching
        $searchKeys = ['message', 'task_id']; // Define the fields you want to search by
        $this->applySearch($query, $request->input('search'), $searchKeys);

        // Pagination
        return $this->paginateOrGet($query, $request);
    }

    public function addTaskDiscussion(Request $request)
    {
        $data = $this->prepareTaskDiscussionData($request);

        return TaskDiscussion::create($data);
    }

    private function prepareTaskDiscussionData(Request $request, bool $isNew = true): array
    {
        // Get the fillable fields from the model
        $fillable = (new TaskDiscussion())->getFillable();

        // Extract relevant fields from the request dynamically
        $data = $request->only($fillable);

        // Handle file uploads
        //$data['thumbnail'] = $this->ftpFileUpload($request, 'thumbnail', 'taskDiscussion');
        //$data['cover_picture'] = $this->ftpFileUpload($request, 'cover_picture', 'taskDiscussion');

        // Add created_by and created_at fields for new records
        if ($isNew) {
            $data['user_id'] = Auth::id();
            $data['created_at'] = now();
        }

        return $data;
    }

    public function show(int $id): TaskDiscussion
    {
        return TaskDiscussion::findOrFail($id);
    }

    public function update(Request $request, int $id)
    {
        $taskDiscussion = TaskDiscussion::findOrFail($id);
        $updateData = $this->prepareTaskDiscussionData($request, false);
        
         $updateData = array_filter($updateData, function ($value) {
            return !is_null($value);
        });
        $taskDiscussion->update($updateData);

        return $taskDiscussion;
    }

    public function destroy(int $id): bool
    {
        $taskDiscussion = TaskDiscussion::findOrFail($id);
        return $taskDiscussion->delete();
    }

    public function getTaskDiscussionsByTaskId(int $taskId)
    {
        return TaskDiscussion::where('task_id', $taskId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
