<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\StorePlanningTypeRequest;
use App\Http\Requests\UpdatePlanningTypeRequest;
use App\Http\Requests\StoreProjectPlanningRequest;
use App\Http\Requests\UpdateProjectPlanningRequest;
use App\Http\Requests\StoreProjectModuleRequest;
use App\Http\Requests\UpdateProjectModuleRequest;
use Illuminate\Validation\ValidationException;
use App\Services\ProjectPlanningService;

class ProjectPlanningController extends Controller
{
    use HelperTrait;
    protected $service;

    public function __construct(ProjectPlanningService $service)
    {
        $this->service = $service;
    }

    public function planningTypes(Request $request)
    {
        try {
            $data = $this->service->planningTypes($request);

            return $this->successResponse($data, 'Planning Type List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storePlanningTypes(StorePlanningTypeRequest $request)
    {
        try {
            $data = $this->service->storePlanningTypes($request);

            return $this->successResponse($data, 'Planning Type created successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePlanningTypes(UpdatePlanningTypeRequest $request, $id)
    {
        try {
            $data = $this->service->updatePlanningTypes($request, $id);

            return $this->successResponse($data, 'Planning Type updated successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deletePlanningTypes($id)
    {
        try {
            $this->service->destroyPlanningType($id);

            return $this->successResponse(null, 'Planning Type deleted successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function projectPlanningList(Request $request, $project_id)
    {
        try {
            $data = $this->service->projectPlanningList($request, $project_id);

            return $this->successResponse($data, 'Project Planning List retrieved successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storeProjectPlanning(StoreProjectPlanningRequest $request)
    {
        try {
            $data = $this->service->storeProjectPlanning($request);

            return $this->successResponse($data, 'Project Planning created successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateProjectPlanning(UpdateProjectPlanningRequest $request, $id)
    {
        try {
            $data = $this->service->updateProjectPlanning($request, $id);

            return $this->successResponse($data, 'Project Planning updated successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroyProjectPlanning($id)
    {
        try {
            $this->service->destroy($id);

            return $this->successResponse(null, 'Project Planning deleted successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addUserToProject(Request $request)
    {
        try {
            $data = $this->service->addUserToProject($request);

            return $this->successResponse($data, 'User added successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function listProjectManpower(Request $request, $project_id)
    {
        try {
            $data = $this->service->listProjectManpower($project_id);

            return $this->successResponse($data, 'Project User list successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function removeFromTheProject(Request $request)
    {
        try {
            $data = $this->service->removeFromTheProject($request);

            return $this->successResponse($data, 'User removed successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storeProjectModule(StoreProjectModuleRequest $request)
    {
        try {
            $data = $this->service->storeProjectModule($request);

            return $this->successResponse($data, 'User added successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateProjectModule(UpdateProjectModuleRequest $request, $id)
    {
        try {
            $data = $this->service->updateProjectModule($request, $id);

            return $this->successResponse($data, 'User updated successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteProjectModule($id)
    {
        try {
            $this->service->destroyProjectModule($id);

            return $this->successResponse(null, 'Project Module deleted successfully', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function projectModuleList($projectId)
    {
        try {
            $data = $this->service->projectModulesList($projectId);

            return $this->successResponse($data, 'Project Module List successful', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
