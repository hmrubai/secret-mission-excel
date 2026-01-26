<?php

namespace App\Services;

use App\Models\PlanningType;
use App\Models\ProjectPlanning;
use App\Models\ProjectManpower;
use App\Http\Traits\HelperTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Holiday;
use App\Models\WorkCalendar;

class ProjectPlanningService
{
    use HelperTrait;

    public function planningTypes(Request $request)
    {
        return PlanningType::where('is_active', true)->orderBy('name', 'asc')->get();
    }

    public function storePlanningTypes(Request $request)
    {
        $data = $this->preparePlanningTypeData($request, true);

        return PlanningType::create($data);
    }

    public function updatePlanningTypes(Request $request, int $id)
    {
        $planningType = PlanningType::findOrFail($id);
        $updateData = $this->preparePlanningTypeData($request, false);

        $updateData = array_filter($updateData, function ($value) {
            return !is_null($value);
        });
        $planningType->update($updateData);

        return $planningType;
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

    public function destroyPlanningType(int $id): bool
    {
        $planningType = PlanningType::findOrFail($id);
        return $planningType->delete();
    }

    public function storeProjectPlanning(Request $request)
    {
        $data = $this->prepareProjectPlanningData($request);
        return ProjectPlanning::create($data);
    }

    private function prepareProjectPlanningData(Request $request, bool $isNew = true): array
    {
        // Get the fillable fields from the model
        $fillable = (new ProjectPlanning())->getFillable();

        // Extract relevant fields from the request dynamically
        $data = $request->only($fillable);

        $data['duration_days'] = $this->workingDays($request->start_date, $request->end_date);

        // Add created_by and created_at fields for new records
        if ($isNew) {
            // $data['created_by'] = auth()->user()->id;
            $data['created_at'] = now();
        }

        return $data;
    }

    public function updateProjectPlanning(Request $request, int $id)
    {
        $projectPlanning = ProjectPlanning::findOrFail($id);
        $updateData = $this->prepareProjectPlanningData($request, false);
        
         $updateData = array_filter($updateData, function ($value) {
            return !is_null($value);
        });
        $projectPlanning->update($updateData);

        return $projectPlanning;
    }

    public function projectPlanningList($request, $project_id)
    {
        $query = ProjectPlanning::where('project_id', $project_id)
            ->with(['planningType', 'project'])
            ->orderBy('start_date', 'asc'); // order by start date

        // Optional: filter by a specific date range
        if ($request->has('from_date') && $request->has('to_date')) {
            $query->whereBetween('start_date', [$request->from_date, $request->to_date]);
        }

        return $query->get();
    }

    public function destroy(int $id): bool
    {
        $projectPlanning = ProjectPlanning::findOrFail($id);
        return $projectPlanning->delete();
    }

    public function addUserToProject(Request $request)
    {
        $projectId = $request->project_id ?? null;
        $userId = $request->user_id ?? null;

        if (!$projectId || !$userId) {
            throw new \InvalidArgumentException('Project ID and User ID are required.');
        }

        return ProjectManpower::updateOrCreate([
            'project_id' => $projectId, 
            'user_id' => $userId
        ]);
    }

    public function listProjectManpower(int $projectId)
    {
        return ProjectManpower::with('user')
            ->where('project_id', $projectId)
            ->get();
    }

    public function removeFromTheProject($request)
    {
        $projectId = $request->project_id ?? null;
        $userId = $request->user_id ?? null;

        if (!$projectId || !$userId) {
            throw new \InvalidArgumentException('Project ID and User ID are required.');
        }

        $projectManpower = ProjectManpower::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->first();

        if ($projectManpower) {
            $projectManpower->delete();
            return true;
        }

        return false;
    }

}
