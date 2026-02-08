<?php

namespace App\Services;

use App\Models\SubTask;
use App\Http\Traits\HelperTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubTaskService
{
    use HelperTrait;

    public function index(Request $request): Collection|LengthAwarePaginator|array
    {
        $query = SubTask::query();

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

    public function addSubTask(Request $request)
    {
        if (SubTask::where('title', $request->title)->where('task_id', $request->task_id)->exists()) {
            throw new \InvalidArgumentException('SubTask with the same title already exists.');
        }

        $data = $this->prepareSubTaskData($request);

        return SubTask::create($data);
    }

    private function prepareSubTaskData(Request $request, bool $isNew = true): array
    {
        // Get the fillable fields from the model
        $fillable = (new SubTask())->getFillable();

        // Extract relevant fields from the request dynamically
        $data = $request->only($fillable);

        // Handle file uploads
        //$data['thumbnail'] = $this->ftpFileUpload($request, 'thumbnail', 'subTask');
        //$data['cover_picture'] = $this->ftpFileUpload($request, 'cover_picture', 'subTask');

        // Add created_by and created_at fields for new records
        if ($isNew) {
            $data['created_by'] = auth()->user()->id;
            $data['created_at'] = now();
        }

        return $data;
    }

    public function getSubTaskDetails(int $id): SubTask
    {
        return SubTask::with(['task', 'creator', 'updater'])->findOrFail($id);
    }

    public function updateSubTask(Request $request, int $id)
    {
        $subTask = SubTask::findOrFail($id);
        $updateData = $this->prepareSubTaskData($request, false);
        
         $updateData = array_filter($updateData, function ($value) {
            return !is_null($value);
        });
        $subTask->update($updateData);

        return $subTask;
    }

    public function deleteSubTask(int $id): bool
    {
        $subTask = SubTask::findOrFail($id);
        return $subTask->delete();
    }

    public function markSubTaskAsCompleted(Request $request, int $id)
    {
        $subTask = SubTask::findOrFail($id);
        $subTask->status = 'completed';
        $subTask->is_completed = true;
        $subTask->completed_at = now();
        $subTask->updated_by = Auth::id();
        $subTask->save();

        return $subTask;
    }

    public function markSubTaskAsIncomplete(Request $request, int $id)
    {
        $subTask = SubTask::findOrFail($id);
        $subTask->status = 'pending';
        $subTask->is_completed = false;
        $subTask->completed_at = null;
        $subTask->updated_by = Auth::id();
        $subTask->save();

        return $subTask;
    }

    public function allSubTaskListByTask(int $task_id)
    {
        return SubTask::with(['task', 'creator', 'updater'])->where('task_id', $task_id)->get();
    }
}
