<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectHistory;
use App\Http\Traits\HelperTrait;
use App\Models\PlanningType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectService
{
    use HelperTrait;

    public function index(Request $request): Collection|LengthAwarePaginator|array
    {
        $query = Project::query();

        //condition data 
        $this->applyActive($query, $request);

        // Select specific columns
        $query->select(['*']);

        // Sorting
        $this->applySorting($query, $request);

        $query->with(['vendor', 'projectType', 'createdBy']);

        // Searching
        $searchKeys = ['name']; // Define the fields you want to search by
        $this->applySearch($query, $request->input('search'), $searchKeys);

        // Pagination
        return $this->paginateOrGet($query, $request);
    }

    public function store(Request $request)
    {
        $data = $this->prepareProjectData($request);

        return Project::create($data);
    }

    private function prepareProjectData(Request $request, bool $isNew = true): array
    {
        // Get the fillable fields from the model
        $fillable = (new Project())->getFillable();

        // Extract relevant fields from the request dynamically
        $data = $request->only($fillable);              

        // Handle file uploads
        //$data['thumbnail'] = $this->ftpFileUpload($request, 'thumbnail', 'project');
        //$data['cover_picture'] = $this->ftpFileUpload($request, 'cover_picture', 'project');

        // Add created_by and created_at fields for new records
        if ($isNew) {
            $data['created_by'] = Auth::id();
            $data['created_at'] = now();
        }

        return $data;
    }

    private function preparePlanningTypeData(Request $request, bool $isNew = true): array
    {
        // Get the fillable fields from the model
        $fillable = (new PlanningType())->getFillable();

        // Extract relevant fields from the request dynamically
        $data = $request->only($fillable);              

        // Handle file uploads
        //$data['thumbnail'] = $this->ftpFileUpload($request, 'thumbnail', 'project');
        //$data['cover_picture'] = $this->ftpFileUpload($request, 'cover_picture', 'project');

        // Add created_by and created_at fields for new records
        if ($isNew) {
            // $data['created_by'] = Auth::id();
            $data['created_at'] = now();
        }

        return $data;
    }

    public function show(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function update(Request $request, int $id)
    {
        $project = Project::findOrFail($id);
        $updateData = $this->prepareProjectData($request, false);

        $updateData = array_filter($updateData, function ($value) {
            return !is_null($value);
        });
        $project->update($updateData);

        return $project;
    }

    public function destroy(int $id): bool
    {
        $project = Project::findOrFail($id);
        return $project->delete();
    }

    public function myProjects()
    {
        $userId = Auth::id();

        $projects = Project::whereHas('projectManpower', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with([
            'vendor', 
            'projectType', 
            'createdBy', 
            'ProjectModules', 
            'ProjectPlanning', 
            'ProjectPlanning.planningType:id,name,description', 
            'histories', 
            'projectManpower',
            'projectManpower.user:id,name,email,profile_picture,user_type,phone'
        ])
        ->get();

        return $projects;
    }

    public function projectDetails($project_id)
    {
        return Project::with([
            'vendor', 
            'projectType', 
            'createdBy', 
            'ProjectModules', 
            'ProjectPlanning', 
            'ProjectPlanning.planningType:id,name,description', 
            'histories', 
            'projectManpower',
            'projectManpower.user:id,name,email,profile_picture,user_type,phone'
        ])->findOrFail($project_id);
    }

    public function projectDetailsForCalender($project_id)
    {
        $project = Project::with([
            'vendor', 
            'projectType', 
            'createdBy', 
            'ProjectModules', 
            'ProjectPlanning', 
            'ProjectPlanning.planningType:id,name,description', 
            'histories', 
            'projectManpower',
            'projectManpower.user:id,name,email,profile_picture,user_type,phone',
            'tasks',
            'tasks.assignments',
            'tasks.assignments.user:id,name,email,profile_picture,user_type,phone',
        ])->findOrFail($project_id);

        $totalTasks = $project->tasks->count();
        $completedTasks = $project->tasks->where('status', 'completed')->count();
        
        $projectModules = $project->ProjectModules;
        $pendingModules = $projectModules->where('status', 'pending')->count();
        $inProgressModules = $projectModules->where('status', 'in_progress')->count(); // Assuming 'in_progress' is the status string
        $completedModules = $projectModules->where('status', 'completed')->count(); // Assuming 'completed' is the status string
        
        // You can attach these as custom attributes or return a new structure.
        // Attaching to the object as dynamic properties
        $project->total_tasks_count = $totalTasks;
        $project->completed_tasks_count = $completedTasks;
        $project->task_completion_percentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;
        $project->modules_pending_count = $pendingModules;
        $project->modules_in_progress_count = $inProgressModules;
        $project->modules_completed_count = $completedModules;

        // 1. Task Completion Graph (Last 15 days)
        $graphData = [
            'dates' => [],
            'values' => []
        ];
        
        // Ensure Carbon is imported or use full path properly. HelperTrait likely uses Carbon.
        // Assuming Carbon\Carbon is accessible or alias present. The file uses Carbon\Carbon.
        for ($i = 14; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            
            // Count completed tasks for this specific date
            // Note: This query inside loop might be N+1 issue if efficient, but for single project details it's acceptable or can be optimized by grouping.
            // Optimization: Filter from the already loaded tasks collection if tasks list is not huge, or run a single aggregate query.
            // Since we have $project->tasks eager loaded, let's filter the collection to avoid DB hits in loop.
            
            $count = $project->tasks->filter(function ($task) use ($date) {
                return $task->status === 'completed' && 
                       $task->completed_at && 
                       \Carbon\Carbon::parse($task->completed_at)->format('Y-m-d') === $date;
            })->count();

            $graphData['dates'][] = $date;
            $graphData['values'][] = $count;
        }
        $project->task_completion_graph = $graphData;

        // 2. Gantt Chart Data
        $ganttData = $project->tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'name' => $task->title,
                'start' => $task->start_date ? $task->start_date->format('Y-m-d') : null,
                'end' => $task->deadline ? $task->deadline->format('Y-m-d') : null,
                'progress' => $task->progress ?? 0,
                'status' => $task->status,
                // Add subtasks or specific gantt fields if needed, e.g. type: 'task', parents...
            ];
        })->values(); // reset keys
        
        $project->gantt_chart_data = $ganttData;

        return $project;
    }
}