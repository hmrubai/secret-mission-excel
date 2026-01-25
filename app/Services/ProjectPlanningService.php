<?php

namespace App\Services;

use App\Models\PlanningType;
use App\Models\ProjectPlanning;
use App\Http\Traits\HelperTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    // public function index(Request $request): Collection|LengthAwarePaginator|array
    // {
    //     $query = ProjectPlanning::query();

    //     //condition data 
    //     $this->applyActive($query, $request);

    //     // Select specific columns
    //     $query->select(['*']);

    //     // Sorting
    //     $this->applySorting($query, $request);

    //     // Searching
    //     $searchKeys = ['name']; // Define the fields you want to search by
    //     $this->applySearch($query, $request->input('search'), $searchKeys);

    //     // Pagination
    //     return $this->paginateOrGet($query, $request);
    // }

    // public function store(Request $request)
    // {
    //     $data = $this->prepareProjectPlanningData($request);

    //     return ProjectPlanning::create($data);
    // }

    // private function prepareProjectPlanningData(Request $request, bool $isNew = true): array
    // {
    //     // Get the fillable fields from the model
    //     $fillable = (new ProjectPlanning())->getFillable();

    //     // Extract relevant fields from the request dynamically
    //     $data = $request->only($fillable);

    //     // Handle file uploads
    //     //$data['thumbnail'] = $this->ftpFileUpload($request, 'thumbnail', 'projectPlanning');
    //     //$data['cover_picture'] = $this->ftpFileUpload($request, 'cover_picture', 'projectPlanning');

    //     // Add created_by and created_at fields for new records
    //     if ($isNew) {
    //         $data['created_by'] = auth()->user()->id;
    //         $data['created_at'] = now();
    //     }

    //     return $data;
    // }

    // public function show(int $id): ProjectPlanning
    // {
    //     return ProjectPlanning::findOrFail($id);
    // }

    // public function update(Request $request, int $id)
    // {
    //     $projectPlanning = ProjectPlanning::findOrFail($id);
    //     $updateData = $this->prepareProjectPlanningData($request, false);
        
    //      $updateData = array_filter($updateData, function ($value) {
    //         return !is_null($value);
    //     });
    //     $projectPlanning->update($updateData);

    //     return $projectPlanning;
    // }

    // public function destroy(int $id): bool
    // {
    //     $projectPlanning = ProjectPlanning::findOrFail($id);
    //     $projectPlanning->name .= '_' . Str::random(8);
    //     $projectPlanning->deleted_at = now();

    //     return $projectPlanning->save();
    // }
}
