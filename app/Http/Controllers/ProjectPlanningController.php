<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\StorePlanningTypeRequest;
use App\Http\Requests\UpdatePlanningTypeRequest;
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
}
